<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'type',
        'quantity',
        'movement_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }


}
