<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Edit Bill Of Material</title>
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
                            <h5 class="m-0">Edit Bill Of Material</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/BillOfMaterial">Bill Of Material</a>
                                <li class="breadcrumb-item"><a href="/BillOfMaterial/edit">Edit Data</a>
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
                                <form action="/BillOfMaterial/update/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data" id="editBillOfMaterial">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Produk</label>
                                                    <select name="produk_id" class="form-control" id="produkSelect">
                                                        <!-- Menampilkan produk yang sudah dipilih -->
                                                        <option selected value="{{ $data->produk->id }}">
                                                            [{{ $data->produk->kode_produk }}]
                                                            {{ $data->produk->nama_produk }}
                                                        </option>

                                                        <!-- Menampilkan produk lain, kecuali produk yang sudah dipilih -->
                                                        @foreach ($produk as $row)
                                                        @if ($row->id != $data->produk->id)
                                                        <option value="{{ $row->id }}">
                                                            [{{ $row->kode_produk }}] {{ $row->nama_produk }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Reference</label>
                                                    <input type="text" name="reference" class="form-control"
                                                        id="referenceInput" readonly value="{{ $data->reference }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label>Variasi BOM</label>
                                                    <select class="form-control" name="variasi"
                                                        value="{{ $data->variasi }}">
                                                        <option selected>{{ $data->variasi }}</option>
                                                        <option disabled>-- Pilih --</option>
                                                        <option>Manufacture This Product</option>
                                                        <option>Kit</option>
                                                        <option>Subcontracting BoM</option>
                                                        <option>Phantom BoM</option>
                                                    </select>
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
                                        <h5>Komposisi Bahan Yang Digunakan Untuk Membuat Produk</h5>
                                        <table class="table table-bordered" id="bahanTabel">
                                            <thead>
                                                <tr>
                                                    <th>Bahan</th>
                                                    <th>Kuantitas</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bahanTabelBody">
                                                @foreach($bahanBoM as $index => $bomBahan)
                                                <tr>
                                                    <td>
                                                        <select class="form-control bahan-select" name="bahan_id[]">
                                                            @foreach ($bahan as $row)
                                                            <option value="{{ $row->id }}"
                                                                data-satuan="{{ $row->satuan }}" {{ $bomBahan->bahan_id
                                                                == $row->id ? 'selected' : '' }}>
                                                                [{{ $row->kode_bahan }}] {{ $row->nama_bahan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            placeholder="Kuantitas" name="kuantitas[]"
                                                            value="{{ $bomBahan->kuantitas }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control satuan-input"
                                                            placeholder="Satuan" name="satuan[]" readonly
                                                            value="{{ $bomBahan->satuan }}">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="harga_satuan[]" value="{{ $bomBahan->harga_satuan }}">
                                                        <input type="text" class="form-control satuan-input" 
                                                               value="Rp {{ number_format($bomBahan->harga_satuan, 0, ',', '.') }}" 
                                                               readonly>
                                                    </td>                                                    
                                                    <td>
                                                        <a class="btn btn-danger delete" style="cursor:pointer;">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach

                                                <tr id="addBahanRow">
                                                    <td colspan="4">
                                                        <button type="button" id="addBahanButton"
                                                            class="btn btn-default">+ Tambah Bahan</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div id="bahanForm" style="display: none;">
                                            <button type="button" class="btn btn-primary">Tambahkan Bahan</button>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/BillOfMaterial" class="btn btn-default">Batal</a>
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
        $(function () {
            $('#editBillOfMaterial').validate({
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
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

    <script>
        document.getElementById('addBahanButton').addEventListener('click', function() {
            const bahanTabelBody = document.getElementById('bahanTabelBody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <select class="form-control bahan-select" name="bahan_id[]">
                        <option selected disabled>--Pilih Bahan--</option>
                        @foreach ($bahan as $row)
                            <option value="{{ $row->id }}" data-satuan="{{ $row->satuan }}">
                                [{{ $row->kode_bahan }}] {{ $row->nama_bahan }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" placeholder="Kuantitas" name="kuantitas[]">
                </td>
                <td>
                    <input type="text" class="form-control satuan-input" placeholder="Satuan" name="satuan[]" readonly>
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
                satuanInput.value = satuan;
            });

            // Add event listener for the delete button
            newRow.querySelector('.delete').addEventListener('click', function() {
                newRow.remove();
            });
        });

        // Tambahkan event listener untuk setiap bahan yang sudah ada
        document.querySelectorAll('.bahan-select').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const satuanInput = this.closest('tr').querySelector('.satuan-input');

                // Ambil satuan dari atribut data-satuan
                const satuan = selectedOption.getAttribute('data-satuan');

                // Isi input satuan dengan nilai satuan yang diambil
                satuanInput.value = satuan;
            });
        });

        // Add delete functionality for already loaded bahan rows
        document.querySelectorAll('.delete').forEach(function(deleteButton) {
            deleteButton.addEventListener('click', function() {
                this.closest('tr').remove();
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
        produkInput.addEventListener('input', function () {
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
                        li.addEventListener('click', function () {
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
        document.addEventListener('click', function (event) {
            if (!produkInput.contains(event.target) && !produkList.contains(event.target)) {
                produkList.style.display = 'none';
            }
        });

        // Event untuk tombol X (clear produk)
        clearProduk.addEventListener('click', function () {
            produkInput.value = ''; // Kosongkan input
            selectedProduk = ''; // Kosongkan pilihan produk
            clearProduk.style.display = 'none'; // Sembunyikan tombol X
            referenceInput.value = ''; // Kosongkan referensi
        });
    </script>

    <script>
        document.getElementById('produkSelect').addEventListener('change', function () {
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
</body>

</html>