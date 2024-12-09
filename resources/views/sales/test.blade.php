<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Input Quotation</title>
    @include('layouts/header')
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <h5 class="m-0">Input Draft Quotation</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Sales</li>
                                <li class="breadcrumb-item"><a href="/Quotation">Quotation</a>
                                <li class="breadcrumb-item"><a href="/Quotation/input">Input Data</a>
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
                                <form action="/Quotation/post" method="POST" enctype="multipart/form-data"
                                    id="inputQuotation">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Pelanggan</label>
                                                    <select class="form-control select2" name="customer_id"
                                                        id="customer_id" style="width: 100%;">
                                                        <option selected disabled>--Pilih Pelanggan--</option>
                                                        @foreach ($customer as $row)
                                                            <option value="{{ $row->id }}"
                                                                data-pelanggan="{{ $row->nama }}">
                                                                [{{ $row->kategori }}] {{ $row->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Quotation</label>
                                                    <input type="text" name="nomor_quotation" class="form-control"
                                                        id="nomor_quotation" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal Dibuat</label>
                                                    <input type="date" name="tanggal_quotation" class="form-control"
                                                        id="tanggal_quotation">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Berlaku Hingga</label>
                                                    <input type="date" name="berlaku_hingga" class="form-control"
                                                        id="berlaku_hingga">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Metode Pembayaran</label>
                                                    <select class="form-control select2" name="pembayaran_id"
                                                        id="pembayaran_id" style="width: 100%;">
                                                        <option selected disabled>--Pilih Metode Pembayaran--</option>
                                                        @foreach ($pembayaran as $row)
                                                            <option value="{{ $row->id }}"
                                                                data-pembayaran="{{ $row->jenis_pembayaran }}">
                                                                {{ $row->jenis_pembayaran }} -- [{{ $row->nomor_bayar }}]
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <h5>Pilih Produk Yang Akan Dibeli</h5>
                                        <table class="table table-bordered" id="produkTabel">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Kuantitas</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Pajak</th>
                                                    <th>Total</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="produkTabelBody">
                                                <tr id="addProdukRow">
                                                    <td colspan="5"><button type="button" id="addProdukButton"
                                                            class="btn btn-primary">+ Tambah Produk</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p style="text-align: right">=====================================</p>
                                        <h5 style="text-align: right; font-weight: bold;">Total Sebelum Pajak: Rp
                                            Rp. ............</h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Pajak: Rp
                                            Rp. ............</h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Keseluruhan: Rp
                                            Rp. ...............</h5>
                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="/Quotation" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan Draft</button>
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
            $('.select2').select2()
            $('#inputQuotation').validate({
                rules: {
                    customer_id: {
                        required: true,
                    },
                    nomor_quotation: {
                        required: true,
                    },
                    tanggal_quotation: {
                        required: true,
                    },
                    berlaku_hingga: {
                        required: true,
                    },
                    pembayaran_id: {
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

    {{-- Script Untuk Nomor Quotation Otomatis --}}
    <script>
        $(document).ready(function () {
            // Fungsi untuk format angka dengan titik
            function formatRupiah(angka) {
                return "Rp. " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
    
            // Generate Nomor Quotation Otomatis
            let lastNomor = "S00000"; // Fetch from server if needed
            function generateNomorQuotation() {
                const currentNumber = parseInt(lastNomor.slice(1)) + 1;
                const newNumber = `S${currentNumber.toString().padStart(5, "0")}`;
                $("#nomor_quotation").val(newNumber);
            }
            generateNomorQuotation();
    
            // Set Tanggal Otomatis
            const today = new Date().toISOString().split("T")[0];
            $("#tanggal_quotation").val(today);
    
            // Tambah Produk
            $("#addProdukButton").click(function () {
                const isValid = $("#produkTabel tbody tr:last select, #produkTabel tbody tr:last input").toArray().every(input => input.value.trim() !== "");
                if (!isValid) {
                    alert("Isi semua kolom sebelum menambah produk baru!");
                    return;
                }
    
                // Buat baris baru
                const newRow = `
                    <tr>
                        <td>
                            <select class="form-control produk-dropdown select2" name="produk_id[]">
                                <option selected disabled>--Pilih Produk--</option>
                                @foreach ($produk as $row)
                                    <option value="{{ $row->id }}" data-harga="{{ $row->harga_produk }}">
                                        [{{ $row->kode_produk }}] {{ $row->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control kuantitas-input" name="kuantitas[]" value="1">
                        </td>
                        <td>
                            <input type="text" class="form-control harga-input" name="harga[]" readonly>
                        </td>
                        <td>
                            <select class="form-control pajak-select" name="pajak[]" data-manual="false">
                                <option value="0">0%</option>
                                <option value="10">10%</option>
                                <option value="11">11%</option>
                                <option value="12">12%</option>
                                <option value="20">20%</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control total-input" name="total[]" readonly>
                        </td>
                        <td>
                            <a class="btn btn-danger delete" style="cursor:pointer;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                `;
    
                // Tambahkan baris baru ke atas dan tombol ke bawah
                $("#produkTabel tbody").prepend(newRow); // Menambahkan baris ke atas
                $("#produkTabel tbody").append($("#addProdukButton")); // Memindahkan tombol ke bawah setelah baris baru
    
                // Inisialisasi Select2 untuk elemen baru
                $("#produkTabel tbody tr:first .select2").select2({
                    placeholder: "--Pilih Produk--",
                    width: '100%' // Atur lebar Select2 agar sesuai
                });
            });
    
            // Hapus Produk
            $(document).on("click", ".delete", function () {
                $(this).closest("tr").remove();
            });
    
            // Logika otomatis dan manual untuk pajak dan total
            $("#produkTabel").on("change", ".produk-dropdown, .kuantitas-input, .pajak-select", function () {
                const row = $(this).closest("tr");
                const selectedOption = row.find(".produk-dropdown option:selected");
                const hargaProduk = selectedOption.data("harga");
                const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 1;
                const pajakSelect = row.find(".pajak-select");
    
                // Jika perubahan bukan pada pajak (atau pajak belum diubah manual)
                if (!$(this).hasClass("pajak-select") || pajakSelect.data("manual") === false) {
                    // Hitung pajak otomatis berdasarkan kuantitas
                    let pajakValue = 0;
                    if (kuantitas >= 50 && kuantitas <= 99) {
                        pajakValue = 10;
                    } else if (kuantitas >= 100 && kuantitas <= 499) {
                        pajakValue = 11;
                    } else if (kuantitas >= 500 && kuantitas <= 999) {
                        pajakValue = 12;
                    } else if (kuantitas >= 1000) {
                        pajakValue = 20;
                    } else {
                        pajakValue = 0;
                    }
                    pajakSelect.val(pajakValue); // Atur nilai pajak otomatis
                    pajakSelect.data("manual", false); // Reset ke mode otomatis
                }
    
                // Format harga
                const hargaFormatted = hargaProduk ? formatRupiah(hargaProduk) : "Rp. 0";
                row.find(".harga-input").val(hargaFormatted); // Isi harga dengan format Rp.
    
                // Hitung total
                const pajakRate = parseInt(pajakSelect.val()) || 0; // Persentase pajak
                const total = kuantitas * (hargaProduk || 0) * (1 + pajakRate / 100);
                row.find(".total-input").val(formatRupiah(total)); // Total dengan format Rp.
            });
    
            // Deteksi perubahan manual pada pajak
            $("#produkTabel").on("change", ".pajak-select", function () {
                $(this).data("manual", true); // Tandai bahwa pajak diubah manual
                const row = $(this).closest("tr");
    
                // Update total setelah perubahan pajak manual
                const hargaProduk = parseInt(row.find(".produk-dropdown option:selected").data("harga")) || 0;
                const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 1;
                const pajakRate = parseInt($(this).val()) || 0;
    
                const total = kuantitas * hargaProduk * (1 + pajakRate / 100);
                row.find(".total-input").val(formatRupiah(total));
            });
    
            // Inisialisasi Select2 pada elemen yang sudah ada
            $(".select2").select2({
                placeholder: "--Pilih Produk--",
                width: '100%' // Atur lebar Select2 agar sesuai
            });
    
            // Menambahkan margin pada tombol + Tambah Produk
            $("#addProdukButton").css({
                "margin": "10px",
            });
        });
    </script>
    
    
    
</body>

</html>
