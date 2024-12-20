<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'bill_of_materials';
    
    //ini untuk mengambil data dari tabel produks pada model Produk
    public function produk(){
        return $this->BelongsTo('App\Models\Produk');
    }
    //ini untuk menambahkan data bahan dari bill of material ke tabel bill_of_material_bahan
    public function bahans() {
        return $this->belongsToMany(Bahan::class, 'bill_of_material_bahan')
                    ->withPivot('kuantitas', 'satuan')
                    ->withTimestamps();
    }
    // public function bahan() {
    //     return $this->belongsToMany(Bahan::class, 'bill_of_material_id', 'id')
    //                 ->withPivot('kuantitas', 'satuan')
    //                 ->withTimestamps();
    // }

    public function bahan()
    {
        return $this->belongsToMany(
            Bahan::class,               // Model bahan
            'bill_of_material_bahans',  // Nama tabel pivot
            'bill_of_material_id',      // Foreign key di tabel pivot yang menghubungkan ke Bill of Material
            'bahan_id'                  // Foreign key di tabel pivot yang menghubungkan ke tabel bahan
        )->withPivot('kuantitas', 'satuan') // Ambil kolom tambahan dari tabel pivot
          ->withTimestamps();              // Ambil informasi timestamps dari tabel pivot (jika ada)
    }

    public function details()
    {
        return $this->hasMany(BillOfMaterialBahan::class, 'bill_of_material_id'); // Sesuaikan nama model dan foreign key
    }
    
}
