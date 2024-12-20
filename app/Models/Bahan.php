<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function billOfMaterials() {
        return $this->belongsToMany(BillOfMaterial::class, 'bill_of_material_bahan')
                    ->withPivot('kuantitas', 'satuan')
                    ->withTimestamps();
    }
    public function manufacturingOrderBahans()
    {
        return $this->hasMany(ManufacturingOrderBahan::class, 'bahan_id');
    }

    public function quotation_bahans()
    {
        return $this->hasMany(RequestForQuotationBahan::class, 'bahan_id');
    }
}
