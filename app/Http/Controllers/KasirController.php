<?php

namespace App\Http\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelKategori;
use App\Models\ModelMember;
use App\Models\ModelTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class KasirController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori
        $kategori = ModelKategori::all();

        // Filter barang berdasarkan kategori yang dipilih
        $barangQuery = ModelBarang::query();

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $barangQuery->where('kategori_id', $request->kategori_id);
        }

        // Dapatkan hasil barang yang telah difilter
        $barang = $barangQuery->get();

        // Kirim data ke view
        return view('kasir.index', compact('kategori', 'barang'));
    }

    public function tambahKeKeranjang(Request $request)
    {
        $barang = ModelBarang::find($request->barang_id); // Temukan barang berdasarkan ID
        $keranjang = session()->get('keranjang', []);

        // Jika barang sudah ada di keranjang, tambahkan jumlahnya
        if (isset($keranjang[$barang->barang_id])) {
            $keranjang[$barang->barang_id]['jumlah']++;
        } else {
            // Jika barang belum ada, tambahkan ke keranjang
            $keranjang[$barang->barang_id] = [
                'nama' => $barang->nama_barang,
                'harga' => $barang->harga,
                'jumlah' => 1,
                'subtotal' => $barang->harga
            ];
        }

        session()->put('keranjang', $keranjang); // Simpan keranjang ke session

        return redirect()->route('kasir.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
    }

    public function bayar()
    {
        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Jika keranjang kosong, redirect dengan pesan notifikasi
        if (empty($keranjang)) {
            return redirect()->route('kasir.index')->with('error', 'Keranjang masih kosong');
        }

        // Hitung subtotal
        $subtotal = array_reduce($keranjang, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);

        return view('kasir.bayar', compact('keranjang', 'subtotal'));
    }


    public function updateKeranjang(Request $request, $id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            if ($request->action == 'plus') {
                $keranjang[$id]['jumlah']++;
            } elseif ($request->action == 'minus') {
                $keranjang[$id]['jumlah']--;
                if ($keranjang[$id]['jumlah'] <= 0) {
                    unset($keranjang[$id]);
                }
            }
        }

        session()->put('keranjang', $keranjang);

        return redirect()->back();
    }
    public function checkout()
    {
        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang', []);

        // Hitung subtotal
        $subtotal = array_reduce($keranjang, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);

        return view('kasir.bayar', compact('keranjang', 'subtotal'));
    }
    public function clearKeranjang()
    {
        // Mengosongkan keranjang dan session terkait member
        session()->forget(['keranjang', 'nomor_member', 'discount', 'member_status', 'member_status_class']);

        // Redirect kembali ke halaman barang dengan pesan sukses
        return redirect()->route('kasir.index')->with('success', 'Keranjang telah dikosongkan.');
    }

    public function checkMember(Request $request)
    {
        $nomor_member = $request->input('nomor_member');
        $subtotal = $request->input('subtotal'); // Subtotal dari permintaan
        $member = ModelMember::where('nomor_member', $nomor_member)->first();

        if ($member) {
            // Jika member valid, simpan status ke dalam session
            $diskon = $subtotal * 0.02; // Diskon 2%
            session([
                'nomor_member' => $nomor_member,
                'discount' => $diskon,
                'member_status' => 'KARTU MEMBER VALID',
                'member_status_class' => 'text-success'
            ]);

            return response()->json([
                'member_status' => 'KARTU MEMBER VALID',
                'member_status_class' => 'text-success',
                'diskon' => number_format($diskon, 0, ',', '.'),
                'total' => number_format($subtotal - $diskon, 0, ',', '.')
            ]);
        } elseif (empty($nomor_member)) {
            session()->forget(['nomor_member', 'discount', 'member_status', 'member_status_class']);

            return response()->json([
                'member_status' => 'BELUM MENGISI NOMOR MEMBER',
                'member_status_class' => 'text-muted',
                'diskon' => '0',
                'total' => number_format($subtotal, 0, ',', '.')
            ]);
        } else {
            session()->forget(['nomor_member', 'discount', 'member_status', 'member_status_class']);

            return response()->json([
                'member_status' => 'KARTU MEMBER INVALID',
                'member_status_class' => 'text-danger',
                'diskon' => '0',
                'total' => number_format($subtotal, 0, ',', '.')
            ]);
        }
    }

    public function storePaymentMethod(Request $request)
    {
        $metode_pembayaran = $request->input('metode_pembayaran');
        $subtotal = $request->input('subtotal');
        $uang_diberikan = $request->input('uang_diberikan', 0);
        $total = $subtotal - session('discount', 0); // Hitung total setelah diskon

        // Simpan metode pembayaran ke session
        session(['metode_pembayaran' => $metode_pembayaran]);

        // Jika metode pembayaran adalah "cash", hitung kembalian
        $kembalian = 0;
        if ($metode_pembayaran === 'cash' && $uang_diberikan > $total) {
            $kembalian = $uang_diberikan - $total;
        }

        return response()->json([
            'metode_pembayaran' => $metode_pembayaran,
            'kembalian' => number_format($kembalian, 0, ',', '.')
        ]);
    }
    public function prosesTransaksi(Request $request)
    {
        // Ambil data dari session
        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada barang untuk transaksi.');
        }

        // Hitung subtotal
        $subtotal = array_reduce($keranjang, function ($carry, $item) {
            return $carry + ($item['harga'] * $item['jumlah']);
        }, 0);

        // Ambil data dari session untuk member, diskon, metode pembayaran, dan pengguna
        $nomor_member = session('nomor_member');
        $diskon = session('discount', 0);
        $total = $subtotal - $diskon;
        $metode_pembayaran = session('metode_pembayaran');
        $pengguna_id = auth()->id();

        if (!$pengguna_id) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        if (!$metode_pembayaran) {
            return redirect()->back()->with('error', 'Metode pembayaran belum dipilih.');
        }

        // Cari member jika ada
        $member = null;
        if ($nomor_member) {
            $member = ModelMember::where('nomor_member', $nomor_member)->first();
            if (!$member) {
                session()->forget('nomor_member');
                session()->forget('discount');
                return redirect()->back()->with('error', 'Member tidak valid.');
            }
        }

        // Simpan transaksi
        $transaksi = ModelTransaksi::create([
            'pengguna_id' => $pengguna_id,
            'member_id' => $member ? $member->member_id : null,
            'tanggal' => now(),
            'total_harga' => $total,
            'metode_pembayaran' => $metode_pembayaran
        ]);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }
        // Simpan detail transaksi dan kurangi stok
        foreach ($keranjang as $id => $item) {
            $barang = ModelBarang::find($id);
            if (!$barang) {
                return redirect()->back()->with('error', 'Barang tidak ditemukan.');
            }

            // Simpan detail transaksi
            ModelDetailTransaksi::create([
                'transaksi_id' => $transaksi->transaksi_id,
                'barang_id' => $id,
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['harga'] * $item['jumlah']
            ]);

            // Kurangi stok barang
            $barang->stok -= $item['jumlah'];
            $barang->save();
        }
        // Hapus session setelah transaksi selesai
        session()->forget(['keranjang', 'nomor_member', 'discount', 'member_status', 'member_status_class', 'metode_pembayaran']);
        // Redirect ke halaman sukses atau cetak nota
        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}
