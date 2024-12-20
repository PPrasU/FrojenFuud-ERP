<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterialBahan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'bill_of_material_bahan';

    public function bahans()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bill_of_material_id', 'id');
    }
    public function billofmaterialbahan()
    {
        return $this->belongsTo(BillOfMaterialBahan::class, 'bahan_id', 'id');
    }
}
