<?php

namespace App\Listeners;

use App\Events\StockMovementEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;

class StockMovementListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockMovementEvent $event): void
    {

        Cache::forget('inventory_details');
        DB::table('stock_logs')->insert([
            ...$event->logDetails,
        ]);
    }
}
