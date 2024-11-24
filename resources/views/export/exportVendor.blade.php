<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Dua kolom */
            gap: 20px;
            /* Jarak antar kolom dan baris */
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-sizing: border-box;
            /* Pastikan padding termasuk dalam ukuran elemen */
        }

        .card h5 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .card h6 {
            margin: 5px 0 15px;
            font-size: 16px;
            font-style: italic;
            color: #555;
        }

        .card p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach ($data as $row)
            <div class="card">
                <h5>{{ $row->nama }}</h5>
                <h6>{{ $row->kategori }}</h6>
                <p><strong>Alamat:</strong> {{ $row->alamat_1 }}, {{ $row->alamat_2 }}</p>
                <p><strong>No. HP:</strong> {{ $row->no_hp }}</p>
                <p><strong>Email:</strong> {{ $row->email }}</p>
                <p><strong>NPWP:</strong> {{ $row->npwp }}</p>
            </div>
        @endforeach
    </div>
</body>

</html>
