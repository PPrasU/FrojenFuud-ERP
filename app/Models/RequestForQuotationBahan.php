<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForQuotationBahan extends Model
{
    use HasFactory;
    // Tentukan nama tabel (opsional, jika nama model berbeda dengan nama tabel)
    protected $table = 'request_for_quotation_bahans';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'request_for_quotation_id', 'bahan_id', 'nama_bahan', 'kuantitas', 'satuan',
    ];

    // Definisikan relasi ke tabel RequestForQuotation
    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'request_for_quotation_id', 'id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id', 'id');
    }

}
