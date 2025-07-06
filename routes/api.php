<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/inventory/report', [InventoryController::class, 'inventoryReport']);
Route::post('/stock-movements', [InventoryController::class, 'createStockMovement'])->middleware('auth:sanctum');
