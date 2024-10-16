<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Edit Produk Jadi</title>
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
                            <h5 class="m-0">Edit Produk Jadi</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Produk</li>
                                <li class="breadcrumb-item"><a href="/produk">Produk Jadi</a>
                                <li class="breadcrumb-item"><a href="/produk/input">Edit Data</a>
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
                                <form action="/produk/update/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data" id="inputProduk">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama_produk">Nama Produk</label>
                                                    <input type="text" name="nama_produk" class="form-control"
                                                        id="nama_produk" value="{{ $data->nama_produk }}" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="kode_produk">Kode Produk</label>
                                                    <input type="text" name="kode_produk" class="form-control"
                                                        id="kode_produk" value="{{ $data->kode_produk }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_produk">Harga Produk Satuan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                            id="harga_produk_display" placeholder="0"
                                                            value="{{ $data->harga_produk }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_produksi">Harga Produksi Satuan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                            id="harga_produksi_display" placeholder="0"
                                                            value="{{ $data->harga_produksi }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="gambar">Gambar Produk</label>
                                                    <input type="file" name="gambar" class="form-control"
                                                        id="gambar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-footer">
                                                <a href="/produk" class="btn btn-default">Batal</a>
                                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                            </div>
                                        </div>
                                    </div>
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
                    jumlah_produk: {
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
<<<<<<< HEAD

    {{-- script buat otomatisin kode produk --}}
    <script>
        document.getElementById('nama_produk').addEventListener('input', function() {
            const namaProduk = this.value.trim();
            let kodeProduk = '';

            if (namaProduk) {
                const words = namaProduk.split(' ');

                if (words.length === 2) {
                    // Ambil huruf pertama dari dua kata
                    kodeProduk = words[0][0].toUpperCase() + words[1][0].toUpperCase();
                } else if (words.length === 1) {
                    // Ambil huruf pertama dan ketiga dari satu kata
                    const word = words[0];
                    if (word.length >= 3) {
                        kodeProduk = word[0].toUpperCase() + word[2].toUpperCase();
                    } else {
                        kodeProduk = word[0]
                            .toUpperCase(); // Jika panjang kurang dari 3 huruf, ambil hanya huruf pertama
                    }
                }
            }

            document.getElementById('kode_produk').value = kodeProduk;
        });
    </script>
=======
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
</body>

</html>
