<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Detail Bill Of Material</title>
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
                            <h5 class="m-0">Detail Bill Of Material</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Manufacturing</li>
                                <li class="breadcrumb-item"><a href="/BillOfMaterial">Bill Of Material</a>
                                <li class="breadcrumb-item"><a href="/BillOfMaterial/edit">Detail Data</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header" style="height: 1px;">
                                </div>
                                <form action="/BillOfMaterial/update/{{ $data->id }}" method="POST"
                                    enctype="multipart/form-data" id="editBillOfMaterial">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Produk</label>
                                                    <select class="form-control" name="produk_id" id="produkSelect"
                                                        value="{{ $data->produk->nama_produk }}" @readonly(true)>
                                                        <option selected>[{{ $data->produk->kode_produk }}]
                                                            {{ $data->produk->nama_produk }}</option>
                                                        <option disabled>-- Pilih Produk --</option>
                                                        @foreach ($produk as $row)
                                                            <option value="{{ $row->id }}">
                                                                [{{ $row->kode_produk }}] {{ $row->nama_produk }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Reference</label>
                                                    <input type="text" name="reference" class="form-control"
                                                        id="referenceInput" value="{{ $data->reference }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="kuantitas_produk">Kuantitas Produk Yang
                                                        Dihasilkan</label>
                                                    <input type="number" name="kuantitas_produk" class="form-control"
                                                        id="kuantitas_produk" value="{{ $data->kuantitas_produk }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Variasi BOM</label>
                                                    <select class="form-control" name="variasi" @readonly(true)
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
                                                    <th>BoM Cost</th>
                                                    <th>Product Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalBoMCost = 0;
                                                    $totalProductCost = 0;
                                                @endphp

                                                @foreach ($bom->bahans as $bahan)
                                                    @php
                                                        $bomCost = $bahan->harga_bahan * $bahan->pivot->kuantitas;
                                                        $productCost = $bomCost; // Sesuaikan dengan logika biaya produk yang sebenarnya
                                                        $totalBoMCost += $bomCost;
                                                        $totalProductCost += $productCost;
                                                    @endphp
                                                    <tr>
                                                        <td>[{{ $bahan->kode_bahan }}] {{ $bahan->nama_bahan }}</td>
                                                        <td>{{ $bahan->pivot->kuantitas }} {{ $bahan->pivot->satuan }}
                                                        </td>
                                                        <td>Rp. {{ number_format($bomCost, 0, ',', '.') }}</td>
                                                        <td>Rp. {{ number_format($productCost, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <p style="text-align: right">=====================================</p>
                                        <h5 style="text-align: right; font-weight: bold;">Total BoM Cost: Rp
                                            {{ number_format($totalBoMCost, 0, ',', '.') }}</h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Product Cost: Rp
                                            {{ number_format($totalProductCost, 0, ',', '.') }}</h5>

                                    </div>
                                    {{-- <div class="card-footer">
                                        <a href="/BillOfMaterial" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                    </div> --}}
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

    {{-- buat tamabh bahan untuk produksi produk --}}
    <script>
        document.getElementById('addBahanButton').addEventListener('click', function() {
            const bahanTabelBody = document.getElementById('bahanTabelBody');
            const newRow = document.createElement('tr');

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
    </script>
</body>

</html>
