<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Manufacturing Order</title>
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
            font-size: 10pt;
            text-align: right;
        }

        .product-header {
            font-weight: bold;
            margin-top: 20px;
            font-size: 12pt;
        }
    </style>
</head>

<body>
    <h3>Laporan Manufacturing Order</h3>

    @foreach ($data as $produk)
        <div class="product-header">
            WH/MO/{{ $produk->reference }} - Overview {{ $produk->nama_produk }}
        </div>
        <div>
            <h5>Total Jumlah Produk : {{ $produk->quantity }}</h5>
        </div>
        <table class="table-data">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>MO Cost</th>
                    <th>Real Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk->details as $detail)
                    @php
                        $mo_cost = $detail->harga_bahan * $detail->to_consume;
                        $real_cost = $mo_cost;
                    @endphp
                    <tr>
                        <td>{{ $detail->nama_bahan }}</td>
                        <td>{{ number_format($detail->to_consume, 2) }}</td>
                        <td>Rp {{ number_format($detail->harga_bahan, 2) }}</td>
                        <td>Rp {{ number_format($mo_cost, 2) }}</td>
                        <td>Rp {{ number_format($real_cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Unit Cost: Rp {{ number_format($produk->harga_produk, 2) }}<br>
            Total Cost of Components: Rp {{ number_format($produk->harga_produk * $produk->quantity , 2) }}
        </div>
    @endforeach

</body>

</html>
