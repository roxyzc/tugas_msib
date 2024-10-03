<?php

namespace App\Models;

use App\Models\DataMaster\M_supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function supplier()
    {
        return $this->belongsTo(M_supplier::class, 'supplier_id');
    }

    // Jika ada relasi dengan PurchaseOrderDetail, tambahkan juga
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }
}
