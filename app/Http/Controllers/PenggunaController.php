<?php


namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use PHPUnit\Metadata\DataProvider;
use Yajra\DataTables\Facades\DataTables;

class PenggunaController extends Controller
{
    //
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Pengguna',
            'list'  => ['Home', 'Data Pengguna']
        ];

        $page = (object)[
            'title' => 'Daftar Data Pengguna'
        ];
        

        $activeMenu = 'pengguna';

        return view('admin.pengguna.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penggunas = PenggunaModel::select('username', 'nama', 'role');
        
        return DataTables::of($penggunas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pengguna) {
                $btn = '<a href="' . url('/admin/pengguna/' .  $pengguna->pengguna_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/pengguna/' . $pengguna->pengguna_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/pengguna/' . $pengguna->pengguna_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Data Pengguna',
            'list'  => ['Home', 'Data Pengguna', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Pengguna Baru'
        ];

        $activeMenu = 'Pengguna';

        return view('admin/pengguna.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        PenggunaModel::create([
            'username' => $request->username,
            'password' => $request->password,
            'role'     => $request->role
        ]);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil disimpan');
    }

    public function show(string $id)
    {
        $pengguna = penggunaModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Data pengguna',
            'list'  => ['Home', 'Data pengguna', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail pengguna'
        ];

        $activeMenu = 'datapengguna';

        return view('admin/pengguna.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'datapengguna' => $pengguna, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $pengguna = PenggunaModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Data Pengguna',
            'list'  => ['Home', 'Data Pengguna', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Pengguna'
        ];

        $activeMenu = 'pengguna';

        return view('admin/pengguna.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'datapengguna' => $pengguna, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        PenggunaModel::find($id)->update([
            'username' => $request->username,
            'password' => $request->password,
            'role'     => $request->role
        ]);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil diubah');
    }

    public function destroy(string $id)
    {
        $datapengguna = PenggunaModel::find($id);

        if (!$datapengguna) {
            return redirect('/admin/pengguna')->with('error', 'Data pengguna tidak ditemukan');
        }

        try {
            PenggunaModel::destroy($id);
            return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/admin/pengguna')->with('error', 'Gagal menghapus data pengguna');
        }
    }
}
