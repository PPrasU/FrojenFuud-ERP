<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForQuotation extends Model
{
    use HasFactory;

    protected $table = 'request_for_quotations'; // Tabel RFQ
    protected $fillable = [
        'vendor_id',
        'reference',
        'vendor_reference',
        'tanggal',
        'total',
        'company',
        'status',
        'status_po',
        'received',
        'billed',
        'status_bill',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function bahans()
    {
        return $this->belongsToMany(
            Bahan::class,
            'request_for_quotation_bahans',
            'request_for_quotation_id',
            'bahan_id'
        )->withPivot('kuantitas', 'satuan')->withTimestamps();
    }

    public function quotation_bahans()
    {
        return $this->hasMany(RequestForQuotationBahan::class, 'request_for_quotation_id');
    }
}
