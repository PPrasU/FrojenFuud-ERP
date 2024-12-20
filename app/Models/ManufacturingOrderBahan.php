<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingOrderBahan extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi ke model BillOfMaterial jika diperlukan
    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bom_id');
    }

    public function billOfMaterialBahan()
    {
        return $this->belongsTo(BillOfMaterialBahan::class, 'bom');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product');
    }

    // Relasi ke Bahan (melalui Bill of Material)
    public function bahans()
    {
        return $this->hasManyThrough(Bahan::class, BillOfMaterial::class, 'id', 'id', 'bom', 'id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id', 'nama_bahan', 'nama_bahan');
    }
}
