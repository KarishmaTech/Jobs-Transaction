<?php

namespace App\Jobs;

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

public function handle(): void
{
    Log::info("Job started for Order ID: {$this->orderId}");

    $order = Order::with('details')->find($this->orderId);

    if (!$order) {
        Log::warning("Order ID {$this->orderId} not found.");
        return;
    }

    Log::info("Processing Order ID: {$order->id}, Customer: {$order->customer_name}, Total: {$order->total_amount}");

    foreach ($order->details as $detail) {
        Log::info(" - Product: {$detail->product_name}, Qty: {$detail->quantity}, Price: {$detail->price}");
    }
}



}


