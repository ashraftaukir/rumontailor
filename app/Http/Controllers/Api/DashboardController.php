<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProgressOrders = Order::where('status', 'in_progress')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'statistics' => [
                'total_customers' => $totalCustomers,
                'total_orders' => $totalOrders,
                'total_revenue' => (float) $totalRevenue,
                'average_order_value' => $totalOrders > 0 ? (float) ($totalRevenue / $totalOrders) : 0,
                'pending_orders' => $pendingOrders,
                'in_progress_orders' => $inProgressOrders,
                'completed_orders' => $completedOrders,
                'delivered_orders' => $deliveredOrders,
            ],
            'recent_orders' => $recentOrders,
        ]);
    }
}

