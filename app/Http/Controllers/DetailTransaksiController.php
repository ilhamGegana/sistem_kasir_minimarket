<?php

namespace App\Http\Controllers;

use App\Models\ModelTransaksi;
use App\Models\ModelDetailTransaksi;
use App\Models\ModelBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as Pdf;

class DetailTransaksiController extends Controller
{
    public function index()
    {

        $breadcrumb = (object)[
            'title' => 'Transaksi',
            'list'  => ['Home', 'Transaksi']
        ];

        $page = (object)[
            'title' => 'Daftar Transaksi'
        ];

        $barang = ModelBarang::all();
        $transaksi = ModelTransaksi::all();
        $activeMenu = 'detailTransaksi';

        return view('admin.detailTransaksi.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'barang' => $barang, 'transaksi' => $transaksi, 'activeMenu' => $activeMenu]);
    }

    public function getData(Request $request)
{
    // Ambil data berdasarkan request dari DataTables
    $query = ModelDetailTransaksi::query()->with(['transaksi', 'barang']);

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereHas('transaksi', function ($q) use ($request) {
            $q->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        });
    }            
    
    if ($request->barang_id){
        $query->where('barang_id', $request->barang_id);
    } 
    
    if ($request->transaksi_id){
        $query->where('transaksi_id', $request->transaksi_id);
    }

    return DataTables::of($query)
    ->addIndexColumn()
    ->make(true);
}


    
    //Export PDF
    public function exportPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = ModelDetailTransaksi::select('detail_id', 'jumlah', 'subtotal', 'barang_id', 'transaksi_id')
            ->with('transaksi', 'barang');

        // if ($request->filled('start_date') && $request->filled('end_date')) {
        //     $data->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        // }
        if ($startDate && $endDate) {
            $data->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }
    

        $transactions = $data->get();

        $totalSubtotal = $transactions->sum('subtotal');

        $pdf = Pdf::loadView('admin.detailTransaksi.pdf', compact('transactions', 'totalSubtotal', 'startDate', 'endDate'));

        return $pdf->stream('admin.detailTransaksi.pdf');
    }
}
