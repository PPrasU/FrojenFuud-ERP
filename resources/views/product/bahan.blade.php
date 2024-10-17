<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Bahan Baku</title>
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
            z-index: 1;
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
                            <h1 class="m-0">Bahan Baku</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/bahan-baku">Bahan Baku</a>
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
                                            <a href="/bahan-baku/input" class="btn btn-app" style="left: -10px;">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            @if (count($data) > 0)
                                                <button type="button" class="btn btn-app" style="left: -10px;"
                                                    onclick="openModal()">
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
                                                        <form action="{{ route('exportBahan') }}" method="POST"
                                                            id="exportForm">
                                                            @csrf
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll"></th>
                                                                        <th>Pilih Semua Bahan</th>
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
                                                                            <td>{{ $item->nama_bahan }}</td>
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
                                            <a href="#" id="btnList" class="btn btn-app">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="btnKanban" class="btn btn-app">
                                                <i class="fa fa-columns"></i> Kanban
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Untuk bagian list atau tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Nama Bahan</th>
                                                <th style="vertical-align: middle;">Harga Bahan</th>
                                                <th style="vertical-align: middle;">Satuan</th>
                                                <th style="vertical-align: middle;">Jenis Bahan</th>
                                                <th style="vertical-align: middle;">Kode Bahan (Barcode)</th>
                                                <th style="vertical-align: middle;">Gambar</th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->nama_bahan }}</td>
                                                    <td>{{ $row->harga_bahan }}</td>
                                                    <td>{{ $row->satuan }}</td>
                                                    <td>{{ $row->jenis_bahan }}</td>
                                                    <td>
                                                        <svg id="barcode-{{ $row->id }}"></svg>
                                                        <script>
                                                            JsBarcode("#barcode-{{ $row->id }}", "{{ $row->kode_bahan }}", {
                                                                format: "CODE128",
                                                                displayValue: true,
                                                                fontSize: 16
                                                            });
                                                        </script>
                                                    </td>
                                                    <td><img src="{{ asset('foto-bahan/' . $row->gambar) }}"
                                                            style="width: 100px; height: 100px; "></td>
                                                    <td style="text-align: center">
                                                        <a href="/bahan-baku/edit/{{ $row->id }}"
                                                            class="btn btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-danger delete"
                                                            data-id="{{ $row->id }}"
                                                            data-nama_bahan="{{ $row->nama_bahan }}">Hapus</a>
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
                                                    <div class="inner">
                                                        <h3>{{ $row->nama_bahan }}</h3>
                                                        <p>Rp. {{ $row->harga_bahan }}</p>
                                                        <div style="text-align: right;">
                                                            <a class="btn btn-danger delete"
                                                                data-id="{{ $row->id }}"
                                                                data-nama_bahan="{{ $row->nama_bahan }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <div class="icon">
                                                        <i class="ion"><img style="width: 120px;"
                                                                src="{{ asset('foto-bahan/' . $row->gambar) }}"
                                                                style="width: 50px; height: 50px;"></i>

                                                    </div>
                                                    <a href="/bahan-baku/edit/{{ $row->id }}"
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

            // Konfirmasi hapus dengan SweetAlert
            $('.delete').click(function() {
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
                            window.location = "/bahan-baku/hapus/" + id + "",
                        )
                    }
                });
            });
        });
    </script>

    {{-- script untuk kanban --}}
    <script>
        // Fungsi untuk menampilkan tampilan sesuai preferensi yang tersimpan di localStorage
        function applyViewPreference() {
            const viewPreference = localStorage.getItem('viewPreference'); // Ambil preferensi dari localStorage
            if (viewPreference === 'list') {
                $('#kanbanView').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView').removeClass('hidden');
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#btnList').click(function() {
                $('#kanbanView').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
            });

            $('#btnKanban').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
            });
        });
    </script>

    <!-- JavaScript untuk Modal dan Pilih Semua -->
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
