<?php

namespace App\Http\Controllers;

use App\Models\ModelKategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Kategori Barang',
            'list'  => ['Home', 'kategori']
        ];

        $page = (object)[
            'title' => 'Daftar Kategori Barang'
        ];

        $activeMenu = 'kategori';


        return view('admin.kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategori = ModelKategori::select('kategori_id', 'kode_kategori', 'nama_kategori');
        
        return DataTables::of($kategori)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/admin/kategori/' .  $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/kategori/' . $kategori->kategori_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori Barang',
            'list'  => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Kategori baru'
        ];

        $activeMenu = 'kategori';


        return view('admin.kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di table m_user kolom usernmae
            'kode_kategori' => 'required|string|min:3|unique:kategori_barang,kode_kategori',
            'nama_kategori'     =>  'required|string|max:100' //nama haruus diisi, berupa string, dan maksimal 100 karakter
        ]);

        ModelKategori::create([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori'  => $request->nama_kategori
        ]);

        return redirect('/admin/kategori')->with('success', 'Data user berhasil disimpan');
    }
    public function show(string $id)
    {
        $kategori = ModelKategori::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail kategori',
            'list'  => ['Home', 'kategori', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';


        return view('admin.kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori'=>$kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $kategori = ModelKategori::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit kategori',
            'list'  => ['Home', 'kategori', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';


        return view('admin.kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori'=>$kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id){

        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di table m_user kolom usernmae
            'kode_kategori' => 'required|string|min:3',
            'nama_kategori'     =>  'required|string|max:100' // kategori_id harus diisi dan berupa angka
        ]);

        ModelKategori::find($id)->update([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori'  => $request->nama_kategori
        ]);

        return redirect('/admin/kategori')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id){
        $check = ModelKategori::find($id);
        if (!$check){
            return redirect('/admin/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try{
            ModelKategori::destroy($id); //hapus data kategori

            return redirect('/admin/kategori')->with('success', 'Data kategori berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/admin/kategori')-with('error', 'Data use gagal dihapus karena masih terdapat tabel lain yang terkait deng data ini');
        }
    }
}
