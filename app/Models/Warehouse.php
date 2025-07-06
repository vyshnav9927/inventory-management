<?php

namespace App\Models;

use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location'
    ];


    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

}
