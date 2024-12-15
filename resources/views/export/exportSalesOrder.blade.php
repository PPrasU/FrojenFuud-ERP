<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Sales Order</h2>
    </div>

    @foreach ($data as $order)
        <h4>Nomor Sales Order: {{ $order->nomor_sales_order }}</h4>
        <p>Pelanggan: [{{ $order->customer->kategori }}] {{ $order->customer->nama }}</p>
        <p>Tanggal Dibuat: {{ $order->tanggal_sales_order }}</p>
        <p>Metode Pembayaran: {{ $order->pembayaran->jenis_pembayaran }}{{ $order->pembayaran->nomor_bayar ? ' [' . $order->pembayaran->nomor_bayar . ']' : '' }}</p>
        <br>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga Satuan</th>
                    <th>Pajak (%)</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->quotation->produks as $produk)
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->pivot->kuantitas }}</td>
                        <td>{{ number_format($produk->pivot->harga, 0, '.', '') }}</td>
                        <td>{{ number_format($produk->pivot->tax, 0, '.', '') }}</td>
                        <td>{{ number_format($produk->pivot->subtotal, 0, '.', '') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total Sebelum Pajak: Rp {{ number_format($order->total_sebelum_pajak, 0, '.', '') }}</p>
        <p class="total">Total Pajak: Rp {{ number_format($order->total_pajak, 0, '.', '') }}</p>
        <p class="total">Total Keseluruhan: Rp {{ number_format($order->total_keseluruhan, 0, '.', '') }}</p>
        <hr>
    @endforeach
</body>
</html>
