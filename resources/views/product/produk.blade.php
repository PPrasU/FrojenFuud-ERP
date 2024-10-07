<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Produk Jadi</title>
    @include('layouts/header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <!-- Main Content Wrapper-->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 class="m-0">Produk Jadi</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Produk</li>
                                <li class="breadcrumb-item"><a href="#">Produk Jadi</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <a href="/produk/input" class="btn btn-app"
                                        style="left: -10px; top: -10px">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                    {{-- @if (count($data) > 0)
                                        <a href="/produk/export/{id}/{{ $data[0]->id }}"
                                            class="btn btn-app" style="left: -10px; top: -10px">
                                            <i class="fa fa-file-pdf"></i> Export Data PDF
                                        </a>
                                    @endif --}}
                                    <a href="#"
                                        class="btn btn-app" style="left: -10px; top: -10px">
                                        <i class="fa fa-file-pdf"></i> Export Data PDF
                                    </a>
                                    <table id="table4" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Kode Produk</th>
                                                <th>Harga Produk (Sales Price)</th>
                                                <th>Harga Produksi (Cost)</th>
                                                <th>Tanggal Produksi</th>
                                                <th>Tanggal Kadaluarsa</th>
                                                <th>Jumlah Produk</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                            <tr>
                                                <td>Nama Produk</td>
                                                <td>Kode Produk</td>
                                                <td>Harga Produk (Sales Price)</td>
                                                <td>Harga Produksi (Cost)</td>
                                                <td>Tanggal Produksi</td>
                                                <td>Tanggal Kadaluarsa</td>
                                                <td>Jumlah Produk</td>
                                                <td>Gambar</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </tbody> --}}
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
    {{-- <script>
        $('.delete').click(function() {
            var id = $(this).attr('data-id');
            var asal_rw = $(this).attr('data-asal_rw');
            var detail_kegiatan = $(this).attr('data-detail_kegiatan');
            Swal.fire({
                title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                text: "Data Abdimas " + asal_rw + " - " + detail_kegiatan + " Akan Dihapus",
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
                        window.location = "/Admin/Abdimas-Fisik-NonFisik/Hapus-Data/" + id + "",
                    )
                }
            });
        });
    </script> --}}
</body>

</html>
