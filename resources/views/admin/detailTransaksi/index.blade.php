@extends('layouts.masteradmin')

@section('content')
    <div class="container">
        <h2>Transaksi List</h2>

        <!-- Date Range Filter -->
        <form id="filter-form">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <button type="submit" class="btn bg-gradient-primary btn-sm">Filter</button>
        </form>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_detailTransaksi">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total:</th>
                    <th id="totalSubtotal"></th>
                </tr>
            </tfoot>
        </table>
        <form id="pdf-export-form" action="{{ route('admin.detailTransaksi.pdf') }}" method="GET" style="margin-top: 10px;">
            <input type="hidden" id="pdf_start_date" name="start_date">
            <input type="hidden" id="pdf_end_date" name="end_date">
            <button type="submit" class="btn btn-sm btn-primary">Export PDF</button>
        </form>
    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            var datadetailTransaksi = $('#table_detailTransaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('admin.detailTransaksi.data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.barang_id = $('#barang_id').val();
                        d.transaksi_id = $('#transaksi_id').val();
                    },
                    "dataSrc": function(json) {
                        console.log(json); // Log respons untuk memeriksa struktur data
                        return json.data; // Sesuaikan ini dengan struktur respons Anda
                    },
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "transaksi.tanggal",
                    className: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: false,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: false
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "barang.nama_barang",
                    className: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "jumlah",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "subtotal",
                    className: "",
                    orderable: true,
                    searchable: true
                }],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();

                    // Menggunakan reduce untuk menghitung total subtotal
                    var total = api
                        .column(4, {
                            page: 'current'
                        }) // Kolom subtotal (indeks 4)
                        .data()
                        .reduce(function(a, b) {
                            return parseFloat(a) + parseFloat(b);
                        }, 0);

                    // Update total di footer
                    $('#totalSubtotal').html(total.toFixed(2));
                }
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                datadetailTransaksi.draw();
            });
            $('#barang_id').on('change', function() {
                console.log('Filter changed')
                datadetailTransaksi.ajax.reload();
            });
            $('#transaksi_id').on('change', function() {
                console.log('Filter changed')
                datadetailTransaksi.ajax.reload();
            });
            $('#pdf-export-form').on('submit', function() {
                $('#pdf_start_date').val($('#start_date').val());
                $('#pdf_end_date').val($('#end_date').val());
            });
        });
    </script>
@endpush
