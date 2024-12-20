<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Request For Quotation</title>
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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    @php
    // dd($data);
    @endphp
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Request For Quotation</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchase</li>
                                <li class="breadcrumb-item"><a href="/RequestForQuotation">Request For Quotation</a>
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
                                            <a href="/RequestForQuotation/input" class="btn btn-app"
                                                style="left: -10px;">
                                                <i class="fas fa-plus"></i> Tambah Data
                                            </a>
                                            @if (count($data) > 0)
                                            <button type="button" class="btn btn-app" style="left: -10px;"
                                                onclick="openModal()" title="Export PDF">
                                                <i class="fa fa-file-pdf"></i> Export PDF
                                            </button>
                                            @endif

                                            <!-- Modal Export PDF -->
                                            <div id="exportModal" class="modal">
                                                <div class="modal-content">
                                                    <div style="margin-left: 0;">
                                                        <h2>Export PDF</h2>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('exportRequestForQuotation') }}" method="POST" id="exportForm">
                                                            @csrf
                                                            <input type="hidden" name="vendor_id" id="vendor_id" value="{{ $vendor_id ?? '' }}">
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th>
                                                                        <th>Pilih Semua RFQ</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($data as $item)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox" name="items[]" class="itemCheckbox" value="{{ $item->id }}">
                                                                        </td>
                                                                        <td>{{ $item->id }} - RFQ000{{ $item->id }}</td>
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
                                            <a href="#" id="tombol-list-BOM" class="btn btn-app">
                                                <i class="fas fa-list"></i> List / Tabel
                                            </a>
                                            <a href="#" id="tombol-kanbam-BOM" class="btn btn-app">
                                                <i class="fa fa-columns"></i> Kanban
                                            </a>
                                        </div>
                                    </div>
                                    {{-- Untuk bagian list atau tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Reference</th>
                                                <th style="vertical-align: middle;">Vendor</th>
                                                <th style="vertical-align: middle;">Order Date</th>
                                                <th style="vertical-align: middle;">Total</th>
                                                <th style="vertical-align: middle;">Status</th>
                                                <th style="vertical-align: middle;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                            <tr>
                                                <td>RFQ{{ str_pad($row->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $row->vendor->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                                                <td>Rp{{ number_format($row->total, 0, ',', '.') }}</td>
                                                <td class="badge 
                                                        @if ($row->status == 'RFQ')
                                                            bg-secondary
                                                        @elseif ($row->status == 'RFQ Sent')
                                                            bg-info
                                                        @elseif ($row->status == 'PO')
                                                            bg-success
                                                        @elseif ($row->status == 'Cancelled')
                                                            bg-danger
                                                        @endif
                                                        d-flex justify-content-center align-items-center p-2 m-3">
                                                    {{ $row->status }}
                                                </td>
                                                <td style="text-align: center">
                                                    @if($row->status == 'PO')
                                                    <a href="/RequestForQuotation/edit/{{ $row->id }}"
                                                        class="btn btn-info {{ $row->status == 'PO' ? 'detail-btn' : 'edit-btn' }}"
                                                        title="Ubah">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @else
                                                    <a href="/RequestForQuotation/edit/{{ $row->id }}"
                                                        class="btn btn-warning edit-btn" title="Ubah">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endif
                                                    <form action="{{ route('RequestForQuotation.hapus', $row->id) }}"
                                                        method="POST" style="display: inline-block;"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- untuk bagian kanbannya --}}
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
                window.location.href = '/RequestForQuotation/edit/' + id;
            });

            $('#tableList').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var nama_produk = $(this).attr('data-produk');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data bahan " + nama_produk + " Akan Dihapus dengan id -> " + id,
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
                            window.location = "/RequestForQuotation/hapus/" + id + "",
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
                $('#kanbanView-BoM').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                $('#tombol-list-BOM').addClass('hidden');
                $('#tombol-kanbam-BOM').removeClass('hidden');
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-BoM').removeClass('hidden');
                $('#tombol-list-BOM').removeClass('hidden');
                $('#tombol-kanbam-BOM').addClass('hidden');
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#tombol-list-BOM').click(function() {
                $('#kanbanView-BoM').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
                $('#tombol-list-BOM').addClass('hidden');
                $('#tombol-kanbam-BOM').removeClass('hidden');
            });

            $('#tombol-kanbam-BOM').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-BoM').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
                $('#tombol-kanbam-BOM').addClass('hidden');
                $('#tombol-list-BOM').removeClass('hidden');
            });
        });
    </script>

    {{-- script ekspor --}}
    <script>
        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById("exportModal").style.display = "flex";  // Menampilkan modal dengan transparansi
        }
    
        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById("exportModal").style.display = "none";  // Menyembunyikan modal
        }
    
        // Fungsi untuk submit form ekspor
        function submitForm() {
            // Menyusun data ID yang dipilih untuk dikirim
            var selectedItems = [];
            var checkboxes = document.querySelectorAll('.itemCheckbox:checked');  // Menyaring checkbox yang dipilih
            checkboxes.forEach(function(checkbox) {
                selectedItems.push(checkbox.value);  // Menambahkan ID yang dipilih ke array
            });
    
            // Menambahkan data ke dalam form input tersembunyi untuk dikirim
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "items[]";  // Pastikan sesuai dengan name dalam form
            input.value = selectedItems.join(',');  // Menggabungkan ID dengan koma
            document.getElementById("exportForm").appendChild(input);  // Menambahkan input ke dalam form
    
            // Submit form
            document.getElementById("exportForm").submit();
            closeModal();  // Menutup modal setelah submit
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
    
    {{-- style ekspor --}}
    <style>
        /* Modal container */
        .modal {
            display: none;
            /* Modal disembunyikan secara default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            /* Background transparan dengan warna gelap */
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

        .modal {
            animation: fadeIn 0.3s ease-out;
        }

        /* Animasi untuk modal muncul */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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

</body>

</html>