<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderStatusController extends Controller
{
    public function updateStorageStatus()
    {
        $today = Carbon::today();

        $orders = Order::whereIn('status', ['stored', 'due'])
            ->whereNotNull('storage_end_date')
            ->get();

        foreach ($orders as $order) {
            $endDate = Carbon::parse($order->storage_end_date);
            $diffDays = $today->diffInDays($endDate, false);

            if ($diffDays < 0) {
                $order->status = 'expired';
            } elseif ($diffDays <= 7) {
                $order->status = 'due';
            } else {
                $order->status = 'stored';
            }

            $order->save();
        }

        return response()->json([
            'message' => 'Order storage status updated successfully'
        ]);
    }
}
