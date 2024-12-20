<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Manufacturing Order</title>
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
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @include('layouts/preloader')
    @include('layouts/navbar')
    @include('layouts/sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manufacturing Order</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Manufacturing</li>
                            <li class="breadcrumb-item"><a href="/ManufacturingOrder">Manufacturing Order</a></li>
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
                                        <a href="/ManufacturingOrder/openMO" class="btn btn-app" style="left: -10px;">
                                            <i class="fas fa-plus"></i> Tambah Data
                                        </a>
                                        @if (count($data) > 0)
                                        <form id="export-form" action="{{ route('exportMO') }}"
                                            method="POST" style="display:none;">
                                            @csrf
                                            @foreach ($data as $item)
                                            <input type="hidden" name="items[]" value="{{ $item->id }}">
                                            @endforeach
                                        </form>
                                        <button type="button" class="btn btn-app" style="left: -10px;"
                                            onclick="document.getElementById('export-form').submit();"
                                            title="Export PDF">
                                            <i class="fa fa-file-pdf"></i> Export PDF
                                        </button>
                                        @endif
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

                                <table id="tableList" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th style="vertical-align: middle;">Nomor</th> --}}
                                            <th style="vertical-align: middle;">Nama Produk</th>
                                            <th style="vertical-align: middle;">Reference</th>
                                            <th style="vertical-align: middle;">Quantity</th>
                                            <th style="vertical-align: middle;">State</th>
                                            <th style="vertical-align: middle;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                        <tr>
                                            {{-- <td style="vertical-align: middle; text-align: center;">{{ $row->id
                                                }}</td> --}}
                                            <td style="vertical-align: middle; text-align: center;">{{ $row->nama_produk
                                                }}</td>
                                            <td style="vertical-align: middle; text-align: center;">{{ $row->reference
                                                }}</td>
                                            <td style="vertical-align: middle; text-align: center;">{{ $row->quantity }}
                                            </td>
                                            <td style="vertical-align: middle; text-align: center;">
                                                @php
                                                $color = ''; // Variabel untuk menyimpan warna latar belakang
                                                @endphp
                                                @switch($row->state)
                                                @case('draft')
                                                @php $color = 'red'; @endphp
                                                @break
                                                @case('confirmed')
                                                @php $color = 'orange'; @endphp
                                                @break
                                                @case('check_availability')
                                                @php $color = 'blue'; @endphp
                                                @break
                                                @case('in_progress')
                                                @php $color = 'purple'; @endphp
                                                @break
                                                @case('done')
                                                @php $color = 'green'; @endphp
                                                @break
                                                @default
                                                @php $color = 'gray'; @endphp
                                                @endswitch
                                                <span
                                                    style="display: inline-block; background-color: {{ $color }}; color: white; padding: 5px 10px; border-radius: 5px;">
                                                    {{ ucfirst(str_replace('_', ' ', $row->state)) }}
                                                </span>
                                            </td>
                                            <!-- Mengubah state menjadi format Capital Case -->
                                            <td style="text-align: center">
                                                <!-- Tombol untuk mengubah state berdasarkan kondisi -->
                                                @if($row->state == 'draft')
                                                <a href="/ManufacturingOrder/confirmed/{{ $row->id }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-check-circle"></i> Confirm
                                                </a>
                                                @elseif($row->state == 'confirmed')
                                                <a href="/ManufacturingOrder/checkAvailability/{{ $row->id }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-check-circle"></i> Check Availability
                                                </a>
                                                @elseif($row->state == 'check_availability')
                                                <a href="/ManufacturingOrder/progress/{{ $row->id }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-check-circle"></i> Progress
                                                </a>
                                                @elseif($row->state == 'in_progress')
                                                <a href="/ManufacturingOrder/done/{{ $row->id }}" class="btn btn-info">
                                                    <i class="fas fa-check-circle"></i> Done
                                                </a>
                                                @endif

                                                <!-- Tombol untuk menghapus -->
                                                <a href="/ManufacturingOrder/hapus/{{ $row->id }}"
                                                    class="btn btn-danger delete" data-id="{{ $row->id }}"
                                                    data-produk="{{ $row->nama_produk }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                {{-- @if($row->state == 'done')
                                                <a href="/ManufacturingOrder/hapus/{{ $row->id }}"
                                                    class="btn btn-danger delete" data-id="{{ $row->id }}"
                                                    data-produk="{{ $row->nama_produk }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                @else
                                                <a>
                                                </a>
                                                @endif --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div id="kanbanView-BoM" class="row hidden">
                                    @foreach ($data as $row)
                                    <div class="col-lg-4 col-6">
                                        <div class="small-box">
                                            <div class="inner">
                                                <h3>{{ $row->nama_produk }}</h3>
                                                <p>Ref : {{ $row->reference }}</p>
                                                <p>Production for {{ $row->quantity }} unit</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion"><img style="width: 120px; height: 100px;"
                                                        src="{{ asset('foto-produk/' . $row->gambar) }}"></i>
                                            </div>
                                            <a href="/ManufacturingOrder/edit/{{ $row->id }}" class="small-box-footer"
                                                style="color: black;">More info <i class="fas fa-arrow-circle-right"
                                                    style="color: black;"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layouts/footer')
    @include('layouts/script')

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
                window.location.href = '/ManufacturingOrder/edit/' + id;
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
                            window.location = "/ManufacturingOrder/hapus/" + id + "",
                        )
                    }
                });
            });
        });
    </script>

    <script>
        function applyViewPreference() {
            const viewPreference = localStorage.getItem('viewPreference');
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
            applyViewPreference();

            $('#tombol-list-BOM').click(function() {
                $('#kanbanView-BoM').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list');
                $('#tombol-list-BOM').addClass('hidden');
                $('#tombol-kanbam-BOM').removeClass('hidden');
            });

            $('#tombol-kanbam-BOM').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-BoM').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban');
                $('#tombol-list-BOM').removeClass('hidden');
                $('#tombol-kanbam-BOM').addClass('hidden');
            });
        });
    </script>

    {{-- script hapus data --}}
    <script>
        $(document).ready(function() {
            if (!$.fn.dataTable.isDataTable('#tableList')) {
                $('#tableList').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('#tableList').on('click', '.delete', function(e) {
                e.preventDefault(); // Mencegah aksi default elemen
                var id = $(this).attr('data-id');
                var nama_produk = $(this).attr('data-produk');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Eksekusi penghapusan hanya setelah konfirmasi
                        window.location.href = "/ManufacturingOrder/hapus/" + id;
                    }
                });
            });
        });
    </script>

</body>

</html>