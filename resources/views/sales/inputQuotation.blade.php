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
                            <h5 class="m-0">Input Quotation</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Sales</li>
                                <li class="breadcrumb-item"><a href="/Quotation">Quotation</a>
                                <li class="breadcrumb-item"><a href="/Quotation/input">Input Quotation</a>
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
                                                    <input type="text" name="nomor_quotation" class="form-control" value="{{ $newNumber }}" readonly>
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
                                                    <select class="form-control select2" name="pembayaran_id" id="pembayaran_id" style="width: 100%;">
                                                        <option selected disabled>--Pilih Metode Pembayaran--</option>
                                                        @foreach ($pembayaran as $row)
                                                            <option value="{{ $row->id }}" data-pembayaran="{{ $row->jenis_pembayaran }}">
                                                                {{ $row->jenis_pembayaran }}{{ $row->nomor_bayar ? ' [' . $row->nomor_bayar . ']' : '' }}
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
                                                    <th>subtotal</th>
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
                                        <h5 style="text-align: right; font-weight: bold;">Total Sebelum Pajak: <span id="totalSebelumPajak">Rp. 0</span></h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Pajak: <span id="totalPajak">Rp. 0</span></h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Keseluruhan: <span id="totalKeseluruhan">Rp. 0</span></h5>

                                        <input type="number" id="totalSebelumPajak_inputdisplay" name="total_sebelum_pajak" placeholder="Total Sebelum Pajak" readonly hidden>
                                        <input type="number" id="totalPajak_inputdisplay" name="total_pajak" placeholder="Total Pajak" readonly hidden>
                                        <input type="number" id="totalKeseluruhan_inputdisplay" name="total_keseluruhan" placeholder="Total Keseluruhan" readonly hidden>


                                    </div>
                                    
                                    <div class="card-footer">
                                        <a href="/Quotation" class="btn btn-default">Batal</a>
                                        <button type="submit" class="btn btn-primary">Simpan Sebagai Draft</button>
                                        {{-- <button type="submit" class="btn btn-warning">Send By Email</button>
                                        <button type="submit" class="btn btn-success">Konfirmasi Quotation</button> --}}
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
                    produk_id: {
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

    {{-- Script Untuk subtotal, total sebelum pajak, total pajak, dan total keseluruhan Otomatis --}}
    <script>
        $(document).ready(function () {
            // Fungsi untuk format angka dengan titik
            function formatRupiah(angka) {
                return "Rp. " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            
            // Fungsi menghitung subtotal, pajak, dan total keseluruhan
            function updateTotals() {
                let totalSebelumPajak = 0;
                let totalPajak = 0;

                $("#produkTabel tbody tr").each(function () {
                    const row = $(this);
                    const harga = parseInt(row.find(".produk-dropdown option:selected").data("harga")) || 0;
                    const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 0;
                    const pajakRate = parseInt(row.find(".pajak-select").val()) || 0;

                    const subtotal = kuantitas * harga; // Subtotal sebelum pajak
                    const pajak = subtotal * (pajakRate / 100); // Hitung pajak
                    const total = subtotal + pajak; // Total dengan pajak

                    row.find(".harga-input").val(formatRupiah(harga));
                    row.find(".total-input").val(total);

                    totalSebelumPajak += subtotal;
                    totalPajak += pajak;
                });

                // Update tampilan total
                $("#totalSebelumPajak").text(formatRupiah(totalSebelumPajak));
                $("#totalPajak").text(formatRupiah(totalPajak));
                $("#totalKeseluruhan").text(formatRupiah(totalSebelumPajak + totalPajak));
            }

            updateTotals();

            $("#produkTabel").on("input", ".kuantitas-input", function () {
                const value = parseInt($(this).val());
                if (value < 1 || isNaN(value)) {
                    $(this).val(1); // Reset ke 1 jika invalid
                }
            });

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
            document.getElementById("tanggal_quotation").value = today;

            // Fungsi untuk menghitung tanggal 30 hari ke depan
            function calculateBerlakuHingga(tanggal) {
                const date = new Date(tanggal);
                date.setDate(date.getDate() + 30);
                return date.toISOString().split("T")[0];
            }

            // Isi otomatis input "Berlaku Hingga" saat halaman dimuat
            const berlakuHingga = calculateBerlakuHingga(today);
            document.getElementById("berlaku_hingga").value = berlakuHingga;

            // Update "Berlaku Hingga" secara otomatis saat "Tanggal Dibuat" diubah
            document.getElementById("tanggal_quotation").addEventListener("change", function() {
                const newTanggal = this.value;
                const newBerlakuHingga = calculateBerlakuHingga(newTanggal);
                document.getElementById("berlaku_hingga").value = newBerlakuHingga;
            });
            
            const maxProduk = 4; // Jumlah total produk yang tersedia

            function updateAddProdukButtonVisibility() {
                const selectedProduk = new Set();
                $("#produkTabel tbody select.produk-dropdown").each(function () {
                    const value = $(this).val();
                    if (value) selectedProduk.add(value); // Tambahkan produk yang dipilih
                });

                // Sembunyikan tombol jika semua produk dipilih, tampilkan jika tidak
                if (selectedProduk.size >= maxProduk) {
                    $("#addProdukButton").hide();
                } else {
                    $("#addProdukButton").show();
                }
            }

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
                            <select class="form-control produk-dropdown select2" name="produk_id[]" id="produk_id">
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
                            <select class="form-control pajak-select" name="tax[]" data-manual="false">
                                <option value="0">0%</option>
                                <option value="10">10%</option>
                                <option value="11">11%</option>
                                <option value="12">12%</option>
                                <option value="20">20%</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control total-input" name="subtotal[]" readonly>
                        </td>
                        <td>
                            <a class="btn btn-danger delete" style="cursor:pointer;">
                                <i class="fas fa-trash" style="color: white"></i>
                            </a>
                        </td>
                    </tr>
                `;

                // Tambahkan baris baru
                $("#produkTabel tbody").append(newRow);
                $("#produkTabel tbody").append($("#addProdukButton"));

                // Inisialisasi Select2 untuk elemen baru
                $("#produkTabel tbody tr:last .select2").select2({
                    placeholder: "--Pilih Produk--",
                    width: '100%' // Atur lebar Select2 agar sesuai
                });

                // Perbarui visibilitas tombol
                updateAddProdukButtonVisibility();
            });
    
            // Hapus Produk
            $(document).on("click", ".delete", function () {
                $(this).closest("tr").remove();
                updateTotals();
                updateAddProdukButtonVisibility();
            });

            $(document).on("change", ".produk-dropdown", function () {
                updateAddProdukButtonVisibility();
            });
            updateAddProdukButtonVisibility();
    
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
                const hargaFormatted = hargaProduk ? (hargaProduk) : "Rp. 0";
                row.find(".harga-input").val(hargaFormatted); // Isi harga dengan format Rp.
    
                // Hitung total
                const pajakRate = parseInt(pajakSelect.val()) || 0; // Persentase pajak
                const total = kuantitas * (hargaProduk || 0);
                row.find(".total-input").val(total); // Total dengan format Rp.
            });
    
            // Deteksi perubahan manual pada pajak
            $("#produkTabel").on("change", ".pajak-select", function () {
                $(this).data("manual", true); // Tandai bahwa pajak diubah manual
                const row = $(this).closest("tr");
    
                // Update total setelah perubahan pajak manual
                const hargaProduk = parseInt(row.find(".produk-dropdown option:selected").data("harga"));
                const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 1;
                const pajakRate = parseInt($(this).val()) || 0;
    
                const total = kuantitas * hargaProduk;
                row.find(".total-input").val(total);
            });

            $("#produkTabel").on("change", ".produk-dropdown, .kuantitas-input, .pajak-select", function () {
                const row = $(this).closest("tr");
                const hargaProduk = parseInt(row.find(".produk-dropdown option:selected").data("harga")) || 0;
                const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 0;
                const pajakRate = parseInt(row.find(".pajak-select").val()) || 0;

                // Hitung subtotal untuk baris saat ini
                const subtotal = kuantitas * hargaProduk;
                const pajak = subtotal * (pajakRate / 100);

                // Update Harga Satuan dan Subtotal di baris
                row.find(".harga-input").val(formatRupiah(hargaProduk));
                row.find(".total-input").val(subtotal);

                // Update Total Keseluruhan
                updateTotals();
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

    <script>
        $(document).ready(function () {
            // Fungsi untuk menghitung subtotal, pajak, dan total keseluruhan
            function updateTotals() {
                let totalSebelumPajak = 0;
                let totalPajak = 0;

                $("#produkTabel tbody tr").each(function () {
                    const row = $(this);
                    const harga = parseInt(row.find(".produk-dropdown option:selected").data("harga")) || 0;
                    const kuantitas = parseInt(row.find(".kuantitas-input").val()) || 0;
                    const pajakRate = parseInt(row.find(".pajak-select").val()) || 0;

                    const subtotal = kuantitas * harga; // Subtotal sebelum pajak
                    const pajak = subtotal * (pajakRate / 100); // Hitung pajak
                    const total = subtotal + pajak; // Total dengan pajak

                    row.find(".harga-input").val(harga);
                    row.find(".total-input").val(subtotal);

                    totalSebelumPajak += subtotal;
                    totalPajak += pajak;
                });

                // Update tampilan total
                $("#totalSebelumPajak").text(formatRupiah(totalSebelumPajak));
                $("#totalPajak").text(formatRupiah(totalPajak));
                $("#totalKeseluruhan").text(formatRupiah(totalSebelumPajak + totalPajak));

                // Mengisi ke input display tanpa format "Rp."
                $("#totalSebelumPajak_inputdisplay").val(totalSebelumPajak);
                $("#totalPajak_inputdisplay").val(totalPajak);
                $("#totalKeseluruhan_inputdisplay").val(totalSebelumPajak + totalPajak);
            }

            // Format angka menjadi format Rupiah (untuk tampilan)
            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Update totals ketika ada perubahan pada kuantitas atau pajak
            $("#produkTabel").on("change", ".produk-dropdown, .kuantitas-input, .pajak-select", function () {
                updateTotals(); // Update totals setiap ada perubahan
            });

            // Panggil fungsi untuk update totals saat halaman dimuat
            updateTotals();
        });
    </script>

    
</body>

</html>
