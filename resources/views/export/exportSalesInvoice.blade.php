<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Quotation PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .total-section h5 {
            margin: 5px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @foreach ($data as $row)
        <div class="header">
            <h1>Quotation</h1>
            <p>Nomor Invoice: {{ $row->nomor_invoice }}</p>
            <p>Tanggal: {{ $row->quotation->tanggal_quotation }}</p>
        </div>

        <div class="content">
            <h3>Detail Pelanggan</h3>
            <table>
                <tr>
                    <td><strong>Pelanggan:</strong></td>
                    <td>[{{ $row->customer->kategori }}] {{ $row->customer->nama }}</td>
                </tr>
                <tr>
                    <td><strong>Metode Pembayaran:</strong></td>
                    <td>{{ $row->pembayaran->jenis_pembayaran }}{{ $row->pembayaran->nomor_bayar ? ' [' . $row->pembayaran->nomor_bayar . ']' : '' }}</td>
                </tr>
                @if (in_array($row->status, ['Not Paid', 'Paid']))
                    <tr>
                        <td><strong>Tanggal Pembayaran:</strong></td>
                        <td>{{ $row->tanggal_pembayaran_invoice ?? 'Belum Tersedia' }}</td>
                    </tr>
                @endif
            </table>

            <h3>Produk yang Dibayar</h3>
            <table class="table">
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
                    @foreach ($row->quotation->produks as $produk)
                        <tr>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->pivot->kuantitas }}</td>
                            <td>Rp. {{ number_format($produk->pivot->harga, 0, '.', ',') }}</td>
                            <td>{{ $produk->pivot->tax }}%</td>
                            <td>Rp. {{ number_format($produk->pivot->subtotal, 0, '.', ',') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <h5>Total Sebelum Pajak: Rp. {{ number_format($row->quotation->total_sebelum_pajak, 0, '.', ',') }}</h5>
                <h5>Total Pajak: Rp. {{ number_format($row->quotation->total_pajak, 0, '.', ',') }}</h5>
                <h5>Total Keseluruhan: Rp. {{ number_format($row->quotation->total_keseluruhan, 0, '.', ',') }}</h5>
            </div>
        </div>

        <div class="footer">
            <p>Generated on {{ date('d-m-Y') }}</p>
        </div>
    @endforeach

</body>
</html>
