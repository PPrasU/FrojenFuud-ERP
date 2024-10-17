<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Input Bahan Baku</title>
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
                            <h5 class="m-0">Input Bahan Baku</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/bahan-baku">Bahan Baku</a>
                                <li class="breadcrumb-item"><a href="/bahan-baku/input">Edit Data</a>
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
                                <form action="/bahan-baku/update/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data" id="inputBahanBaku">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama_bahan">Nama Bahan</label>
                                                    <input type="text" name="nama_bahan" class="form-control"
                                                        id="nama_bahan" value="{{ $data->nama_bahan }}" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="kode_bahan">Kode Bahan</label>
                                                    <input type="text" name="kode_bahan" class="form-control"
                                                        id="kode_bahan" value="{{ $data->kode_bahan }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Jenis Bahan</label>
                                                    <select class="form-control" name="jenis_bahan" id="jenis_bahan"
                                                        value="{{ $data->jenis_bahan }}">
                                                        <option selected>{{ $data->jenis_bahan }}</option>
                                                        <option disabled>-- Pilih Jenis Bahan --</option>
                                                        <option>Bahan Utama</option>
                                                        <option>Bahan Tambahan</option>
                                                        <option>Bumbu</option>
                                                        <option>Minyak & Cairan</option>
                                                        <option>Saus & Dressing</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Satuan</label>
                                                    <select class="form-control" name="satuan" id="satuan"
                                                        value="{{ $data->satuan }}">
                                                        <option selected>{{ $data->satuan }}</option>
                                                        <option disabled>-- Pilih Satuan --</option>
                                                        <option>gram</option>
                                                        <option>ml</option>
                                                        <option>butir</option>
                                                        <option>siung</option>
                                                        <option>lembar</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="harga_bahan">Harga Bahan</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="number" class="form-control"
                                                            id="harga_bahan_display" placeholder="0"
                                                            value="{{ $data->harga_bahan }}">
                                                    </div>
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
                                        <a href="/bahan-baku" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
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

    {{-- Untuk Validasi Saat Isi Form Biar Ndak Kosongan --}}
    <script>
        $(function() {
            $('#inputBahanBaku').validate({
                rules: {
                    nama_bahan: {
                        required: true,
                    },
                    harga_bahan: {
                        required: true,
                    },
                    stok: {
                        required: true,
                    },
                    satuan: {
                        required: true,
                    },
                    jenis_bahan: {
                        required: true,
                    },
                    kode_bahan: {
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

    {{-- script buat otomatisin kode produk --}}
    <script>
        document.getElementById('nama_bahan').addEventListener('input', function() {
            const namaBahan = this.value.trim();
            let kodeBahan = '';

            if (namaBahan) {
                const words = namaBahan.split(' ');

                if (words.length === 2) {
                    // Ambil huruf pertama dari dua kata
                    kodeBahan = words[0][0].toUpperCase() + words[1][0].toUpperCase();
                } else if (words.length === 1) {
                    // Ambil huruf pertama dan ketiga dari satu kata
                    const word = words[0];
                    if (word.length >= 3) {
                        kodeBahan = word[0].toUpperCase() + word[2].toUpperCase();
                    } else {
                        kodeBahan = word[0]
                            .toUpperCase(); // Jika panjang kurang dari 3 huruf, ambil hanya huruf pertama
                    }
                }
            }

            document.getElementById('kode_bahan').value = kodeBahan;
        });
    </script>
</body>

</html>
