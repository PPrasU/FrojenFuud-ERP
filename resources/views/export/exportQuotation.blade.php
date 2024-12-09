<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <h1>Quotation</h1>
    @forelse ($data as $row)
        <p>Nomor: {{ $row->nomor_quotation }}</p>
        <p>Tanggal: {{ $row->tanggal_quotation }}</p>
        <p>Berlaku Hingga: {{ $row->berlaku_hingga }}</p>
        <p>Customer: {{ $row->customer->nama }}</p>
        <p>Pembayaran: {{ $row->pembayaran->jenis_pembayaran }}</p>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Tax</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($row->produks as $produk)
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->pivot->kuantitas }}</td>
                        <td>Rp{{ number_format($produk->pivot->harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($produk->pivot->tax, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($produk->pivot->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Total Sebelum Pajak: {{ number_format($row->total_sebelum_pajak, 0, ',', '.') }}</p>
        <p>Total Pajak: {{ number_format($row->total_pajak, 0, ',', '.') }}</p>
        <p>Total Keseluruhan: {{ number_format($row->total_keseluruhan, 0, ',', '.') }}</p>
        
    @endforeach
    
    <p><a id="downloadLink" href="#" target="_blank">Download PDF</a></p>
</body>
</html>