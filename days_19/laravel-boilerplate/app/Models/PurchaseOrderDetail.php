<?php

namespace App\Models;

use App\Models\DataMaster\M_product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_m_purchase_orders';

    public function product()
    {
        return $this->belongsTo(M_product::class, 'product_id');
    }
}
