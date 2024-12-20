<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Tambahkan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'rfq_id',
        'payment_method',
        'amount',
        'payment_date',
    ];

    // Relasi ke RequestForQuotation (jika diperlukan)
    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'rfq_id');
    }
}
