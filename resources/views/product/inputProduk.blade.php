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
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header" style="height: 1px;">
                                </div>
                                <form action="/produk/post" method="POST" enctype="multipart/form-data"
                                    id="inputProduk">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama_produk">Nama Produk</label>
                                                    <input type="text" name="nama_produk" class="form-control"
                                                        id="nama_produk" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="kode_produk">Kode Produk</label>
                                                    <input type="text" name="kode_produk" class="form-control"
                                                        id="kode_produk">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_produk">Harga Produk</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" name="harga_produk" class="form-control"
                                                            id="harga_produk" max="4000000">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_produksi">Harga Produksi</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" name="harga_produksi" class="form-control"
                                                            id="harga_produksi" max="4000000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tanggal_produksi">Tanggal Produksi</label>
                                                    <input type="date" name="tanggal_produksi" class="form-control"
                                                        id="tanggal_produksi" placeholder="dd/mm/yyyy">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                                                    <input type="date" name="tanggal_kadaluarsa" class="form-control"
                                                        id="tanggal_kadaluarsa" placeholder="dd/mm/yyyy">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="jumlah_produk">Jumlah Produk</label>
                                                    <input type="text" name="jumlah_produk" class="form-control"
                                                        id="jumlah_produk">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/produk" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                                    </div>
                                </form>
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
