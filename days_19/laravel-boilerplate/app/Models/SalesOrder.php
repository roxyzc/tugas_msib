<?php

namespace App\Models;

use App\Models\DataMaster\M_customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'total_amount',
    ];

    public function customer()
    {
        return $this->belongsTo(M_customer::class);
    }

    public function details()
    {
        return $this->hasMany(SalesOrderDetail::class);
    }
}
