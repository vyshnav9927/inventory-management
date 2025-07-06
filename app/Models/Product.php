<?php

namespace App\Models;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description'
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
