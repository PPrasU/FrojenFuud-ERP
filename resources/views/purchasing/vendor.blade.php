<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Vendor</title>
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
    <!-- CSS untuk Modal -->
    <style>
        /* Modal container */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 1);
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

        /* Header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        /* Close button */
        .close {
            cursor: pointer;
            font-size: 24px;
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

        /* Form styling */
        .form-group {
            margin-bottom: 10px;
        }

        .checkbox {
            margin: 5px 0;
        }
    </style>
    {{-- CSS Kanban --}}
    <style>
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
        }

        .card h5 {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card h6 {
            margin-bottom: 1rem;
            color: gray;
            font-style: italic;
        }

        .card p {
            margin: 0.3rem 0;
            font-size: 0.95rem;
        }

        .card .text-end {
            margin-top: 1rem;
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
                            <h1 class="m-0">Vendor</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchasing</li>
                                <li class="breadcrumb-item"><a href="/Vendor-">Vendor</a>
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
                                            <a href="/Vendor/input" class="btn btn-app" style="left: -10px;"
                                                title="Tambah Data">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            @if (count($data) > 0)
                                                <button type="button" class="btn btn-app" style="left: -10px;"
                                                    onclick="openModal()" title="Export PDF">
                                                    <i class="fa fa-file-pdf"></i> Export PDF
                                                </button>
                                            @endif
                                            <div id="exportModal" class="modal">
                                                <div class="modal-content">
                                                    <div style="margin-left: 0;">
                                                        {{-- <span class="close" onclick="closeModal()">&times;</span> --}}
                                                        <h2>Export PDF</h2>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('exportVendor') }}" method="POST"
                                                            id="exportForm">
                                                            @csrf
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll"></th>
                                                                        <th>Pilih Semua Vedor</th>
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
                                                                            <td>{{ $item->nama }}</td>
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
                                                            onclick="closeModal()">batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="text-align: right">
                                            <a href="#" id="btnList" class="btn btn-app" title="List / Tabel">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="btnKanban" class="btn btn-app hidden"
                                                title="Kanban View">
                                                <i class="fa fa-columns"></i>Kanban
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Untuk bagian list atau tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Nama Vendor</th>
                                                <th style="vertical-align: middle;">No Hp</th>
                                                <th style="vertical-align: middle;">Kategori</th>
                                                <th style="vertical-align: middle;">Email</th>
                                                <th style="vertical-align: middle;">Alamat</th>
                                                <th style="vertical-align: middle;">NPWP</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->nama }}</td>
                                                    <td>{{ $row->no_hp }}</td>
                                                    <td>{{ $row->kategori }}</td>
                                                    <td>{{ $row->email }}</td>
                                                    <td>{{ $row->alamat_1 }}, {{ $row->alamat_2 }}</td>
                                                    <td>{{ $row->npwp }}</td>
                                                    <td style="text-align: center">
                                                        <a href="/Vendor/edit/{{ $row->id }}"
                                                            class="btn btn-warning edit-btn" title="Ubah">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger delete delete-btn"
                                                            data-id="{{ $row->id }}"
                                                            data-nama_bahan="{{ $row->nama_bahan }}" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- untuk bagian kanbannya --}}
                                    <div id="kanbanView" class="row hidden">
                                        @foreach ($data as $row)
                                            <div class="col-lg-4 col-6">
                                                <div class="small-box">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            {{ $row->nama }}
                                                        </h3>
                                                        <p>.</p>
                                                        <p>'</p>
                                                        <h5 style="font-style: italic; text-align: left">
                                                            {{ $row->kategori }}</h5>
                                                    </div>
                                                    <div class="inner">
                                                        <p style="text-align: left">Alamat: {{ $row->alamat_1 }},
                                                            {{ $row->alamat_2 }}</p>
                                                        <p style="text-align: left">No Hp : {{ $row->no_hp }}</p>
                                                        <p style="text-align: left">Email : {{ $row->email }}</p>
                                                        <p style="text-align: left">NPWP : {{ $row->npwp }}</p>
                                                        <div style="text-align: right;">
                                                            <a class="btn btn-danger delete"
                                                                data-id="{{ $row->id }}"
                                                                data-nama_bahan="{{ $row->nama_bahan }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <a href="/Vendor/edit/{{ $row->id }}"
                                                        class="small-box-footer" style="color: black;">More info
                                                        <i class="fas fa-arrow-circle-right" style="color: black;">
                                                        </i>
                                                    </a>
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

    {{-- script untuk tabel --}}
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
                window.location.href = '/Vendor/edit/' + id;
            });

            $('#tableList').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var nama_bahan = $(this).attr('data-nama_bahan');
                var kode_bahan = $(this).attr('data-kode_bahan');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data bahan " + nama_bahan + " Akan Dihapus",
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
                            window.location = "/Vendor/hapus/" + id + "",
                        )
                    }
                });
            });
        });
    </script>

    {{-- Script untuk reference pada button kanban & list tabel --}}
    <script>
        // Fungsi untuk menampilkan tampilan sesuai preferensi yang tersimpan di localStorage
        function applyViewPreference() {
            const viewPreference = localStorage.getItem('viewPreference'); // Ambil preferensi dari localStorage
            if (viewPreference === 'list') {
                $('#kanbanView').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
                $('#btnBarcode').removeClass('hidden'); // Tampilkan tombol Generate Barcode
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView').removeClass('hidden');
                $('#btnList').removeClass('hidden');
                $('#btnKanban').addClass('hidden');
                $('#btnBarcode').addClass('hidden'); // Sembunyikan tombol Generate Barcode
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#btnList').click(function() {
                $('#kanbanView').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
                $('#btnBarcode').removeClass('hidden'); // Tampilkan tombol Generate Barcode
            });

            $('#btnKanban').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
                $('#btnKanban').addClass('hidden');
                $('#btnList').removeClass('hidden');
                $('#btnBarcode').addClass('hidden'); // Sembunyikan tombol Generate Barcode
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

    <!-- JavaScript untuk Modal dan Pilih Semua -->
    <script>
        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById("exportModal").style.display = "flex";
            document.body.style.overflow = "hidden";
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("exportModal").style.display = "none";
            document.body.style.overflow = "auto";
        }

        // Fungsi untuk submit form
        function submitForm() {
            document.getElementById("exportForm").submit();
        }

        // Fungsi untuk "Pilih Semua"
        function toggleSelectAll() {
            var selectAllCheckbox = document.getElementById("selectAll");
            var itemCheckboxes = document.getElementsByClassName("itemCheckbox");

            for (var i = 0; i < itemCheckboxes.length; i++) {
                itemCheckboxes[i].checked = selectAllCheckbox.checked;
            }
        }

        // Menutup modal ketika user klik di luar modal
        window.onclick = function(event) {
            if (event.target == document.getElementById("exportModal")) {
                closeModal();
            }
        }
    </script>

    {{-- script untuk pilih semua --}}
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.itemCheckbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</body>

</html>
