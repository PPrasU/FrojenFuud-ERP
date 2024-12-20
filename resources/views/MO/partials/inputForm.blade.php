<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Nama Produk</label>
            <select name="nama_produk" id="nama_produk" class="form-control">
                <option selected disabled>-- Pilih --</option>
                @foreach ($produks as $row)
                <option value="{{ $row->id }}">{{$row->nama_produk}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Bill Of Material</label>
            <select class="form-control" name="produkSelect" id="produkSelect">
                <option selected disabled>-- Pilih --</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Reference</label>
            <input type="text" name="reference" id="reference" class="form-control" readonly>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Schedule Date</label>
            <input type="date" name="jadwal" class="form-control" id="jadwal" required>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" id="quantity" required>
        </div>
    </div>
</div>