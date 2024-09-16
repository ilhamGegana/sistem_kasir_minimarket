<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use PHPUnit\Metadata\DataProvider;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Barang',
            'list'  => ['Home', 'databarang']
        ];

        $page = (object)[
            'title' => 'Daftar Data Barang'
        ];
        

        $activeMenu = 'barang';

        return view('admin.barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'kode_barang', 'nama_barang', 'kategori_id', 'harga', 'stok')->with('kategori');
        
        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('/admin/barang/' .  $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/barang/' . $barang->barang_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Data Barang',
            'list'  => ['Home', 'Data Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Barang Baru'
        ];

        $activeMenu = 'barang';

        return view('admin/barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|min:2|unique:data_barang,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0'
        ]);

        BarangModel::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        return redirect('/admin/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show(string $id)
    {
        $barang = BarangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Data Barang',
            'list'  => ['Home', 'Data Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'databarang';

        return view('admin/barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'databarang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $barang = BarangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Data Barang',
            'list'  => ['Home', 'Data Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang';

        return view('admin/barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'databarang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_barang' => 'required|string|min:2|unique:data_barang,kode_barang,' . $id . ',barang_id',
            'nama_barang' => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0'
        ]);

        BarangModel::find($id)->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        return redirect('/admin/barang')->with('success', 'Data barang berhasil diubah');
    }

    public function destroy(string $id)
    {
        $databarang = BarangModel::find($id);

        if (!$databarang) {
            return redirect('/admin/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);
            return redirect('/admin/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/admin/barang')->with('error', 'Gagal menghapus data barang');
        }
    }
}
