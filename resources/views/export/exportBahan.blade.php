<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bahan</title>
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
    </style>
</head>

<body>
    <h3>Data Bahan yang Dipilih</h3>
    <table class="table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Kode Bahan </th>
                <th>Barcode</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $bahan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bahan->nama_bahan }}</td>
                    <td>{{ $bahan->kode_bahan }}</td>
                    <td>
                        <svg id="barcode-{{ $bahan->id }}" style="width: 200px; height: 100px;"></svg>
                        <!-- Atur ukuran SVG -->
                        <script>
                            JsBarcode("#barcode-{{ $bahan->id }}", "{{ $bahan->kode_bahan }}", {
                                format: "CODE128",
                                displayValue: true,
                                fontSize: 16, // Font lebih besar untuk teks barcode
                                width: 3, // Lebar garis barcode lebih besar
                                height: 75 // Tinggi barcode lebih besar
                            });
                        </script>
                    </td>
                    <td>Rp. {{ number_format($bahan->harga_bahan) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
