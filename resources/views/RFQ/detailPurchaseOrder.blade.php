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
                            <h1 class="m-0">Purchase Order</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Purchase</li>
                                <li class="breadcrumb-item"><a href="/PurchaseOrder">Purchase Order</a></li>
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
                                <div class="card-header">
                                    <h3>Detail Purchase Order (PO)</h3>
                                </div>
                                <div class="card-body">
                                    <h5>Informasi PO</h5>
                                    <table class="table">
                                        <tr>
                                            <td>Reference</td>
                                            <td>{{ $PO->reference }}</td>
                                        </tr>
                                        <tr>
                                            <td>Confirmation Date</td>
                                            <td>{{ $PO->tanggal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Vendor</td>
                                            <td>{{ $PO->vendor->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ number_format($PO->total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td class="badge 
                                                @if ($PO->status_po == 'Nothing to bill') 
                                                {{-- bg-secondary --}}
                                                @elseif ($PO->status_po == 'Waiting to bill') 
                                                {{-- bg-info --}}
                                                @elseif ($PO->status_po == 'Fully billed') 
                                                {{-- bg-success --}}
                                                @elseif ($PO->status_po == 'Cancelled') 
                                                {{-- bg-danger --}}
                                                @endif">{{ $PO->status_po }}
                                            </td>
                                        </tr>
                                    </table>
                            
                                    <h5>Komponen/Bahan Baku</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bahan</th>
                                                <th>Harga</th>
                                                <th>Kuantitas</th>
                                                <th>Received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($PO->bahans as $bahan)
                                                <tr>
                                                    <td>{{ $bahan->nama_bahan }}</td>
                                                    <td>{{ number_format($bahan->harga_bahan, 2) }}</td>
                                                    <td>{{ $bahan->pivot->kuantitas }}</td>
                                                    <td>
                                                        @if ($PO->received === 'Sudah')
                                                            <span class="badge bg-success">Sudah</span>
                                                        @elseif ($PO->received === 'Belum')
                                                            <span class="badge bg-secondary">Belum</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $PO->received }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        @if ($PO->status_po == 'Nothing to bill')
                                            <form action="{{ route('purchase_orders.receive', $PO->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">
                                                    Receive Product
                                                </button>
                                            </form>
                                        @elseif ($PO->status_po == 'Waiting to bill' && $PO->status_bill == 'Draft')
                                            <form action="{{ route('rfq.createBill', $PO->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    Create Bill
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            // Fungsi untuk memperbarui email pada input
            function updateEmailFields() {
                var vendorEmail = $('#vendorSelect option:selected').data('email');
                $('#emailTo').val(vendorEmail);
            }

            // Update email ketika vendor berubah
            $('#vendorSelect').on('change', updateEmailFields);

            // Inisialisasi saat halaman dimuat
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
    {{-- <script>
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
    </script> --}}

    {{-- script untuk memilih produk otomatis --}}
    {{-- <script>
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
    </scrip> --}}

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
