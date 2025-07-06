<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Http\Resources\InventoryResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use App\Events\StockMovementEvent;


class InventoryController extends Controller
{

    public function inventoryReport(Request $request)
    {

        $stockMovements = Cache::rememberForever('inventory_details', function () {
            return StockMovement::select('warehouse_id', 'product_id', DB::raw('SUM(CASE WHEN type = 1 THEN quantity ELSE -quantity END) as stock_levels'))
                ->with('warehouse', 'product')
                ->groupBy('product_id', 'warehouse_id')->orderBy('warehouse_id')->get();
        });
        $stockMovements = $stockMovements->when($request->has('warehouse_id'), fn($query) => $query->where('warehouse_id', $request->warehouse_id))
            ->when($request->has('product_id'), fn($query) => $query->where('product_id', $request->product_id));

        return InventoryResource::collection($stockMovements);
    }


    public function createStockMovement(StockRequest $request)
    {

        $stockData = $request->validated();

        try {
            StockMovement::create([
                ...$stockData,
                'movement_date' => now()->format('d-m-y')
            ]);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        } finally {
            StockMovementEvent::dispatch([
                'status' => !isset($error) ? "SUCCESS" : "FAILED",
                'payload' => json_encode($stockData),
                'message' => isset($error) ? $error : NULL,
                'datetime' => now()
            ]);
            return response()->json([
                'success' => !isset($error) ?: false,
                'message' => !isset($error) ? 'Stock movement recorded!' : 'Failed to Create Stock ' . $error
            ], 200);
        }
    }
}
