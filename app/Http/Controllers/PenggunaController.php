<?php


namespace App\Http\Controllers;

use App\Models\ModelPengguna;
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
        $penggunas = ModelPengguna::select('pengguna_id', 'username', 'nama', 'role');

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

        $activeMenu = 'pengguna';

        return view('admin/pengguna.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'nama'     => 'required',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        ModelPengguna::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password),  // Hash password sebelum disimpan
            'role'     => $request->role
        ]);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil disimpan');
    }


    public function show(string $id)
    {
        $pengguna = ModelPengguna::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Data pengguna',
            'list'  => ['Home', 'Data pengguna', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail pengguna'
        ];

        $activeMenu = 'pengguna';

        return view('admin.pengguna.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pengguna' => $pengguna, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $pengguna = ModelPengguna::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Data Pengguna',
            'list'  => ['Home', 'Data Pengguna', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Pengguna'
        ];

        $activeMenu = 'pengguna';

        return view('admin/pengguna.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pengguna' => $pengguna, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required',
            'nama'     => 'required',
            'password' => 'nullable|min:6', // Password tidak wajib diubah
            'role'     => 'required'
        ]);

        $pengguna = ModelPengguna::find($id);

        $dataToUpdate = [
            'username' => $request->username,
            'nama'     => $request->nama,
            'role'     => $request->role,
        ];

        // Jika password diisi, hash password sebelum di-update
        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        $pengguna->update($dataToUpdate);

        return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil diubah');
    }

    public function destroy(string $id)
    {
        $pengguna = ModelPengguna::find($id);

        if (!$pengguna) {
            return redirect('/admin/pengguna')->with('error', 'Data pengguna tidak ditemukan');
        }

        try {
            ModelPengguna::destroy($id);
            return redirect('/admin/pengguna')->with('success', 'Data pengguna berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/admin/pengguna')->with('error', 'Gagal menghapus data pengguna');
        }
    }
}
