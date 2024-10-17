<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
    <!-- JsBarcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
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

        /* Set ukuran barcode */
        svg {
            width: 150px;
            height: 50px;
        }
    </style>
</head>

<body>
    <h3>Data Produk yang Dipilih</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kode Produk (Barcode)</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kode_produk }}</td>
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
        </tbody>
    </table>
</body>

</html>
