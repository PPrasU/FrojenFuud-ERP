<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quotation(){
        return $this->belongsTo('App\Models\Quotation');
    }
    public function salesOrder(){
        return $this->belongsTo('App\Models\SalesOrder');
    }
    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }
    public function pembayaran(){
        return $this->belongsTo('App\Models\Pembayaran');
    }
    public function produk(){
        return $this->belongsTo('App\Models\Produk');
    }
}
