<?php

namespace App\Http\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelKategori;
use Illuminate\Http\Request;

class PilihBarangController extends Controller
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
}
