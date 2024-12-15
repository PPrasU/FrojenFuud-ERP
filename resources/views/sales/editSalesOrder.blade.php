<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Edit Sales Order</title>
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
                            <h5 class="m-0">Edit Pesanan</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Sales</li>
                                <li class="breadcrumb-item"><a href="/SalesOrder">Pesanan</a>
                                <li class="breadcrumb-item"><a href="/SalesOrder/edit/{{ $data->id }}">Edit Pesanan</a>
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
                                <form action="/SalesOrder/update/{{ $data->id }}" method="POST" enctype="multipart/form-data"
                                    id="editSalesOrder">
                                    @csrf
                                    @if ($data->status == 'Fully Invoiced')
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-success p-2 mt-1">
                                                {{ $data->status }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($data->status == 'Cancelled')
                                        <div class="ribbon-wrapper ribbon-xl">
                                            <div class="ribbon bg-danger p-2 mt-1">
                                                {{ $data->status }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Pelanggan</label>
                                                    <input readonly type="text" name="nama" class="form-control" id="nama" value="[{{ $data->customer->kategori }}] {{ $data->customer->nama }}">
                                                </div>                                                                                                                                           
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Sales Order</label>
                                                    <input readonly type="text" name="nomor_sales_order" class="form-control" id="nomor_sales_order" value="{{ $data->quotation->nomor_quotation }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal Dibuat</label>
                                                    <input readonly type="date" name="tanggal_quotation" class="form-control"
                                                        id="tanggal_quotation" value="{{ $data->quotation->tanggal_quotation }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Metode Pembayaran</label>
                                                    <input readonly type="text" name="nama" class="form-control" id="nama" value="{{ $data->pembayaran->jenis_pembayaran }}{{ $data->pembayaran->nomor_bayar ? ' [' . $data->pembayaran->nomor_bayar . ']' : '' }}">
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
                                                    <th>Pengiriman</th>
                                                    <th></th>
                                                    <th>Penagihan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Pajak (%)</th>
                                                    <th>subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->quotation->produks as $row)
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="produk_id[]" readonly value="{{ $row->nama_produk }}"></td>
                                                        <td><input type="number" class="form-control" name="kuantitas[]" readonly value="{{ $row->pivot->kuantitas }}" min="0"></td>
                                                        
                                                        <td class="badge 
                                                            @if ($data->pengiriman == 'Belum')
                                                                bg-secondary
                                                            @elseif ($data->pengiriman == 'Tervalidasi')
                                                                bg-info
                                                            @elseif ($data->pengiriman == 'Tidak Memenuhi')
                                                                bg-danger
                                                            @elseif ($data->pengiriman == 'Selesai')
                                                                bg-success
                                                            @endif
                                                            d-flex justify-content-center align-items-center p-2 m-3">
                                                            {{ $data->pengiriman }} 
                                                        </td>
                                                        <td></td>

                                                        <td class="badge 
                                                            @if ($data->penagihan == 'Belum')
                                                                bg-secondary
                                                            @elseif ($data->penagihan == 'Sudah Dibuat')
                                                                bg-success
                                                            @endif
                                                            d-flex justify-content-center align-items-center p-2 m-3">
                                                            {{ $data->penagihan }}
                                                        </td>

                                                        <td><input type="text" class="form-control harga" name="harga[]" readonly value="{{ number_format($row->pivot->harga, 0, '.', '') }}"></td>
                                                        <td><input type="text" class="form-control tax" name="tax[]" readonly value="{{ number_format($row->pivot->tax, 0, '.', '') }}"></td>
                                                        <td><input type="text" class="form-control subtotal" name="subtotal[]" readonly value="{{ number_format($row->pivot->subtotal, 0, '.', '') }}"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <p style="text-align: right">=====================================</p>
                                        <h5 style="text-align: right; font-weight: bold;">Total Sebelum Pajak: <span id="totalSebelumPajak">Rp. 0</span></h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Pajak: <span id="totalPajak">Rp. 0</span></h5>
                                        <h5 style="text-align: right; font-weight: bold;">Total Keseluruhan: <span id="totalKeseluruhan">Rp. 0</span></h5>

                                        <input type="number" id="totalSebelumPajak_inputdisplay" name="total_sebelum_pajak" value="{{ $data->quotation->total_sebelum_pajak }}" readonly hidden>
                                        <input type="number" id="totalPajak_inputdisplay" name="total_pajak" value="{{ $data->quotation->total_pajak }}" readonly hidden>
                                        <input type="number" id="totalKeseluruhan_inputdisplay" name="total_keseluruhan" value="{{ $data->quotation->total_keseluruhan }}" readonly hidden>
                                    </div>
                                    <div class="card-footer">
                                        <a href="/SalesOrder" class="btn btn-secondary">Kembali</a>
                                        <!-- Tombol Konfirmasi Perubahan hanya tampil jika status bukan 'Sent' -->
                                        @if ($data->status != 'Fully Invoiced' && $data->status != 'Cancelled' && $data->penagihan == 'Belum')
                                            <button type="submit" class="btn btn-success" name="buat_penagihan">
                                                Buat Penagihan (Invoice)
                                            </button>
                                        @endif
                                        @if ($data->status != 'Fully Invoiced' && $data->status != 'Cancelled' )
                                            <button type="submit" class="btn btn-danger" name="batalkan_sales_order">
                                                Batalkan Sales Order
                                            </button>
                                        @endif
                                        @if ($data->status == 'Fully Invoiced' && $data->pengiriman != 'Selesai')
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pengirimanModal">
                                                Buat Pengiriman
                                            </button>
                                        @endif
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

    <div class="modal" id="pengirimanModal" tabindex="-1" role="dialog" aria-labelledby="pengirimanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengirimanModalLabel">Form Pengiriman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/SalesOrder/update/{{ $data->id }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Pelanggan</label>
                                        <input readonly type="text" name="nama" class="form-control" id="nama" value="[{{ $data->customer->kategori }}] {{ $data->customer->nama }}">
                                    </div>                                                                                                                                            
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nomor Sales Order</label>
                                        <input readonly type="text" name="nomor_sales_order" class="form-control" id="nomor_sales_order" value="{{ $data->quotation->nomor_quotation }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Dibuat</label>
                                        <input readonly type="date" name="tanggal_quotation" class="form-control" id="tanggal_quotation" value="{{ $data->quotation->tanggal_quotation }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Metode Pembayaran</label>
                                        <input readonly type="text" name="pembayaran" class="form-control" id="pembayaran" value="{{ $data->pembayaran->jenis_pembayaran }}{{ $data->pembayaran->nomor_bayar ? ' [' . $data->pembayaran->nomor_bayar . ']' : '' }}">
                                    </div>                                                
                                </div>                                            
                            </div>
                            <br>
                            <h5>Pilih Produk Yang Akan Dibeli</h5>
                            <table class="table table-bordered" id="produkTabel">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Permintaan</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->quotation->produks as $row)
                                        <tr>
                                            <td><input type="text" class="form-control" name="produk_id[]" readonly value="{{ $row->nama_produk }}"></td>
                                            <td><input type="number" class="form-control" name="kuantitas[]" readonly value="{{ $row->pivot->kuantitas }}" min="0"></td>
                                            <td class="badge 
                                                @if ($data->pengiriman == 'Belum')
                                                    bg-secondary
                                                @elseif ($data->pengiriman == 'Tervalidasi')
                                                    bg-info
                                                @elseif ($data->pengiriman == 'Tidak Memenuhi')
                                                    bg-danger
                                                @elseif ($data->pengiriman == 'Selesai')
                                                    bg-success
                                                @endif
                                                d-flex justify-content-center align-items-center p-2 m-3">
                                                {{ $data->pengiriman }} 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            @if (in_array($data->pengiriman, ['Belum', 'Tidak Memenuhi']))
                                <button type="submit" class="btn btn-info" name="validate_pengiriman">Validate</button>
                            @endif
                            @if ($data->pengiriman == 'Tervalidasi')
                                <button type="submit" class="btn btn-primary" name="kirim_pengiriman">Kirim</button>
                            @endif
                            @if ($data->pengiriman == 'Selesai')
                                <button type="submit" class="btn btn-primary" name="pengembalian_produk">Pengembalian Produk</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    {{-- mengisi email subject otomatis --}}
    <script>
        $(document).ready(function() {
            function updateEmailSubject() {
                var nomorQuotation = $('#nomor_quotation').val(); 
                var subject = 'Pemesanan Dengan Nomor Ref ' + nomorQuotation;
                $('#emailSubject').val(subject); 
            }
            $('#nomor_quotation').on('input', function() {
                updateEmailSubject(); 
            });
    
            updateEmailSubject();
        });
    </script>
     
    {{-- mengisi deskripsi email otomatis --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengupdate email body dengan data yang diinginkan
            function updateEmailBody() {
                // Ambil nama pelanggan dari opsi yang dipilih, lalu hapus spasi berlebih
                var customerName = $('#customer_id option:selected').text().split('] ')[1].trim(); // Ambil nama setelah kategori dan trim
                var nomorQuotation = $('#nomor_quotation').val().trim(); // Ambil nomor quotation dan trim
                var totalKeseluruhan = $('#totalKeseluruhan_inputdisplay').val().trim(); // Ambil total keseluruhan dan trim

                // Format text untuk email body
                var emailBody = "Halo " + customerName + ",\n" +
                    "Pesanan anda dengan nomor ref " + nomorQuotation +
                    " dengan total Rp" + totalKeseluruhan + " siap untuk ditinjau.\n\n" +
                    "Jangan ragu untuk menghubungi kami jika " + customerName +
                    " memiliki pertanyaan.\n\n" +
                    "--\nAdmin Frojen-Fuud";

                // Isi nilai ke dalam emailBody textarea
                $('#emailBody').val(emailBody);
            }

            // Jalankan update saat customer_id atau nomor_quotation atau totalKeseluruhan berubah
            $('#customer_id').on('change', function() {
                updateEmailBody(); // Panggil fungsi update email body
            });

            $('#nomor_quotation').on('input', function() {
                updateEmailBody(); // Panggil fungsi update email body
            });

            $('#totalKeseluruhan_inputdisplay').on('input', function() {
                updateEmailBody(); // Panggil fungsi update email body
            });

            // Jalankan fungsi update saat halaman pertama kali dimuat untuk inisialisasi
            updateEmailBody();
        });
    </script>

    {{-- mengisi email to atau penerima otomatis --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengupdate email to dan email body
            function updateEmailFields() {
                // Ambil email dari opsi yang dipilih
                var customerEmail = $('#customer_id option:selected').data('email');
                
                // Isi email pada input emailTo
                $('#emailTo').val(customerEmail);
            }
    
            // Jalankan update saat customer_id berubah
            $('#customer_id').on('change', function() {
                updateEmailFields(); // Panggil fungsi update email fields
            });
    
            // Jalankan fungsi update saat halaman pertama kali dimuat untuk inisialisasi
            updateEmailFields();
        });
    </script>

    {{-- pajak terisi otomatis --}}
   <script>
    $(document).ready(function () {
        $(".pajak-select").each(function () {
            const selectedValue = $(this).find("option:selected").val(); // Nilai pajak yang sudah tersimpan
            const $select = $(this);

            // Hapus opsi yang nilainya sama dengan selectedValue
            $select.find("option").each(function () {
                if ($(this).val() !== selectedValue && $(this).val() !== "") {
                    $(this).toggle($(this).val() !== selectedValue); // Tampilkan hanya opsi yang berbeda
                }
            });
        });

        // Event ketika dropdown berubah
        $(document).on("change", ".pajak-select", function () {
            const selectedValue = $(this).val();
            const $select = $(this);

            // Perbarui opsi dropdown berdasarkan nilai yang dipilih
            $select.find("option").each(function () {
                if ($(this).val() !== selectedValue && $(this).val() !== "") {
                    $(this).toggle($(this).val() !== selectedValue); // Tampilkan hanya opsi yang berbeda
                }
            });
        });
    });

   </script>

    {{-- untuk menampilkan otomatis total sebelum pajak, total pajak, dan total keseluruhan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk format angka ke Rupiah
        function formatToRupiah(number) {
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        // Fungsi untuk menghitung total
        function calculateTotals() {
            const kuantitasElements = document.querySelectorAll('input[name="kuantitas[]"]');
            const hargaElements = document.querySelectorAll('input[name="harga[]"]');
            const taxElements = document.querySelectorAll('input[name="tax[]"]');

            let totalSebelumPajak = 0;
            let totalPajak = 0;

            kuantitasElements.forEach((kuantitasElement, index) => {
                const kuantitas = parseFloat(kuantitasElement.value) || 0;
                const harga = parseFloat(hargaElements[index].value.replace(/[^0-9.-]+/g, '')) || 0;
                const tax = parseFloat(taxElements[index].value.replace(/[^0-9.-]+/g, '')) || 0;

                const subtotal = kuantitas * harga;
                totalSebelumPajak += subtotal;
                totalPajak += (subtotal * tax) / 100;
            });

            const totalKeseluruhan = totalSebelumPajak + totalPajak;

            // Update nilai ke tampilan
            document.getElementById('totalSebelumPajak').textContent = formatToRupiah(totalSebelumPajak);
            document.getElementById('totalPajak').textContent = formatToRupiah(totalPajak);
            document.getElementById('totalKeseluruhan').textContent = formatToRupiah(totalKeseluruhan);

            // Update nilai ke input tersembunyi
            document.getElementById('totalSebelumPajak_inputdisplay').value = totalSebelumPajak;
            document.getElementById('totalPajak_inputdisplay').value = totalPajak;
            document.getElementById('totalKeseluruhan_inputdisplay').value = totalKeseluruhan;
        }

        // Panggil perhitungan saat halaman dimuat
        calculateTotals();

        // Jika diperlukan, tambahkan event listener untuk dinamika perubahan
        const inputs = document.querySelectorAll('input[name="kuantitas[]"], input[name="harga[]"], input[name="tax[]"]');
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil elemen input
            const totalSebelumPajakInput = document.getElementById("totalSebelumPajak_inputdisplay");
            const totalPajakInput = document.getElementById("totalPajak_inputdisplay");
            const totalKeseluruhanInput = document.getElementById("totalKeseluruhan_inputdisplay");
    
            // Ambil elemen span
            const totalSebelumPajakSpan = document.getElementById("totalSebelumPajak");
            const totalPajakSpan = document.getElementById("totalPajak");
            const totalKeseluruhanSpan = document.getElementById("totalKeseluruhan");
    
            // Fungsi untuk memformat angka menjadi format rupiah
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
            }
    
            // Update nilai di span dengan nilai dari input (dengan format rupiah)
            totalSebelumPajakSpan.textContent = formatRupiah(totalSebelumPajakInput.value || 0);
            totalPajakSpan.textContent = formatRupiah(totalPajakInput.value || 0);
            totalKeseluruhanSpan.textContent = formatRupiah(totalKeseluruhanInput.value || 0);
        });
    </script>
    

</body>

</html>
