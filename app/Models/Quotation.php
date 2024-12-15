<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model{
    use HasFactory;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    public function pembayaran(){
        return $this->belongsTo('App\Models\Pembayaran');
    }

    public function items(){
        return $this->hasMany('App\Models\QuotationItem');
    }

    public function calculateTotals(){
        $totalSebelumPajak = $this->items->sum(function ($item) {
            return $item->kuantitas * $item->harga;
        });

        $totalPajak = $this->items->sum(function ($item) {
            return $item->kuantitas * $item->harga * ($item->tax / 100);
        });

        $this->update([
            'total_sebelum_pajak' => $totalSebelumPajak,
            'total_pajak' => $totalPajak,
            'total_keseluruhan' => $totalSebelumPajak + $totalPajak,
        ]);
    }
    
    public function produks() {
        return $this->belongsToMany(Produk::class, 'quotation_items')
                    ->withPivot('kuantitas', 'harga', 'tax', 'subtotal')
                    ->withTimestamps();
    }

    public function salesOrder(){
        return $this->hasOne('App\Models\SalesOrder');
    }
}
