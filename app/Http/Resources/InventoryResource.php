<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'warehouse_id'=>$this->warehouse_id,
           'warehouse_name'=>$this->warehouse->name,
           'warehouse_location'=>$this->warehouse->location,
           'product_id'=>$this->product_id,
           'product_sku'=>$this->product->sku,
           'product_name'=>$this->product->name,
           'stock_levels'=>(int)$this->stock_levels
        ];
    }
}
