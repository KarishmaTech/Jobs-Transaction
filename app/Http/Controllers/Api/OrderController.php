<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessOrderJob;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Exception;


class OrderController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'total_amount' => $total,
            ]);

            foreach ($request->items as $item) {
                OrderDetail::create([
                    'order_id'     => $order->id,
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            DB::commit();
            ProcessOrderJob::dispatch($order->id);

            return response()->json(['message' => 'Order placed and job dispatched.']);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order creation failed.', [
                'error' => $e->getMessage(),
                'input' => $request->all()
            ]);

            return response()->json([
                'error' => 'Something went wrong.',
                'details' => $e->getMessage()
            ], 500);
        }
    }


}
