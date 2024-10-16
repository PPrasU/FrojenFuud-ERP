<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Bahan</title>
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
        <th>Kode Bahan</th>
        <th>Harga</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $bahan)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bahan->nama_bahan }}</td>
        <td>{{ $bahan->kode_bahan }}</td>
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
=======

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bahan</title>
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
                <th>Kode Bahan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $bahan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bahan->nama_bahan }}</td>
                    <td>{{ $bahan->kode_bahan }}</td>
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

>>>>>>> 42218dea6205a6be5b3e0f2997f9177f2ed9c486
</html>
