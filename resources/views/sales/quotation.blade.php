<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Daftar Quotation</title>
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
            z-index: 1050;
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
                            <h1 class="m-0">Quotation</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Sales</li>
                                <li class="breadcrumb-item"><a href="/Quotation">Quotation</a>
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
                                            <a href="/Quotation/input" class="btn btn-app" style="left: -10px;"
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
                                                        <h2>Export Quotation PDF</h2>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form untuk memilih Quotation yang akan diekspor -->
                                                        <form action="{{ route('exportQuotation') }}" method="POST"
                                                            id="exportForm">
                                                            @csrf
                                                            <table>
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll"></th>
                                                                        <th>Pilih Semua Quotation</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($data as $item)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" name="items[]" class="itemCheckbox" id="item-{{ $item->id }}" value="{{ $item->id }}">
                                                                            </td>
                                                                            <td><label for="item-{{ $item->id }}">{{ $item->nomor_quotation }}</label></td>
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
                                        </div>
                                    </div>
                                    {{-- bagian tabel --}}
                                    <table id="tableList" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="vertical-align: middle;">Nomor</th>
                                                <th style="vertical-align: middle;">Customer</th>
                                                <th style="vertical-align: middle;">Tanggal Dibuat</th>
                                                {{-- <th style="vertical-align: middle;">Masa Berlaku</th> --}}
                                                <th style="vertical-align: middle;">Produk</th>
                                                {{-- <th style="vertical-align: middle;">Jenis Pembayaran</th> --}}
                                                <th style="vertical-align: middle;">Total</th>
                                                <th style="vertical-align: middle;">Status </th>
                                                <th style="vertical-align: middle;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $row)
                                                <tr>
                                                    <td>{{ $row->nomor_quotation }}</td>
                                                    <td>{{ $row->customer->nama }}</td>
                                                    <td>{{ $row->tanggal_quotation }}</td>
                                                    {{-- <td>{{ $row->berlaku_hingga }}</td> --}}
                                                    <td>
                                                        <ul>
                                                            @foreach ($row->produks as $produk)
                                                                <li>
                                                                    {{ $produk->nama_produk }},  
                                                                    {{ $produk->pivot->kuantitas }} Pcs 
                                                                </li>
                                                            @endforeach
                                                            {{-- @foreach ($row->produks as $produk)
                                                                <li>
                                                                    {{ $produk->nama_produk }},  
                                                                    {{ $produk->pivot->kuantitas }} Pcs --->  
                                                                    Rp{{ number_format($produk->pivot->subtotal, 0, ',', '.') }}
                                                                </li>
                                                            @endforeach --}}
                                                        </ul>
                                                    </td>
                                                    {{-- <td>{{ $row->pembayaran->jenis_pembayaran }}</td> --}}
                                                    <td>Rp{{ number_format($row->total_keseluruhan, 0, ',', '.') }}</td>
                                                    <td class="badge 
                                                        @if ($row->status == 'Draft')
                                                            bg-secondary
                                                        @elseif ($row->status == 'Sent')
                                                            bg-info
                                                        @elseif ($row->status == 'Confirmed to Sales Order')
                                                            bg-success
                                                        @elseif ($row->status == 'Cancelled')
                                                            bg-danger
                                                        @endif
                                                        d-flex justify-content-center align-items-center p-2 m-3">
                                                        {{ $row->status }}
                                                    </td>
                                                    <td style="text-align: center">
                                                        <a href="/Quotation/edit/{{ $row->id }}"
                                                            class="btn btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-danger delete"
                                                            data-id="{{ $row->id }}"
                                                            data-nomor_quotation="{{ $row->nomor_quotation }}" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- bagian kanban --}}
                                    <div id="kanbanView-Quotation" class="row hidden">
                                        @foreach ($data as $row)
                                            <div class="col-lg-4 col-6">
                                                <div class="small-box">
                                                    <div class="inner">
                                                        <div class="inner d-flex justify-content-between align-items-center">
                                                            <h4 style="font-weight: bold; margin: 0;">{{ $row->nomor_quotation }}</h4>
                                                            <p style="font-weight: bold; margin: 0; text-align: right;">
                                                                {{ \Carbon\Carbon::parse($row->tanggal_quotation)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($row->berlaku_hingga)->format('d-m-Y') }}
                                                            </p>
                                                        </div>
                                                        <br>
                                                        <p>Customer: {{ $row->customer->nama }}</p>
                                                        <p>Rp{{ number_format($row->total_keseluruhan, 0, ',', '.') }}</p>
                                                        <div class="badge 
                                                            @if ($row->status == 'Draft')
                                                                bg-secondary
                                                            @elseif ($row->status == 'Sent')
                                                                bg-info
                                                            @elseif ($row->status == 'Confirmed to Sales Order')
                                                                bg-success
                                                            @elseif ($row->status == 'Cancelled')
                                                                bg-danger
                                                            @endif
                                                            p-2 mt-1">
                                                            Status: {{ $row->status }}
                                                        </div>

                                                        <div style="text-align: right;">
                                                            <a href="/Quotation/edit/{{ $row->id }}" class="btn btn-warning" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-danger delete" data-id="{{ $row->id }}" data-nomor_quotation="{{ $row->nomor_quotation }}" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
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
                window.location.href = '/Quotation/edit/' + id;
            });

            $('#tableList').on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var nomor_quotation = $(this).attr('data-nomor_quotation');
                Swal.fire({
                    title: 'Apakah Kamu Ingin Menghapus Data Ini?',
                    text: "Data bahan " + nomor_quotation + " Akan Dihapus",
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
                            window.location = "/Quotation/hapus/" + id + "",
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
                $('#kanbanView-Quotation').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
            } else if (viewPreference === 'kanban') {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-Quotation').removeClass('hidden');
                $('#btnList').removeClass('hidden');
                $('#btnKanban').addClass('hidden');
            }
        }

        $(document).ready(function() {
            applyViewPreference(); // Terapkan tampilan berdasarkan preferensi yang tersimpan

            // Untuk tombol List dan Kanban
            $('#btnList').click(function() {
                $('#kanbanView-Quotation').addClass('hidden');
                $('#tableList_wrapper').removeClass('hidden');
                localStorage.setItem('viewPreference', 'list'); // Simpan preferensi pengguna
                $('#btnList').addClass('hidden');
                $('#btnKanban').removeClass('hidden');
            });

            $('#btnKanban').click(function() {
                $('#tableList_wrapper').addClass('hidden');
                $('#kanbanView-Quotation').removeClass('hidden');
                localStorage.setItem('viewPreference', 'kanban'); // Simpan preferensi pengguna
                $('#btnKanban').addClass('hidden');
                $('#btnList').removeClass('hidden');
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
            const checkboxes = document.querySelectorAll('.itemCheckbox:checked');
            if (checkboxes.length === 0) {
                alert('Pilih setidaknya satu Quotation untuk diekspor.');
                return;
            }
            document.getElementById('exportForm').submit();
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
