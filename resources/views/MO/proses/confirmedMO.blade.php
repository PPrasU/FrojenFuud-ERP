<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS dan jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<head>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>FrojenFuud | Input Manufacturing Order akjsdhah</title>
    @include('layouts/header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts/preloader')
        @include('layouts/navbar')
        @include('layouts/sidebar')
        <div class="wrapper">
            <!-- Main Content Wrapper-->
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h5 class="m-0">Input Manufacturing Order | Confirmed</h5>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">Manufacturing</li>
                                    <li class="breadcrumb-item"><a href="/ManufacturingOrder">Manufacturing Order</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/ManufacturingOrder/input">Input Data</a></li>
                                </ol>
                            </div>
                        </div>

                        <!-- Arrow Progress Bar -->
                        <div class="wrapper-arrow">
                            <div class="arrow-steps clearfix">
                                <div class="step @if($state == 0) current @elseif($state > 0) done @endif">Draft</div>
                                <div class="step @if($state == 1) current @elseif($state > 1) done @endif">Confirmed
                                </div>
                                <div class="step @if($state == 2) current @elseif($state > 2) done @endif">Check
                                    Availability</div>
                                <div class="step @if($state == 3) current @elseif($state > 3) done @endif">In Progress
                                </div>
                                <div class="step @if($state == 4) current @elseif($state > 4) done @endif">Done</div>
                            </div>
                        </div>

                        <!-- End Arrow Progress Bar -->
                    </div>
                </div>
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header" style="height: 1px;"></div>
                                    <form action="{{ route('postConfirmedForm', ['id' => $order->id]) }}" method="POST"
                                        enctype="multipart/form-data" id="inputManufacturingOrder">
                                        @csrf
                                        <div class="card-body">
                                            <input type="hidden" name="confirmed" value="1">
                                            <!-- resources/views/manufacturing/partials/inputForm.blade.php -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Nama Produk</label>
                                                        <select name="nama_produk" id="nama_produk" class="form-control"
                                                            readonly disabled>
                                                            @foreach ($produks as $row)
                                                            <option value="{{ $row->id }}" {{ $order->produk_id == $row->id ? 'selected' : '' }}>
                                                                {{ $row->nama_produk }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Reference -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Reference</label>
                                                        <input type="text" name="produkSelect" id="produkSelect"
                                                            class="form-control" value="{{ $order->reference }}"
                                                            readonly>                                                     
                                                    </div>
                                                </div>

                                                <!-- Quantity Produk -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Quantity Produk</label>
                                                        <input type="number" name="quantity" id="quantity"
                                                        class="form-control" value="{{ $order->quantity }}" required
                                                        readonly>
                                                    </div>
                                                </div>
                                                
                                                <!-- Schedule Date -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Schedule Date</label>
                                                        <input type="date" name="jadwal" id="jadwal"
                                                            class="form-control" value="{{ $order->deadline }}" required
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <!-- resources/views/manufacturing/partials/bahanTabel.blade.php -->
                                            <h5>Komposisi Bahan Yang Digunakan Untuk Membuat Produk</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Bahan</th>
                                                        <th>To Consume</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bahanOrder as $bahan)
                                                    <tr>
                                                        <td>{{ $bahan->nama_bahan }}</td>
                                                        <td>{{ $bahan->to_consume}}</td>
                                                        {{-- <td>
                                                            <input type="number" name="quantity_bahan[]"
                                                                class="form-control"
                                                                value="{{ $bahan->to_consume * $order->quantity }}"
                                                                readonly>
                                                        </td> --}}
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                            <a href="/ManufacturingOrder" class="btn btn-default">Batal</a>
                                            <button type="submit" class="btn btn-primary">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        @include('layouts/footer')
    </div>
    @include('layouts/script')
    <!-- jQuery Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Link ke file JavaScript -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#nama_produk').change(function() {
                let produkId = $(this).val();
                $.ajax({
                    url: '/getBahanByProduk/' + produkId,
                    method: 'GET',
                    success: function(response) {
                        let bahanTable = $('tbody');
                        bahanTable.empty();
                        response.forEach(function(bahan) {
                            bahanTable.append(`
                                <tr>
                                    <td>${bahan.nama_bahan}</td>
                                    <td>${bahan.to_consume}</td>
                                    <td>
                                        <input type="number" name="quantity_bahan[]" class="form-control" value="${bahan.to_consume * response.quantity}" readonly>
                                    </td>
                                </tr>
                            `);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('#nama_produk').change(function () {
            var produkId = $(this).val(); // Ambil ID produk yang dipilih

            if (produkId) {
                // Kirim request ke server untuk mengambil Bill Of Material
                $.ajax({
                    url: '/get-bill-of-materials/' + produkId,
                    type: 'GET',
                    success: function (data) {
                        // Kosongkan dulu pilihan Bill Of Material
                        $('#produkSelect').empty();

                        // Tambahkan option default
                        $('#produkSelect').append('<option selected disabled>-- Pilih --</option>');

                        // Looping data dari server
                        $.each(data, function (index, bom) {
                            $('#produkSelect').append(
                                `<option value="${bom.id}" data-reference="${bom.reference}">
                                    ${bom.reference} - ${bom.nama_bom}
                                </option>`
                            );
                        });
                    },
                    error: function () {
                        alert('Gagal mengambil data Bill Of Material!');
                    }
                });
            }
        });

    </script>
</body>

</html>