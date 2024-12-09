<!DOCTYPE html>
<html lang="en">

<head>
    <title>FrojenFuud | Edit Quotation</title>
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
                            <h5 class="m-0">Edit Quotation</h5>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Sales</li>
                                <li class="breadcrumb-item"><a href="/Quotation">Quotation</a>
                                <li class="breadcrumb-item"><a href="/Quotation/edit">Edit Quotation</a>
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
                                <form action="/Quotation/update/{{ $data->id }}" method="POST" enctype="multipart/form-data"
                                    id="editQuotation">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Pelanggan</label>
                                                    <select class="form-control select2" name="customer_id" id="customer_id" style="width: 100%;">
                                                        <option value="{{ $data->customer->id }}" selected data-email="{{ $data->customer->email }}">
                                                            [{{ $data->customer->kategori }}] {{ $data->customer->nama }}
                                                        </option>
                                                        <option disabled>--Pilih Pelanggan--</option>
                                                        @foreach ($customer as $row)
                                                            <option value="{{ $row->id }}" data-email="{{ $row->email }}" data-pelanggan="{{ $row->nama }}">
                                                                [{{ $row->kategori }}] {{ $row->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>                                                                                                                                           
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nomor Quotation</label>
                                                    <input type="text" name="nomor_quotation" class="form-control" id="nomor_quotation" value="{{ $data->nomor_quotation }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Tanggal Dibuat</label>
                                                    <input type="date" name="tanggal_quotation" class="form-control"
                                                        id="tanggal_quotation" value="{{ $data->tanggal_quotation }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Berlaku Hingga</label>
                                                    <input type="date" name="berlaku_hingga" class="form-control"
                                                        id="berlaku_hingga" value="{{ $data->berlaku_hingga }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Metode Pembayaran</label>
                                                    <select class="form-control select2" name="pembayaran_id" id="pembayaran_id" style="width: 100%;">
                                                        <option value="{{ $data->pembayaran->id }}" selected>
                                                            {{ $data->pembayaran->jenis_pembayaran }}{{ $data->pembayaran->nomor_bayar ? ' [' . $data->pembayaran->nomor_bayar . ']' : '' }}
                                                        </option>
                                                        <option disabled>--Pilih Metode Pembayaran--</option>
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
                                                    <th>Pajak (%)</th>
                                                    <th>subtotal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item->produks as $produk)
                                                    <tr>
                                                        <td>
                                                            <select class="form-control pridk-select" name="produk_id[]">
                                                                <option selected value="{{ $produk->id }}" data-harga="{{ $produk->harga_produk }}">
                                                                    {{ $produk->nama_produk }}
                                                                </option>
                                                                @foreach ($produk_p as $row)
                                                                    @if ($row->id != $produk->id)
                                                                        <option value="{{ $row->id }}" data-harga="{{ $row->harga_produk }}">
                                                                            {{ $row->nama_produk }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>                                                            
                                                        </td>
                                                        <td><input type="number" class="form-control" name="kuantitas[]" value="{{ $produk->pivot->kuantitas }}"></td>
                                                        <td><input type="text" class="form-control" name="harga[]" readonly value="{{ number_format($produk->pivot->harga, 0, ',', '') }}"></td>
                                                        <td>
                                                            <select class="form-control pajak-select" name="tax[]">
                                                                <option disabled>-- Pilih Pajak --</option>
                                                                <option value="0" {{ $produk->pivot->tax == 0 ? 'selected' : '' }}>0%</option>
                                                                <option value="10" {{ $produk->pivot->tax == 10 ? 'selected' : '' }}>10%</option>
                                                                <option value="11" {{ $produk->pivot->tax == 11 ? 'selected' : '' }}>11%</option>
                                                                <option value="12" {{ $produk->pivot->tax == 12 ? 'selected' : '' }}>12%</option>
                                                                <option value="20" {{ $produk->pivot->tax == 20 ? 'selected' : '' }}>20%</option>
                                                            </select>
                                                            <input type="hidden" class="form-control" name="tax_hidden[]" value="{{ $produk->pivot->tax }}">
                                                        </td>                                                                                                                                                                     
                                                        <td><input type="text" class="form-control" name="subtotal[]" readonly value="{{ number_format($produk->pivot->subtotal, 0, ',', '') }}"></td>
                                                        <td><a class="btn btn-danger delete" style="cursor:pointer;"><i class="fas fa-trash" style="color: white"></i></a></td>
                                                    </tr>
                                                @endforeach
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

                                        <input type="number" id="totalSebelumPajak_inputdisplay" name="total_sebelum_pajak" readonly hidden>
                                        <input type="number" id="totalPajak_inputdisplay" name="total_pajak" readonly hidden>
                                        <input type="number" id="totalKeseluruhan_inputdisplay" name="total_keseluruhan" readonly hidden>
                                        


                                    </div>
                                    <div class="card-footer">
                                        <a href="/Quotation" class="btn btn-secondary">Kembali</a>
                                        <!-- Tombol Konfirmasi Perubahan hanya tampil jika status bukan 'Sent' -->
                                        @if ($data->status != 'Sent' && $data->status != 'Cancelled')
                                            <button type="submit" class="btn btn-default">Konfirmasi Perubahan</button>
                                        @endif

                                        <!-- Tombol Send By Email hanya tampil jika status bukan 'Sent' -->
                                        @if ($data->status != 'Sent' && $data->status != 'Cancelled')
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#emailModal">
                                                Send By Email
                                            </button>
                                        @endif
                                        @if ($data->status != 'Confirmed to Sales Order' && $data->status != 'Cancelled')
                                            <button type="submit" class="btn btn-success" name="confirm_quotation">
                                                Konfirmasi Quotation
                                            </button>
                                        @endif
                                        @if ($data->status != 'Cancelled')
                                            <button type="submit" class="btn btn-danger" name="batalkan_quotation">
                                                Batalkan Quotation
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

    <div id="emailModal" class="modal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="emailModalLabel">Compose New Message</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('Quotation.sendEmail', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="emailTo">To:</label>
                            <input type="email" id="emailTo" name="emailTo" class="form-control" placeholder="Recipient Email" readonly>
                        </div>
                        <div class="form-group">
                            <label for="emailSubject">Subject:</label>
                            <input type="text" id="emailSubject" name="emailSubject" class="form-control" placeholder="Email Subject">
                        </div>
                        <div class="form-group">
                            <label for="emailBody">Message:</label>
                            <textarea id="emailBody" name="emailBody" class="form-control" style="height: 200px;" placeholder="Type your message here..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="far fa-envelope"></i> Kirim
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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

   {{-- menghitung subtotal, pajak, total tanpa pajak, dan total keseluruhan --}}
   {{-- <script>
    $(document).ready(function () {
        // Fungsi untuk menghitung subtotal, total sebelum pajak, total pajak, dan total keseluruhan
        function calculateTotals() {
            let totalSebelumPajak = 0;
            let totalPajak = 0;

            console.log("=== Menghitung Total ===");
            $("#produkTabel tbody tr").each(function () {
                const kuantitas = parseFloat($(this).find("input[name='kuantitas[]']").val()) || 0;
                const harga = parseFloat($(this).find("input[name='harga[]']").val().replace(/,/g, '')) || 0;
                const tax = parseFloat($(this).find("select[name='tax[]']").val()) || 0;

                console.log(`Kuantitas: ${kuantitas}, Harga: ${harga}, Pajak: ${tax}`);

                const subtotal = kuantitas * harga;
                const pajakSubtotal = subtotal * (tax / 100);

                console.log(`Subtotal: ${subtotal}, Pajak Subtotal: ${pajakSubtotal}`);

                // Perbarui kolom subtotal
                $(this).find("input[name='subtotal[]']").val((subtotal + pajakSubtotal).toFixed(2));

                totalSebelumPajak += subtotal;
                totalPajak += pajakSubtotal;
            });

            const totalKeseluruhan = totalSebelumPajak + totalPajak;

            console.log(`Total Sebelum Pajak: ${totalSebelumPajak}, Total Pajak: ${totalPajak}, Total Keseluruhan: ${totalKeseluruhan}`);

            // Perbarui elemen HTML
            $("#totalSebelumPajak").text(`Rp. ${totalSebelumPajak.toLocaleString()}`);
            $("#totalPajak").text(`Rp. ${totalPajak.toLocaleString()}`);
            $("#totalKeseluruhan").text(`Rp. ${totalKeseluruhan.toLocaleString()}`);

            // Perbarui input tersembunyi
            $("#totalSebelumPajak_inputdisplay").val(totalSebelumPajak.toFixed(2));
            $("#totalPajak_inputdisplay").val(totalPajak.toFixed(2));
            $("#totalKeseluruhan_inputdisplay").val(totalKeseluruhan.toFixed(2));
        }
        // Event ketika kuantitas, harga, atau pajak berubah
        $(document).on("input change", "input[name='kuantitas[]'], input[name='harga[]'], select[name='tax[]']", function () {
            calculateTotals();
        });

        // Event tombol delete
        $(document).on("click", ".delete", function () {
            $(this).closest("tr").remove(); // Hapus baris tabel
            calculateTotals(); // Hitung ulang total setelah baris dihapus
        });

        // Hitung ulang total ketika halaman selesai dimuat
        $(document).ready(function () {
            calculateTotals();
        });

        calculateTotals();
        console.log("Script berhasil dimuat");
    });
   </script> --}}

   {{-- script menghitung subtotal, total tanpa pajak, total pajak, dan total keseluruhan --}}
   <script>
        document.addEventListener('DOMContentLoaded', function () {
            function calculateTotals() {
                let totalSebelumPajak = 0;
                let totalPajak = 0;
                let totalKeseluruhan = 0;

                document.querySelectorAll('#produkTabel tbody tr:not(#addProdukRow)').forEach(function (row) {
                    const kuantitas = parseFloat(row.querySelector('input[name="kuantitas[]"]').value) || 0;
                    const harga = parseFloat(row.querySelector('input[name="harga[]"]').value.replace(/,/g, '')) || 0;
                    const tax = parseFloat(row.querySelector('select[name="tax[]"]').value) || 0;
                    const subtotalInput = row.querySelector('input[name="subtotal[]"]');

                    const subtotal = kuantitas * harga;
                    subtotalInput.value = subtotal.toLocaleString('id-ID');

                    const pajak = (subtotal * tax) / 100;
                    totalSebelumPajak += subtotal;
                    totalPajak += pajak;
                    totalKeseluruhan += subtotal + pajak;

                    console.log(`Row subtotal: ${subtotal}, Tax: ${pajak}`);
                });

                document.getElementById('totalSebelumPajak').textContent = `Rp. ${totalSebelumPajak.toLocaleString('id-ID')}`;
                document.getElementById('totalPajak').textContent = `Rp. ${totalPajak.toLocaleString('id-ID')}`;
                document.getElementById('totalKeseluruhan').textContent = `Rp. ${totalKeseluruhan.toLocaleString('id-ID')}`;

                document.getElementById('totalSebelumPajak_inputdisplay').value = totalSebelumPajak;
                document.getElementById('totalPajak_inputdisplay').value = totalPajak;
                document.getElementById('totalKeseluruhan_inputdisplay').value = totalKeseluruhan;

                console.log(`Total Sebelum Pajak: ${totalSebelumPajak}, Total Pajak: ${totalPajak}, Total Keseluruhan: ${totalKeseluruhan}`);
            }

            document.querySelector('#produkTabel').addEventListener('input', function (event) {
                if (
                    event.target.matches('input[name="kuantitas[]"]') ||
                    event.target.matches('select[name="tax[]"]')
                ) {
                    console.log('Input changed, recalculating totals...');
                    calculateTotals();
                }
            });

            document.querySelector('#produkTabel').addEventListener('change', function (event) {
                if (event.target.matches('select[name="produk_id[]"]')) {
                    const selectedOption = event.target.selectedOptions[0];
                    const harga = selectedOption.getAttribute('data-harga') || 0;
                    const row = event.target.closest('tr');
                    row.querySelector('input[name="harga[]"]').value = parseFloat(harga).toLocaleString('id-ID');
                    console.log(`Harga produk diperbarui: ${harga}`);
                    calculateTotals();
                }
            });

            calculateTotals();
        });
   </script>
</body>

</html>
