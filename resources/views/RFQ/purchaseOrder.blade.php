<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Purchase Order</title>
    @include('layouts/header')
    <style>
        th {
            font-size: 16px;
            text-align: center;
        }

        td {
            font-size: 16px;
        }

        td img {
            width: 120px;
        }

        .btn-warning,
        .btn-danger {
            margin: 0 5px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @php
    // dd($data);
    @endphp
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Purchase Order</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchase</li>
                                <li class="breadcrumb-item"><a href="/PurchaseOrder">Purchase Order</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <a href="/PurchaseOrder/input" class="btn btn-app" style="left: -10px;">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            {{-- @if (!empty($data1) && count($data1) > 0)
                                                <form id="export-form" action="{{ route('exportPurchaseOrder') }}" method="POST" style="display:none;">
                                                    @csrf
                                                </form>
                                                <button type="button" class="btn btn-app" style="left: -10px;" onclick="document.getElementById('export-form').submit();" title="Export PDF">
                                                    <i class="fa fa-file-pdf"></i> Export PDF
                                                </button>
                                            @endif --}}
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            <a href="#" id="tombol-list-BOM" class="btn btn-app">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="tombol-kanbam-BOM" class="btn btn-app">
                                                <i class="fa fa-columns"></i> Kanban
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Untuk bagian list atau tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th>Confirmation Date</th>
                                                <th>Vendor</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data1 as $PO)
                                                <tr>
                                                    <td>PO{{ str_pad($PO->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($PO->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ $PO->vendor->nama ?? 'Vendor tidak ditemukan' }}</td>
                                                    <td>Rp{{ number_format($PO->total, 0, ',', '.') }}</td>
                                                    <td class="badge 
                                                        @if ($PO->status_po == 'Nothing to bill')
                                                            bg-secondary
                                                        @elseif ($PO->status_po == 'Waiting to bill')
                                                            bg-info
                                                        @elseif ($PO->status_po == 'Fully billed')
                                                            bg-success
                                                        @elseif ($PO->status_po == 'Cancelled')
                                                            bg-danger
                                                        @endif
                                                        d-flex justify-content-center align-items-center p-2 m-3">
                                                        {{ $PO->status_po ?? 'Status tidak ditemukan' }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="{{ route('purchase_orders.detail', $PO->id) }}" class="btn btn-info detail-btn" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        {{-- <form action="{{ route('PurchaseOrder.hapus', $PO->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form> --}}
                                                    </td>
                                                    
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data Purchase Order ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('layouts/footer')
    </div>

    @include('layouts/script')

    {{-- untuk button hapus data --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable untuk #tableList
            $('#tableList').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // Menggunakan event delegation untuk tombol "edit" dan "delete"
            $('#tableList').on('click', '.edit', function() {
                var id = $(this).data('id');
                // Tambahkan logika untuk tombol edit
                console.log('Edit ID:', id);
                window.location.href = '/PurchaseOrder/edit/' + id;
            });

            $('#tableList').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var nama_produk = $(this).attr('data-produk');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data bahan " + nama_produk + " Akan Dihapus dengan id -> " + id,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Terhapus!',
                            'Data Telah Terhapus!',
                            'success',
                            window.location = "/PurchaseOrder/hapus/" + id + "",
                        )
                    }
                });
            });
        });
    </script>

    {{-- script untuk preferensi button list dan kanban --}}

    <script>
        // Fungsi untuk menampilkan tampilan sesuai preferensi yang tersimpan di localStorage
        function applyViewPreference() {
            const viewPreference = localStorage.getItem('viewPreference'); // Ambil preferensi dari localStorage
            if (viewPreference === 'list') {
                $('#kanbanView-BoM').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                $('#tombol-list-BOM').addClass('hidden');
                $('#tombol-kanbam-BOM').removeClass('hidden');
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-BoM').removeClass('hidden');
                $('#tombol-list-BOM').removeClass('hidden');
                $('#tombol-kanbam-BOM').addClass('hidden');
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#tombol-list-BOM').click(function() {
                $('#kanbanView-BoM').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
                $('#tombol-list-BOM').addClass('hidden');
                $('#tombol-kanbam-BOM').removeClass('hidden');
            });

            $('#tombol-kanbam-BOM').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-BoM').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
                $('#tombol-kanbam-BOM').addClass('hidden');
                $('#tombol-list-BOM').removeClass('hidden');
            });
        });
    </script>
</body>

</html>
