<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Bill Of Material</title>
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
                            <h1 class="m-0">Bill Of Material</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/BillOfMaterial">Bill Of Material</a>
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
                                            <a href="/BillOfMaterial/input" class="btn btn-app" style="left: -10px;">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            @if (count($data) > 0)
                                                <a href="/BillOfMaterial/export/{{ $data[0]->id }}" class="btn btn-app"
                                                    style="left: -10px;">
                                                    <i class="fa fa-file-pdf"></i> Export PDF
                                                </a>
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
                                    {{-- Untuk bagian list atau tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Produk</th>
                                                <th style="vertical-align: middle;">Referensi</th>
                                                <th style="vertical-align: middle;">Kuantitas</th>
                                                <th style="vertical-align: middle;">Variasi BoM</th>
                                                <th style="vertical-align: middle;">Bahan</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->produk->nama_produk }}</td>
                                                    <td>{{ $row->reference }}</td>
                                                    <td>{{ $row->kuantitas_produk }}</td>
                                                    <td>{{ $row->variasi }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($row->bahans as $bahan)
                                                                <li>{{ $bahan->nama_bahan }} -
                                                                    {{ $bahan->pivot->kuantitas }}
                                                                    {{ $bahan->pivot->satuan }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="/BillOfMaterial/edit/{{ $row->id }}"
                                                            class="btn btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger delete"
                                                            data-id="{{ $row->id }}"
                                                            data-produk="{{ $row->produk->nama_produk }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- untuk bagian kanbannya --}}
                                    <div id="kanbanView-BoM" class="row hidden">
                                        @foreach ($data as $row)
                                            <div class="col-lg-4 col-6">
                                                <div class="small-box">
                                                    <div class="inner">
                                                        <h3>{{ $row->produk->nama_produk }}</h3>
                                                        <p>Ref : {{ $row->reference }}</p>
                                                        <p>Production for {{ $row->kuantitas_produk }} unit</p>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion"><img style="width: 120px; height: 100px;"
                                                                src="{{ asset('foto-produk/' . $row->produk->gambar) }}"></i>
                                                    </div>
                                                    <a href="/BillOfMaterial/edit/{{ $row->id }}"
                                                        class="small-box-footer" style="color: black;">More info <i
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
                window.location.href = '/BillOfMaterial/edit/' + id;
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
                            window.location = "/BillOfMaterial/hapus/" + id + "",
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
