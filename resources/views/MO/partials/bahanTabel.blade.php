<h5>Komposisi Bahan Yang Digunakan Untuk Membuat Produk</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bahan</th>
            <th>Kuantitas</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bill_of_material_bahan as $bahan)
            <tr>
                <td>{{ $bahan['nama_bahan'] }}</td>
                <td>
                    {{ rtrim(rtrim(number_format($bahan['kuantitas'], 4, ',', ''), '0'), ',') }}
                </td>                
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">Tidak ada bahan terkait</td>
            </tr>
        @endforelse
    </tbody>
</table>
