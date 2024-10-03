<?php

namespace App\Models;

use App\Models\DataMaster\M_product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'action',
    ];

    public function product()
    {
        return $this->belongsTo(M_product::class, 'product_id');
    }
}
