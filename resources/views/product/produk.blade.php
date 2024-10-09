<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Produk</title>
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
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Produk</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/produk">Produk</a>
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
                                            <a href="/produk/input" class="btn btn-app" style="left: -10px;">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            <a href="#" class="btn btn-app" style="left: -10px;">
                                                <i class="fa fa-file-pdf"></i> Export Data PDF
                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            <a href="#" id="btnList" class="btn btn-app">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="btnKanban" class="btn btn-app">
                                                <i class="fa fa-columns"></i> Kanban
                                            </a>
                                        </div>
                                    </div>
                                    {{-- bagian tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Nama Produk</th>
                                                <th style="vertical-align: middle;">Kode Produk</th>
                                                <th style="vertical-align: middle;">Harga Produk (Sales Price)</th>
                                                <th style="vertical-align: middle;">Harga Produksi (Cost)</th>
                                                <th style="vertical-align: middle;">Tanggal Produksi</th>
                                                <th style="vertical-align: middle;">Tanggal Kadaluarsa</th>
                                                <th style="vertical-align: middle;">Gambar</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->nama_produk }}</td>
                                                    <td>{{ $row->kode_produk }}</td>
                                                    <td>{{ $row->harga_produk }}</td>
                                                    <td>{{ $row->harga_produksi }}</td>
                                                    <td>{{ $row->tanggal_produksi }}</td>
                                                    <td>{{ $row->tanggal_kadaluarsa }}</td>
                                                    <td><img src="{{ asset('foto-produk/' . $row->gambar) }}"></td>
                                                    <td style="text-align: center">
                                                        <a href="/produk/edit/{{ $row->id }}"
                                                            class="btn btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-danger delete"
                                                            data-id="{{ $row->id }}"
                                                            data-nama_produk="{{ $row->nama_produk }}">Hapus</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- bagian kanban --}}
                                    <div id="kanbanView" class="row hidden">
                                        @foreach ($data as $row)
                                            <div class="col-lg-4 col-6">
                                                <div class="small-box">
                                                    <div class="inner">
                                                        <h3>{{ $row->nama_produk }}</h3>
                                                        <p>Rp. {{ $row->harga_produk }}</p>
                                                        <div style="text-align: right;">
                                                            <a class="btn btn-danger delete"
                                                                data-id="{{ $row->id }}"
                                                                data-nama_produk="{{ $row->nama_produk }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion"><img style="width: 120px;"
                                                                src="{{ asset('foto-produk/' . $row->gambar) }}"></i>
                                                    </div>
                                                    <a href="/produk/edit/{{ $row->id }}" class="small-box-footer"
                                                        style="color: black;">More info <i
                                                            class="fas fa-arrow-circle-right"
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
    </div>

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

            // Untuk tombol List dan Kanban
            $('#btnList').click(function() {
                $('#kanbanView').addClass('hidden');
                $('#tableList_wrapper').removeClass(
                    'hidden'); // DataTable membungkus table dengan '_wrapper'
            });

            $('#btnKanban').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView').removeClass('hidden');
            });

            // Konfirmasi hapus dengan SweetAlert
            $('.delete').click(function() {
                var id = $(this).attr('data-id');
                var nama_produk = $(this).attr('data-nama_produk');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data Produk " + nama_produk + " Akan Dihapus",
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
                            window.location = "/produk/hapus/" + id + "",
                        )
                    }
                });
            });
        });
    </script>

</body>

</html>
