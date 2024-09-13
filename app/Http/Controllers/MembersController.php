<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MembersController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Members',
            'list'  => ['Home', 'Member']
        ];

        $page = (object)[
            'title' => 'Daftar Member'
        ];

        $activeMenu = 'member';


        return view('admin.member.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
{
    // Sesuaikan select dengan kolom yang ada di tabel member
    $member = Member::select('member_id', 'nomor_member', 'nama_member', 'no_telepon', 'tanggal_daftar', 'tanggal_expired', 'status');
    
    return DataTables::of($member)
        // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addIndexColumn()
        ->addColumn('aksi', function ($member) { // Menambahkan kolom aksi
            $btn = '<a href="' . url('/admin/member/' .  $member->member_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/admin/member/' . $member->member_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/member/' . $member->member_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
        ->make(true);
}

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Member Baru',
            'list'  => ['Home', 'Member', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Member baru'
        ];

        $activeMenu = 'member';


        return view('admin.member.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
{
    $request->validate([
        'nomor_member' => 'required|string|min:6|unique:members,nomor_member',
        'nama_member' => 'required|string|max:100',
        'no_telepon' => 'required|string|max:15', // Validasi untuk no_telepon
        'tanggal_expired' => 'required|date', // Validasi untuk tanggal_expired
        'status' => 'required|string|in:aktif,non-aktif'
    ]);

    Member::create([
        'nomor_member' => $request->nomor_member,
        'nama_member' => $request->nama_member,
        'no_telepon' => $request->no_telepon,
        'tanggal_daftar' => now(), // Menyimpan tanggal dan waktu saat ini
        'tanggal_expired' => $request->tanggal_expired, // Menyimpan tanggal expired
        'status' => $request->status // Jika kolom status juga ingin disimpan
    ]);

    return redirect('/admin/member')->with('success', 'Data Member berhasil disimpan');
}

    public function show(string $id)
    {
        $member = Member::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Member',
            'list'  => ['Home', 'Member', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Member'
        ];

        $activeMenu = 'member';


        return view('admin.member.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'member'=>$member, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id){
        $member = Member::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Data Member',
            'list'  => ['Home', 'Member', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Data Member'
        ];

        $activeMenu = 'member';


        return view('admin.member.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'member'=>$member, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
{
    $request->validate([
        'nomor_member' => 'required|string|min:6|unique:members,nomor_member,' . $id . ',member_id',
        'nama_member' => 'required|string|max:100',
        'no_telepon' => 'nullable|string|max:15',
        'tanggal_expired' => 'nullable|date',
        'status' => 'required|string|in:aktif,non-aktif'
    ]);

    $member = Member::find($id);

    if (!$member) {
        return redirect('/admin/member')->with('error', 'Data Member tidak ditemukan');
    }

    $member->update([
        'nomor_member' => $request->nomor_member,
        'nama_member' => $request->nama_member,
        'no_telepon' => $request->no_telepon,
        'tanggal_expired' => $request->tanggal_expired,
        'status' => $request->status
    ]);

    return redirect('/admin/member')->with('success', 'Data Member berhasil diubah');
}

    public function destroy(string $id){
        $check = Member::find($id);
        if (!$check){
            return redirect('/admin/meber')->with('error', 'Data Member tidak ditemukan');
        }

        try{
            Member::destroy($id); //hapus data kategori

            return redirect('/admin/member')->with('success', 'Data Member berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/admin/member')-with('error', 'Data Member gagal dihapus karena masih terdapat tabel lain yang terkait deng data ini');
        }
    }
}
