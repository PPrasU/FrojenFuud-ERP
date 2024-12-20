<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Edit Vendor</title>
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
                            <h5 class="m-0">Edit Vendor</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchasing</li>
                                <li class="breadcrumb-item"><a href="/Vendors">Vendor</a>
                                <li class="breadcrumb-item"><a href="/Vendors/edit/{{ $data->id }}">Edit Data</a>
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
                                <form action="/Vendors/update/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data" id="inputBahanBaku">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nama">Nama Vendor</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        id="nama" value="{{ $data->nama }}" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="no_hp">No Hp</label>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+62</span>
                                                        <input type="number" name="no_hp" class="form-control"
                                                            id="no_hp" value="{{ $data->no_hp }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control" name="kategori" id="kategori"
                                                        value="{{ $data->kategori }}">
                                                        <option selected>{{ $data->kategori }}</option>
                                                        <option disabled>-- Pilih Kategori --</option>
                                                        <option>Individual</option>
                                                        <option>Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        id="email" value="{{ $data->email }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <input type="text" name="alamat_1" class="form-control"
                                                        id="alamat_1" value="{{ $data->alamat_1 }}">
                                                    <label></label>
                                                    <input type="text" name="alamat_2" class="form-control"
                                                        id="alamat_2" value="{{ $data->alamat_2 }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="npwp">NPWM</label>
                                                    <input type="npwp" name="npwp" class="form-control"
                                                        id="npwp" value="{{ $data->npwp }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/Vendors" class="btn btn-default">Batal</a>
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
