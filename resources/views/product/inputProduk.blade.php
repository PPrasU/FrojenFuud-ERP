<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Input Produk</title>
    @include('layouts/header')
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
                            <h5 class="m-0">Input Produk</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/produk">Produk</a>
                                <li class="breadcrumb-item"><a href="/produk/input">Input Data</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
                                                    <label for="harga_produk">Harga Produk (Sales Price)</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <!-- Input untuk tampilan pengguna -->
                                                        <input type="text" class="form-control"
                                                            id="harga_produk_display" onkeyup="formatRupiah(this)"
                                                            placeholder="0">
                                                        <!-- Input hidden untuk menyimpan nilai sebenarnya (tanpa titik) ke database -->
                                                        <input type="hidden" name="harga_produk" id="harga_produk">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_produksi">Harga Produksi (Cost)</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <!-- Input untuk tampilan pengguna -->
                                                        <input type="text" class="form-control"
                                                            id="harga_produksi_display" onkeyup="formatRupiah(this)"
                                                            placeholder="0">
                                                        <!-- Input hidden untuk menyimpan nilai sebenarnya (tanpa titik) ke database -->
                                                        <input type="hidden" name="harga_produksi" id="harga_produksi">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tanggal_produksi">Tanggal Produksi</label>
                                                    <input type="date" name="tanggal_produksi" class="form-control"
                                                        id="tanggal_produksi" placeholder="dd/mm/yyyy"
                                                        onchange="updateKadaluarsa()">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                                                    <input type="date" name="tanggal_kadaluarsa" class="form-control"
                                                        id="tanggal_kadaluarsa" placeholder="dd/mm/yyyy" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="gambar">Gambar Produk</label>
                                                    <input type="file" name="gambar" class="form-control"
                                                        id="gambar">
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
    {{-- Biar ada . pas masukkin harga --}}
    <script>
        function formatRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, '').toString(),
                split = angka.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            input.value = rupiah;

            // Simpan nilai tanpa titik ke input hidden
            let originalValue = angka.replace(/\./g, '');
            document.getElementById(input.id.replace('_display', '')).value = originalValue;
        }
    </script>
    {{-- Buat Tanggal Kadaluarsa Terisi Otomatis --}}
    <script>
        function updateKadaluarsa() {
            const tanggalProduksiInput = document.getElementById('tanggal_produksi');
            const tanggalKadaluarsaInput = document.getElementById('tanggal_kadaluarsa');

            // Ambil nilai tanggal produksi
            const tanggalProduksi = new Date(tanggalProduksiInput.value);

            if (!isNaN(tanggalProduksi)) {
                // Tambahkan 3 bulan
                tanggalProduksi.setMonth(tanggalProduksi.getMonth() + 3);

                // Format tanggal untuk input
                const year = tanggalProduksi.getFullYear();
                const month = String(tanggalProduksi.getMonth() + 1).padStart(2, '0'); // +1 karena bulan dimulai dari 0
                const day = String(tanggalProduksi.getDate()).padStart(2, '0');

                // Set tanggal kadaluarsa
                tanggalKadaluarsaInput.value = `${year}-${month}-${day}`;
            } else {
                // Jika tidak ada tanggal produksi yang valid, kosongkan tanggal kadaluarsa
                tanggalKadaluarsaInput.value = '';
            }
        }
    </script>

    {{-- Untuk Validasi Saat Isi Form Biar Ndak Kosongan --}}
    <script>
        $(function() {
            $('#inputProduk').validate({
                rules: {
                    nama_produk: {
                        required: true,
                    },
                    kode_produk: {
                        required: true,
                    },
                    harga_produk: {
                        required: true,
                    },
                    harga_produksi: {
                        required: true,
                    },
                    tanggal_produksi: {
                        required: true,
                    },
                    tanggal_kadaluarsa: {
                        required: true,
                    },
                    jumlah_produk: {
                        required: true,
                    },
                    gambar: {
                        required: true,
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>
