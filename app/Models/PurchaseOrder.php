<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'rfq_id', 'id');
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    
}
