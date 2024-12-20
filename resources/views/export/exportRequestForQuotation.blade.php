<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request for Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px 40px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .company-info {
            text-align: right;
        }

        .company-info h1 {
            margin: 0;
            font-size: 16px;
        }

        .company-info p {
            margin: 0;
            font-size: 12px;
        }

        .shipping-info {
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
            /* Membuat kolom kiri dan kanan terpisah */
            padding: 0;
            gap: 80px;
            /* Memberikan jarak antar kolom */
        }

        .left,
        .right {
            width: 48%;
            /* Lebar kolom kiri dan kanan */
            float: left;
            /* Membuat kedua kolom berada di sisi kiri */
            margin-right: 4%;
            /* Menambahkan margin untuk memberi jarak antar kolom */
            justify-content: flex-end;
        }

        .right {
            margin-right: 0;
            /* Menghilangkan margin pada kolom kanan */
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        table th {
            background-color: #2c3e50;
            color: white;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

        .page-number {
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach ($data as $quotation)
            <!-- Menambahkan page-break sebelum setiap RFQ -->
            <div style="page-break-before: always;">
                <!-- Menampilkan header hanya pada halaman pertama -->
                @if ($loop->first)
                <header>
                    <div class="company-info">
                        <h1>Frojen-Fuud</h1>
                        <p>Indonesia</p>
                    </div>
                </header>
                @endif

                <div class="shipping-info">
                    <div class="left">
                        <div class="section-title">Shipping address:</div>
                        <p>Frojen Fuud</p>
                        <p>Indonesia</p>
                        <p>08893011459</p>
                    </div>
                    <div class="right" style="text-align: right;">
                        <div class="section-title">
                            {{ $quotation->vendor ? $quotation->vendor->nama : 'Vendor not found' }}
                        </div>
                        <p>
                            {{ $quotation->vendor && $quotation->vendor->alamat_1 ? $quotation->vendor->alamat_1 : 'Address not found' }}
                        </p>
                        <p>
                            {{ $quotation->vendor && $quotation->vendor->alamat_2 ? $quotation->vendor->alamat_2 : 'Address not found' }}
                        </p>
                        <p>
                            {{ $quotation->vendor && $quotation->vendor->email ? $quotation->vendor->email : 'Email not found' }}
                        </p>
                    </div>            
                </div>

                <h2>Request for Quotation RFQ{{ str_pad($quotation->id, 4, '0', STR_PAD_LEFT) }}</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Expected Date</th>
                            <th>QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotation->quotation_bahans as $bahan)
                        <tr>
                            <td>{{ $bahan->bahan ? $bahan->bahan->nama_bahan : 'No Name' }}</td>
                            <td>{{ $quotation->tanggal }}</td>
                            <td>{{ $bahan->kuantitas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        <div class="footer">
            <p>08893011459 | putrapras008@gmail.com</p>
            <p>Mudah dan Cepat</p>
        </div>
        <div class="page-number">
            Page 1/1
        </div>
    </div>
</body>


</html>