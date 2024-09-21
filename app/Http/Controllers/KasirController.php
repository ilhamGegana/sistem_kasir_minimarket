<?php

namespace App\Http\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelMember;
use Illuminate\Http\Request;

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
        return view('barang.index', compact('kategori', 'barang'));
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

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan ke keranjang');
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

        return view('barang.bayar', compact('keranjang', 'subtotal'));
    }
    public function clearKeranjang()
    {
        // Mengosongkan keranjang dan session terkait member
        session()->forget(['keranjang', 'nomor_member', 'discount', 'member_status', 'member_status_class']);

        // Redirect kembali ke halaman barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Keranjang telah dikosongkan.');
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
}
