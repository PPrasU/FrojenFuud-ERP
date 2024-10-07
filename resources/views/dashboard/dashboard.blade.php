<!DOCTYPE html>
<html lang="en">

<head>
    <title>SI-BKM | Data Warga Tanjungrejo</title>
    @include('layouts/header')
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
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
                            <h1 class="m-0">Beranda</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item"><a href="/Admin/MOU-Kampus">MOU Kampus</a>
                                </li> --}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="m-0">Data Penduduk Tanjungrejo</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item"><a href="/Admin/MOU-Kampus">MOU Kampus</a>
                                </li> --}}
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
                                <div class="card-header">
                                    <h3 class="card-title">Perkembangan Penduduk</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Keterangan</th>
                                                <th>Jumlah (Orang)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jumlah Keseluruhan Penduduk Tahun 2014</td>
                                                <td>30.053</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Keseluruhan Penduduk Tahun 2015</td>
                                                <td>30.171</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Jumlah Penduduk Berdasarkan Usia</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Usia (Tahun)</th>
                                                <th>Jumlah (Orang)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0 - 15</td>
                                                <td>7.028</td>
                                            </tr>
                                            <tr>
                                                <td>16 - 65</td>
                                                <td>20.419</td>
                                            </tr>
                                            <tr>
                                                <td>66 Keatas</td>
                                                <td>2.724</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Ketenagakerjaan</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Jenis Pekerjaan</th>
                                                <th>Jumlah (Orang)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Petani</td>
                                                <td>15</td>
                                            </tr>
                                            <tr>
                                                <td>Pertukangan</td>
                                                <td>214</td>
                                            </tr>
                                            <tr>
                                                <td>Pegawai Negeri Sipil (PNS)</td>
                                                <td>552</td>
                                            </tr>
                                            <tr>
                                                <td>Pedangang Swasta</td>
                                                <td>4.143</td>
                                            </tr>
                                            <tr>
                                                <td>TNI/Polri</td>
                                                <td>211</td>
                                            </tr>
                                            <tr>
                                                <td>Jasa</td>
                                                <td>275</td>
                                            </tr>
                                            <tr>
                                                <td>Karyawan Swasta</td>
                                                <td>9.352</td>
                                            </tr>
                                            <tr>
                                                <td>Pensiunan</td>
                                                <td>252</td>
                                            </tr>
                                            <tr>
                                                <td>Pemulung</td>
                                                <td>15</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pendidikan Penduduk</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tingkat Pendidikan</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>TK </td>
                                                <td>985</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Sekolah Dasar (SD) </td>
                                                <td>3.764</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>SMP </td>
                                                <td>2.704</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>SMA </td>
                                                <td>3.672</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Akademi </td>
                                                <td>547</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Sarjana </td>
                                                <td>364</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Pascasarjana </td>
                                                <td>16</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Pendidikan Khusus </td>
                                                <td>1.273</td>
                                                <td>Pondok Pesantren, Keagamaan, SLB, Kursus Ketrampilan</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Kesehatan Penduduk</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table5" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>2014 (Orang)</th>
                                                <th>2015 (Orang)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kelahiran Bayi</td>
                                                <td>224</td>
                                                <td>250</td>
                                            </tr>
                                            <tr>
                                                <td>Kematian Bayi</td>
                                                <td>7</td>
                                                <td>0</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Balita</td>
                                                <td>2.201</td>
                                                <td>2.251</td>
                                            </tr>
                                            <tr>
                                                <td>Kebijakan Kelurahan dalam Program Ibu dan Bayi serta Gerakan Sayang
                                                    Ibu</td>
                                                <td>-</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Imunisasi Polio</td>
                                                <td>100%</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Imunisasi DPT</td>
                                                <td>1.224</td>
                                                <td>250</td>
                                            </tr>
                                            <tr>
                                                <td>Imunisasi BCG</td>
                                                <td>224</td>
                                                <td>250</td>
                                            </tr>
                                            <tr>
                                                <td>Angka Harapan Hidup</td>
                                                <td>2.201</td>
                                                <td>2.250</td>
                                            </tr>
                                            <tr>
                                                <td>Penggunaan Mata Air</td>
                                                <td>2 RT</td>
                                                <td>2 RT</td>
                                            </tr>
                                            <tr>
                                                <td>Penggunaan Perpipaan</td>
                                                <td>3 RT</td>
                                                <td>3 RT</td>
                                            </tr>
                                            <tr>
                                                <td>Rumah Tangga Yang Memiliki Jamban</td>
                                                <td>-</td>
                                                <td>5.520</td>
                                            </tr>
                                            <tr>
                                                <td>Rumah Tangga Pengguna MCK</td>
                                                <td>12 RT</td>
                                                <td>15 RT</td>
                                            </tr>
                                            <tr>
                                                <td>Inovasi Kelurahan dalam Siaga Aktif</td>
                                                <td>1 Buah</td>
                                                <td>1 Buah</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Kegiatan yang Bertujuan Memperbaiki Kesehatan Lingkungan</td>
                                                <td>12 Kali</td>
                                                <td>12 Kali</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Usaha Kesehatan Yang Bersumber Daya Masyarakat</td>
                                                <td>10 Jenis</td>
                                                <td>10 Jenis</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Bimbingan dan Pengendalian Kegiatan Pengobatan Tradisional
                                                </td>
                                                <td>12 Kali</td>
                                                <td>12 Kali</td>
                                            </tr>
                                            <tr>
                                                <td>Perhargaan Yang Pernah Di Dapat Dalam Bidang Usaha Kesehatan</td>
                                                <td>5 Buah</td>
                                                <td>5 Buah</td>
                                            </tr>
                                            <tr>
                                                <td>Profil Posyandu</td>
                                                <td>1 Buah</td>
                                                <td>1 Buah</td>
                                            </tr>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                toastr.success('{{ session('message') }}');
            @endif
        });
    </script>
</body>

</html>
