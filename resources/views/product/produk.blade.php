<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Produk</title>
    @include('layouts/header')

    {{-- CSS untuk tabel --}}
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

    <!-- CSS untuk Modal -->
    <style>
        /* Modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050v;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            margin: auto;
        }

        /* Footer */
        .modal-footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        /* Button styles */
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-left: 10px;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            opacity: 0.9;
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
                                            <a href="/produk/input" class="btn btn-app" style="left: -10px;"
                                                title="Tambah Data">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            @if (count($data) > 0)
                                                <!-- Tombol untuk membuka modal -->
                                                <button type="button" class="btn btn-app" style="left: -10px;"
                                                    onclick="openModal()" title="Export PDF">
                                                    <i class="fa fa-file-pdf"></i> Export PDF
                                                </button>
                                            @endif

                                            <!-- Modal Custom -->
                                            <div id="exportModal" class="modal">
                                                <div class="modal-content">
                                                    <div style="margin-left: 0;">
                                                        <h2>Export Produk PDF</h2>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form untuk memilih produk yang akan diekspor -->
                                                        <form action="{{ route('exportProduk') }}" method="POST"
                                                            id="exportForm">
                                                            @csrf
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll"></th>
                                                                        <th>Pilih Semua Produk</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($data as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="items[]"
                                                                                    class="itemCheckbox"
                                                                                    value="{{ $item->id }}">
                                                                            </td>
                                                                            <td>{{ $item->nama_produk }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="submitForm()">Cetak</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="closeModal()">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            <a href="#" id="btnList" class="btn btn-app">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="btnKanban" class="btn btn-app hidden">
                                                <i class="fa fa-columns"></i> Kanban
                                            </a>
                                            <a href="#" id="btnBarcode" class="btn btn-app">
                                                <i class="fa fa-barcode"></i> Generate Barcode
                                            </a>
                                        </div>
                                    </div>
                                    {{-- bagian tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Nama Produk</th>
                                                <th style="vertical-align: middle;">Kode Produk</th>
                                                <th style="vertical-align: middle;" id="barcodeHeader" class="hidden">
                                                    Barcode</th>
                                                <th style="vertical-align: middle;">Harga Produk (Sales Price)</th>
                                                <th style="vertical-align: middle;">Harga Produksi (Cost)</th>
                                                <th style="vertical-align: middle;">Gambar</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->nama_produk }}</td>
                                                    <td>{{ $row->kode_produk }}</td>
                                                    <td id="barcodeColumn-{{ $row->id }}" class="hidden">
                                                        <svg id="barcode-{{ $row->id }}"></svg>
                                                        <script>
                                                            JsBarcode("#barcode-{{ $row->id }}", "{{ $row->kode_produk }}", {
                                                                format: "CODE128",
                                                                displayValue: true,
                                                                fontSize: 16
                                                            });
                                                        </script>
                                                    </td>
                                                    <td>{{ $row->harga_produk }}</td>
                                                    <td>{{ $row->harga_produksi }}</td>
                                                    <td class="d-flex justify-content-center align-items-center p-2 m-3">
                                                        <img src="{{ asset('foto-produk/' . $row->gambar) }}">
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="/produk/edit/{{ $row->id }}"
                                                            class="btn btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger delete"
                                                            data-id="{{ $row->id }}"
                                                            data-nama_produk="{{ $row->nama_produk }}" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- bagian kanban --}}
                                    <div id="kanbanView-Produk" class="row hidden">
                                        @foreach ($data as $row)
                                            <div class="col-lg-4 col-6">
                                                <div class="small-box">
                                                    <div class="inner">
                                                        <h4 style="font-weight: bold">{{ $row->nama_produk }}</h4>
                                                        <p>Harga: Rp. {{ $row->harga_produk }}/Pcs</p>
                                                        <p>Stok: {{ $row->kuantitas_produk }} Pcs</p>
                                                        <div style="text-align: right;">
                                                            <a class="btn btn-danger delete"
                                                                data-id="{{ $row->id }}"
                                                                data-nama_produk="{{ $row->nama_produk }}"
                                                                title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion"><img style="width: 120px; height: 100px;"
                                                                src="{{ asset('foto-produk/' . $row->gambar) }}"></i>
                                                    </div>
                                                    <a href="/produk/edit/{{ $row->id }}"
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
                window.location.href = '/produk/edit/' + id;
            });

            $('#tableList').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var nama_produk = $(this).attr('data-nama_produk');
                var kode_produk = $(this).attr('data-kode_produk');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data bahan " + nama_produk + " Akan Dihapus",
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

    {{-- script untuk preferensi button list dan kanban --}}
    <script>
        // Fungsi untuk menampilkan tampilan sesuai preferensi yang tersimpan di localStorage
        function applyViewPreference() {
            const viewPreference = localStorage.getItem('viewPreference'); // Ambil preferensi dari localStorage
            if (viewPreference === 'list') {
                $('#kanbanView-Produk').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
                $('#btnBarcode').removeClass('hidden'); // Tampilkan tombol Generate Barcode
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-Produk').removeClass('hidden');
                $('#btnList').removeClass('hidden');
                $('#btnKanban').addClass('hidden');
                $('#btnBarcode').addClass('hidden'); // Sembunyikan tombol Generate Barcode
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#btnList').click(function() {
                $('#kanbanView-Produk').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
                $('#btnBarcode').removeClass('hidden'); // Tampilkan tombol Generate Barcode
            });

            $('#btnKanban').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-Produk').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
                $('#btnKanban').addClass('hidden');
                $('#btnList').removeClass('hidden');
                $('#btnBarcode').addClass('hidden'); // Sembunyikan tombol Generate Barcode
            });

            // Logika untuk toggle barcode
            let barcodeVisible = false;

            $('#btnBarcode').click(function() {
                if (!barcodeVisible) {
                    // Menampilkan SweetAlert untuk menunggu 5 detik
                    Swal.fire({
                        title: 'Generating Barcode...',
                        text: 'Please wait for 5 seconds',
                        icon: 'info',
                        timer: 5000, // 5 detik
                        timerProgressBar: true,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading(); // Tampilkan loading saat SweetAlert terbuka
                        }
                    }).then(() => {
                        // Setelah SweetAlert ditutup, baru tampilkan barcode
                        $('[id^=barcodeColumn]').removeClass('hidden'); // Menampilkan kolom barcode
                        $('#barcodeHeader').removeClass('hidden');
                        $('#btnBarcode').html('<i class="fa fa-barcode"></i> Hide Barcode');
                        barcodeVisible = true;
                    });
                } else {
                    // Menyembunyikan barcode jika tombol "Hide Barcode" ditekan
                    $('[id^=barcodeColumn]').addClass('hidden'); // Menyembunyikan kolom barcode
                    $('#barcodeHeader').addClass('hidden');
                    $('#btnBarcode').html('<i class="fa fa-barcode"></i> Generate Barcode');
                    barcodeVisible = false;
                }
            });
        });
    </script>

    {{-- script untuk button generate barcode --}}
    <script>
        $(document).ready(function() {
            let barcodeVisible = false;

            $('#btnBarcode').click(function() {
                barcodeVisible = !barcodeVisible;

                // Toggle visibilitas kolom barcode
                if (barcodeVisible) {
                    $('[id^=barcodeColumn]').removeClass('hidden'); // Menampilkan kolom barcode
                    $('#barcodeHeader').removeClass('hidden');
                    $('#btnBarcode').html('<i class="fa fa-barcode"></i> Hide Barcode');
                } else {
                    $('[id^=barcodeColumn]').addClass('hidden'); // Menyembunyikan kolom barcode
                    $('#barcodeHeader').addClass('hidden');
                    $('#btnBarcode').html('<i class="fa fa-barcode"></i> Generate Barcode');
                }
            });
        });
    </script>

    <!-- JavaScript untuk Modal -->
    <script>
        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById("exportModal").style.display = "flex";
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("exportModal").style.display = "none";
        }

        // Fungsi untuk submit form
        function submitForm() {
            document.getElementById("exportForm").submit();
        }

        // Menutup modal ketika user klik di luar modal
        window.onclick = function(event) {
            if (event.target == document.getElementById("exportModal")) {
                closeModal();
            }
        }
    </script>

    {{-- Script pilih semua --}}
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.itemCheckbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</body>

</html>
