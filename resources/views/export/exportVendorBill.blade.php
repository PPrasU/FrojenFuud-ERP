<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Bills Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
            color: white;
        }
        .bg-secondary {
            background-color: #6c757d;
        }
        .bg-warning {
            background-color: #ffc107;
        }
        .bg-success {
            background-color: #28a745;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Vendor Bills Report</h1>
    <p>Date: {{ now()->format('d M Y') }}</p>
    @foreach ($data as $bill)
        <!-- Informasi di luar tabel -->
        <div class="mb-3">
            <p><strong>Reference:</strong> {{ $bill->reference }}</p>
            <p><strong>Vendor:</strong> {{ $bill->vendor->nama }}</p>
            <p><strong>Status Bill:</strong>
                <span class="badge 
                    @if ($bill->status_bill == 'Draft') bg-secondary 
                    @elseif ($bill->status_bill == 'Not Paid') bg-warning
                    @elseif ($bill->status_bill == 'Paid') bg-success
                    @endif">
                    {{ $bill->status_bill }}
                </span>
            </p>
            <br>
            <p><strong>Harga Total:</strong> Rp{{ number_format($bill->total, 0, ',', '.') }}</p>
        </div>

        <!-- Tabel untuk menampilkan bahan yang dibeli -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Yang Dibeli</th>
                    <th>Kuantitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bill->bahans as $item)
                    <tr>
                        <td>{{ $item->nama_bahan }}</td>
                        <td>{{ $item->pivot->kuantitas }}{{ $item->satuan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    
</body>
</html>
