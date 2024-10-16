<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
<<<<<<< HEAD

    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

=======
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
    <style>
        .table-data {
            border-collapse: collapse;
            width: 100%;
        }

        .table-data tr th,
        .table-data tr td {
            border: 1px solid black;
            font-size: 11pt;
            padding: 10px 20px;
            text-align: center;
        }

        .table-data tr th {
            background-color: #2c3e50;
            color: white;
        }

        .table-data tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-data tr:hover {
            background-color: #f5f5f5;
        }
<<<<<<< HEAD

        /* Set ukuran barcode */
        svg {
            width: 150px;
            height: 50px;
        }
=======
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
    </style>
</head>

<body>
    <h3>Data Produk yang Dipilih</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
<<<<<<< HEAD
                <th>Kode Produk (Barcode)</th>
=======
                <th>Kode Produk</th>
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
<<<<<<< HEAD
            @foreach ($data as $produk)
=======
            @forelse ($data as $produk)
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kode_produk }}</td>
<<<<<<< HEAD
                    <td>
                        <svg id="barcode-{{ $produk->id }}"></svg>
                        <script>
                            JsBarcode("#barcode-{{ $produk->id }}", "{{ $produk->kode_produk }}", {
                                format: "CODE128",
                                displayValue: true,
                                fontSize: 16
                            });
                        </script>
                    </td>
                    <td>Rp. {{ number_format($produk->harga_produk) }}</td>
                </tr>
            @endforeach
=======
                    <td>Rp. {{ number_format($produk->harga_produk) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Tidak ada data</td>
                </tr>
            @endforelse
>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
        </tbody>
    </table>
</body>

</html>
