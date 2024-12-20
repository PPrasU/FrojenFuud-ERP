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
                            <h5 class="m-0">Edit Request For Quotation</h5>
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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 class="m-0">RFQ{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}</h5>
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
                                <form action="/RequestForQuotation/update/{{ $data->id }}" method="POST" enctype="multipart/form-data" id="inputRequestForQuotation">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Vendor -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Vendor</label>
                                                    <select name="vendor_id" class="form-control" id="vendorSelect">
                                                        <option selected value="{{ $data->vendor->id }}" data-email="{{ $data->vendor->email }}">
                                                            {{ $data->vendor->nama }}
                                                        </option>
                                                        @foreach ($vendor as $row)
                                                            @if ($row->id != $data->vendor->id)
                                                                <option value="{{ $row->id }}" data-email="{{ $row->email }}">
                                                                    {{ $row->nama }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <!-- Tanggal Tenggat -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal Tenggat</label>
                                                    <input type="date" name="tanggal" class="form-control" id="tanggalInput" value="{{ $data->tanggal }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <!-- Reference -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reference</label>
                                                    <input type="text" name="reference" class="form-control" id="referenceInput" readonly value="{{ $data->reference }}">
                                                </div>
                                            </div>
                                            <!-- Company -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Company</label>
                                                    <input type="text" name="company" class="form-control" readonly value="Frojen Fuud">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Komponen/Bahan Baku -->
                                        <h5>Komponen/Bahan Baku</h5>
                                        <table class="table table-bordered" id="bahanTabel">
                                            <thead>
                                                <tr>
                                                    <th>Bahan</th>
                                                    <th>Kuantitas</th>
                                                    <th>Satuan</th>
                                                    <th>Tax</th>
                                                    <th>Subtotal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bahanTabelBody">
                                                @foreach ($data->bahans as $bahan)
                                                <tr>
                                                    <td>
                                                        <select class="form-control bahan-select" name="bahan_id[]">
                                                            <option selected value="{{ $bahan->id }}" data-harga="{{ $bahan->harga_bahan }}">
                                                                {{ $bahan->nama_bahan }}
                                                            </option>
                                                            @foreach ($bahanOptions as $row)
                                                                @if ($row->id != $bahan->id)
                                                                    <option value="{{ $row->id }}" data-harga="{{ $row->harga_bahan }}">
                                                                        {{ $row->nama_bahan }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" class="form-control" name="kuantitas[]" value="{{ $bahan->pivot->kuantitas }}"></td>
                                                    <td><input type="text" class="form-control" name="satuan[]" readonly value="{{ $bahan->satuan }}"></td>
                                                    <td><input type="text" class="form-control" name="tax[]" readonly value="{{ $bahan->pivot->tax }}"></td>
                                                    <td><input type="text" class="form-control" name="subtotal[]" readonly value="{{ $bahan->pivot->subtotal }}"></td>
                                                    <td><a class="btn btn-danger delete" style="cursor:pointer;">Hapus</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                            <a href="{{ route('RequestForQuotation') }}" class="btn btn-default">Batal</a>
                                            
                                            @if ($data->status === 'RFQ')
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal">Send by Email</button>
                                            @elseif ($data->status === 'RFQ Sent')
                                                <button type="submit" class="btn btn-success" name="ubah_ke_po" value="1">Konfirmasi PO</button>
                                            @else
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            @endif
                                    </div>
                                </form>
                                <div id="emailModal" class="modal fade" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="emailModalLabel">Send RFQ via Email</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/RequestForQuotation/sendEmail/{{ $data->id }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rfq_sent">
                                                    <div class="form-group">
                                                        <label for="emailTo">To:</label>
                                                        <input type="email" id="emailTo" name="emailTo" class="form-control" value="{{ $data->vendor->email }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emailSubject">Subject:</label>
                                                        <input type="text" id="emailSubject" name="emailSubject" class="form-control" placeholder="Email Subject" value="Request for Quotation - {{ $data->reference }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emailBody">Message:</label>
                                                        <textarea id="emailBody" name="emailBody" class="form-control" style="height: 200px;">
Kepada {{ $data->vendor->nama }},
Kita Frojen Fuud telah memesan bahan dengan nomor ref RFQ{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}, tolong segera untuk dilakukan pemrosesan.
Admin Frojen Fuud
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emailAttachment">Attachment:</label>
                                                        <input type="file" id="emailAttachment" name="emailAttachment" class="form-control">
                                                        <small class="form-text text-muted">Max. file size: 32MB</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Send Email</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
    {{-- Untuk Validasi Saat Isi Form Biar Ndak Kosongan --}}
    <script>
        $(function() {
            $('#inputBillOfMaterial').validate({
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

{{-- script email --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk memperbarui email pada input emailTo
            function updateEmailFields() {
                // Ambil email dari vendor yang dipilih
                var vendorEmail = $('#vendorSelect option:selected').data('email');
                // Set nilai emailTo jika vendor memiliki email
                if (vendorEmail) {
                    $('#emailTo').val(vendorEmail);
                } else {
                    $('#emailTo').val(''); // Kosongkan jika tidak ada email
                }
            }

            // Update email saat vendor berubah
            $('#vendorSelect').on('change', updateEmailFields);

            // Inisialisasi email pada saat halaman dimuat
            updateEmailFields();
        });
    </script>


{{-- script hitung --}}
    <script>
        document.querySelectorAll('.bahan-select').forEach(function(select) {
            select.addEventListener('change', function() {
                const selectedOption = select.options[select.selectedIndex];
                const harga_bahan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                const row = select.closest('tr'); // Dapatkan baris terkait
                const kuantitasInput = row.querySelector('input[name="kuantitas[]"]');
                const subtotalInput = row.querySelector('input[name="subtotal[]"]');

                // Hitung ulang subtotal saat bahan diubah
                const kuantitas = parseFloat(kuantitasInput.value) || 0;
                const subtotal = harga_bahan * kuantitas;
                subtotalInput.value = subtotal.toFixed(2);
            });
        });

        document.querySelectorAll('input[name="kuantitas[]"]').forEach(function(input) {
            input.addEventListener('input', function() {
                const row = input.closest('tr');
                const selectedOption = row.querySelector('.bahan-select option:checked');
                const harga_bahan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                const kuantitas = parseFloat(input.value) || 0;
                const subtotalInput = row.querySelector('input[name="subtotal[]"]');

                // Hitung ulang subtotal saat kuantitas berubah
                const subtotal = harga_bahan * kuantitas;
                subtotalInput.value = subtotal.toFixed(2);
            });
        });
    </script>

    <script>
        document.querySelectorAll('#bahanTabelBody tr').forEach(function(row) {
            const select = row.querySelector('.bahan-select');
            const selectedOption = select.options[select.selectedIndex];
            const harga_bahan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const kuantitasInput = row.querySelector('input[name="kuantitas[]"]');
            const subtotalInput = row.querySelector('input[name="subtotal[]"]');

            const kuantitas = parseFloat(kuantitasInput.value) || 0;
            const subtotal = harga_bahan * kuantitas;
            subtotalInput.value = subtotal.toFixed(2);
        });
     </script>

    {{-- buat tamabh bahan untuk produksi produk --}}
    <script>
        document.getElementById('addBahanButton').addEventListener('click', function() {
            const bahanTabelBody = document.getElementById('bahanTabelBody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <select class="form-control bahan-select" name="bahan_id[]">
                        <option selected disabled>--Pilih Bahan--</option>
                        @if ($bahanOptions && $bahanOptions->count())
                            @foreach ($bahanOptions as $row)
                                <option value="{{ $row->id }}" {{ $row->id == $bahan->id ? 'selected' : '' }}>
                                    [{{ $row->kode_bahan }}] {{ $row->nama_bahan }}
                                </option>
                            @endforeach
                        @else
                            <option disabled>Tidak ada bahan tersedia</option>
                        @endif
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Kuantitas" name="kuantitas[]">
                </td>
                <td>
                    <input type="text" class="form-control satuan-input" placeholder="Satuan" name="satuan[]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control tax-input" placeholder="tax" name="tax[]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control subtotal-input" placeholder="subtotal" name="subtotal[]" readonly>
                </td>
                <td>
                    <a class="btn btn-danger delete" style="cursor:pointer;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            `;

            // Append the new row
            bahanTabelBody.insertBefore(newRow, document.getElementById('addBahanRow'));

            // Add event listener for the bahan-select dropdown
            newRow.querySelector('.bahan-select').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const satuanInput = newRow.querySelector('.satuan-input');

                // Ambil satuan dari atribut data-satuan
                const satuan = selectedOption.getAttribute('data-satuan');

                // Isi input satuan dengan nilai satuan yang diambil
                satuanInput.value = satuan; // Set input dengan satuan yang sesuai
            });

            // Add event listener for the delete button
            newRow.querySelector('.delete').addEventListener('click', function() {
                newRow.remove();
            });

            // Append the new row before the "addBahanRow" row
            bahanTabelBody.insertBefore(newRow, document.getElementById('addBahanRow'));

            // Add event listener for the delete button
            newRow.querySelector('.delete').addEventListener('click', function() {
                newRow.remove();
            });
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
    </scrip>

    <script>
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
    </script>

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
</body>

</html>
