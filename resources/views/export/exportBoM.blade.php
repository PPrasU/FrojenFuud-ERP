<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bill Of Material</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h3 {
            text-align: center;
        }

        .table-data {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            font-size: 10pt;
        }

        .table-data tr th,
        .table-data tr td {
            border: 1px solid black;
            padding: 8px;
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

        .footer {
            margin-top: 30px;
            font-size: 9pt;
            text-align: right;
        }

        .product-header {
            background-color: #eaeaea;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h3>BoM Overview</h3>

    @foreach ($data as $produk)
        <h4>[{{ $produk->reference }}] - Overview {{ $produk->nama_produk }}</h4>
        <table class="table-data">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Satuan</th>
                    <th>Lead Time</th>
                    <th>Route</th>
                    <th>BoM Cost</th>
                    <th>Product Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk->details as $detail)
                    <tr>
                        <td>{{ $detail->nama_bahan }}</td>
                        <td>{{ number_format($detail->kuantitas, 2) }}</td>
                        <td>{{ $detail->satuan }}</td>
                        <td>{{ $detail->lead_time ?? '-' }}</td>
                        <td>{{ $detail->route ?? '-' }}</td>
                        <td>Rp {{ number_format($detail->bom_cost, 2) }}</td> <!-- Ambil dari harga_satuan -->
                        <td>Rp {{ number_format($detail->product_cost, 2) }}</td> <!-- Sama dengan bom_cost -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Total BoM Cost: Rp {{ number_format($produk->total_bom_cost, 2) }}<br>
            Total Product Cost: Rp {{ number_format($produk->total_product_cost, 2) }}
        </div>
    @endforeach
</body>

</html>
