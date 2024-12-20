<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS dan jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<head>
    <title>FrojenFuud | Input Request For Quotation</title>
    @include('layouts/header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- dd([$data]) --}}
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
                            <h5 class="m-0">Input Request For Quotation</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchase</li>
                                <li class="breadcrumb-item"><a href="/RequestForQuotation">Request For Quotation</a>
                                <li class="breadcrumb-item"><a href="/RequestForQuotation/input">Input Data</a>
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
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if(session('Success'))
                                    <div class="alert alert-success">
                                        {{ session('Success') }}
                                    </div>
                                @endif
                                <form action="/RequestForQuotation/post" method="POST" enctype="multipart/form-data"
                                    id="inputRequestForQuotation">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Vendor -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Vendor</label>
                                                    <select name="vendor_id" class="form-control" id="vendorSelect">
                                                        <option selected disabled>-- Pilih Vendor --</option>
                                                        @foreach ($vendor as $row)
                                                            <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Tanggal -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="text" name="tanggal" class="form-control" id="tanggalInput" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <!-- Vendor Reference -->
                                            <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Vendor Reference</label>
                                                <input type="text" name="reference" class="form-control" id="vendorReferenceInput" readonly>
                                                </div>
                                            </div>
                                            <!-- Company -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Company</label>
                                                    <input type="text" name="company" class="form-control" id="company" readonly value="{{ 'Frojen Fuud' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="warningModal" tabindex="-1" role="dialog"
                                            aria-labelledby="warningModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Harap isi semua kolom sebelum menambah bahan baru.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <h5>Komponen/Bahan Baku</h5>
                                        <table class="table table-bordered" id="bahanTabel">
                                            <thead>
                                                <tr>
                                                    <th>Bahan</th>
                                                    <th>Harga bahan</th>
                                                    <th>Kuantitas</th>
                                                    <th>Satuan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bahanTabelBody">
                                                <tr id="addBahanRow">
                                                    <td colspan="4">
                                                        <button type="button" id="addBahanButton" class="btn btn-default">+ Tambah Bahan</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div id="bahanForm" style="display: none;">
                                            <button type="button" class="btn btn-primary">Tambahkan Bahan</button>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Harga Bahan</label>
                                            <input type="number" name="total" class="form-control" id="total" readonly placeholder="Rp.">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/RequestForQuotation" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
            $('#inputRequestForQuotation').validate({
                rules: {
                    produk: {
                        required: true,
                    },
                    referensi: {
                        required: true,
                    },
                    variasi_produk: {
                        required: true,
                    },
                    kuantitas: {
                        required: true,
                    },
                    satuan: {
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

    {{-- buat tambah bahan yang di purchase  --}}
    <script>
        document.getElementById('addBahanButton').addEventListener('click', function () {
            const bahanTabelBody = document.getElementById('bahanTabelBody');
            const newRow = document.createElement('tr');
    
            newRow.innerHTML = `
                <td>
                    <select class="form-control bahan-select" name="bahan_id[]">
                        <option selected disabled>-- Pilih Bahan --</option>
                        @foreach ($bahan as $row)
                            <option value="{{ $row->id }}" data-satuan="{{ $row->satuan }}" harga-bahan="{{ $row->harga_bahan }}">
                                [{{ $row->kode_bahan }}] {{ $row->nama_bahan }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control harga-bahan" placeholder="harga bahan" readonly>
                </td>
                <td>
                    <input type="number" class="form-control kuantitas" name="kuantitas[]" placeholder="Kuantitas" value="1">
                </td>
                <td>
                    <input type="text" class="form-control satuan-input" name="satuan[]" vak readonly>
                </td>
                
                <td>
                    <a class="btn btn-danger delete" style="cursor:pointer;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            `;
    
            // Tambahkan event listener untuk dropdown bahan
            newRow.querySelector('.bahan-select').addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const satuan = selectedOption.getAttribute('data-satuan');
                newRow.querySelector('.satuan-input').value = satuan;
            });
    
            // Event listener untuk tombol delete
            newRow.querySelector('.delete').addEventListener('click', function () {
                newRow.remove();
            });
    
            // Tambahkan baris ke tabel
            bahanTabelBody.insertBefore(newRow, document.getElementById('addBahanRow'));
        });
    </script>

    {{-- script untuk memilih produk otomatis --}}
    <script>
        const produkInput = document.getElementById('produkInput');
        const produkList = document.getElementById('produkList');
        const clearProduk = document.getElementById('clearProduk');
        const referenceInput = document.getElementById('referenceInput');
        let selectedProduk = ''; // Menyimpan produk yang dipilih

        // Data produk dari server (bisa juga didapatkan lewat AJAX)
        const produkData = [
            @foreach ($produk as $row)
                {
                    id: '{{ $row->id }}',
                    kode_produk: '{{ $row->kode_produk }}',
                    nama_produk: '{{ $row->nama_produk }}'
                },
            @endforeach
        ];

        // Event ketika mengetik di input
        produkInput.addEventListener('input', function() {
            const inputValue = produkInput.value.toLowerCase();
            produkList.innerHTML = ''; // Kosongkan list sebelumnya
            produkList.style.display = 'none'; // Sembunyikan saat kosong

            if (inputValue && !selectedProduk) { // Hanya lakukan pencarian jika belum ada produk yang dipilih
                // Filter produk yang sesuai dengan input
                const filteredProduk = produkData.filter(produk =>
                    produk.nama_produk.toLowerCase().includes(inputValue) ||
                    produk.kode_produk.toLowerCase().includes(inputValue)
                );

                // Tampilkan hasil pencarian
                if (filteredProduk.length > 0) {
                    produkList.style.display = 'block'; // Tampilkan jika ada hasil
                    filteredProduk.forEach(produk => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item');
                        li.style.cursor = 'pointer';
                        li.textContent = `[${produk.kode_produk}] ${produk.nama_produk}`;
                        li.setAttribute('data-kode', produk.kode_produk);
                        li.setAttribute('data-nama', produk.nama_produk);

                        // Event ketika salah satu produk dipilih
                        li.addEventListener('click', function() {
                            const kodeReferensi = produk.kode_produk.substring(0, 2)
                                .toUpperCase(); // Ambil 2 huruf pertama dari kode produk
                            produkInput.value =
                                `[${produk.kode_produk}] ${produk.nama_produk} ${kodeReferensi}`; // Update input dengan format baru
                            selectedProduk =
                                `[${produk.kode_produk}] ${produk.nama_produk} ${kodeReferensi}`; // Simpan produk yang dipilih
                            produkList.innerHTML = '';
                            produkList.style.display = 'none';
                            clearProduk.style.display = 'block'; // Tampilkan tombol X
                        });

                        produkList.appendChild(li);
                    });
                }
            } else if (selectedProduk) {
                produkInput.value = selectedProduk; // Kunci input ke produk yang dipilih jika mencoba menambah teks
            }
        });

        // Event untuk menutup list saat klik di luar area input atau list
        document.addEventListener('click', function(event) {
            if (!produkInput.contains(event.target) && !produkList.contains(event.target)) {
                produkList.style.display = 'none';
            }
        });

        // Event untuk tombol X (clear produk)
        clearProduk.addEventListener('click', function() {
            produkInput.value = ''; // Kosongkan input
            selectedProduk = ''; // Kosongkan pilihan produk
            clearProduk.style.display = 'none'; // Sembunyikan tombol X
            referenceInput.value = ''; // Kosongkan referensi
        });
    </script>

    {{-- <script>
        document.getElementById('produkSelect').addEventListener('change', function() {
            // Dapatkan elemen input untuk reference
            const referenceInput = document.getElementById('referenceInput');
            
            // Ambil value dari produk yang dipilih
            const selectedProduk = this.options[this.selectedIndex].text;
            
            // Split untuk mengambil kode produk (misal, [LA] Nama Produk)
            const kodeProduk = selectedProduk.match(/\[(.*?)\]/)[1];
            
            // Format reference dengan 'BoM_' diikuti kode produk dan angka increment (misal, BoM_LA1)
            const increment = 1; // Anda bisa sesuaikan increment ini secara manual
            const reference = `BoM_${kodeProduk}${increment}`;
            
            // Masukkan hasil reference ke input field
            referenceInput.value = reference;
        });
    </script> --}}

    {{-- Auto Date --}}
    <script>
        // JavaScript untuk mengisi tanggal hari ini
        document.addEventListener("DOMContentLoaded", function () {
            const tanggalInput = document.getElementById("tanggalInput");
            const today = new Date();
            const formattedDate = today.toISOString().split("T")[0]; // Format: YYYY-MM-DD
            tanggalInput.value = formattedDate; // Isi input dengan tanggal hari ini
        });
    </script>

    <script>
        document.getElementById('produkSelect').addEventListener('change', function () {
            // Ambil opsi yang dipilih
            var selectedOption = this.options[this.selectedIndex];

            // Ambil data-reference dari opsi yang dipilih
            var reference = selectedOption.getAttribute('data-reference');

            // Masukkan nilai referensi ke input teks
            document.getElementById('referenceInput').value = reference;
        });
    </script>

    <script>
        // Data vendor diambil dari backend
        const vendors = @json($vendor);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const vendorSelect = document.getElementById('vendorSelect');
            const vendorReferenceInput = document.getElementById('vendorReferenceInput');

            // Tambahkan event listener untuk dropdown vendor
            vendorSelect.addEventListener('change', function() {
                const selectedVendorId = vendorSelect.value;

                // Cari vendor berdasarkan ID yang dipilih
                const selectedVendor = vendors.find(vendor => vendor.id == selectedVendorId);

                // Set value di input referensi vendor
                if (selectedVendor) {
                    vendorReferenceInput.value = selectedVendor.kategori || ''; // Pastikan properti sesuai database
                } else {
                    vendorReferenceInput.value = ''; // Kosongkan jika vendor tidak ditemukan
                }
            });
        });
    </script>




    <script>
        $(document).on('change', '.bahan-select', function() {
            var selectedOption = $(this).find('option:selected');
            var hargaBahan = selectedOption.attr('harga-bahan');  // Ambil harga dari atribut option
            // Isi nilai harga bahan
            $(this).closest('tr').find('.harga-bahan').val(hargaBahan);
        });
    </script>

    <script>
        $(document).on('change', '.bahan-select, .kuantitas', function() {
            var totalHarga = 0;

            // Loop melalui semua baris di tabel
            $('#bahanTabelBody tr').each(function() {
                var hargaBahan = parseFloat($(this).find('.harga-bahan').val()) || 0; // Harga bahan
                var kuantitas = parseFloat($(this).find('.kuantitas').val()) || 0;   // Kuantitas

                // Jika harga bahan atau kuantitas valid
                if (hargaBahan > 0 && kuantitas > 0) {
                    var subtotal = hargaBahan * kuantitas;
                    $(this).find('.subtotal').text(`Rp. ${subtotal.toLocaleString()}`); // Tampilkan subtotal per baris
                    totalHarga += subtotal; // Tambahkan ke total keseluruhan
                }
            });

            // Update nilai total keseluruhan
            $('#total').val(totalHarga.toFixed(2)); // Format angka menjadi dua desimal
        });
    </script>
                                            {{-- @php
                                            dd([$total])
                                            @endphp --}}
                                            
</body>

</html>
