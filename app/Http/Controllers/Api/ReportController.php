<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Get comprehensive reports
     */
    public function index()
    {
        // Overall Statistics
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Orders by Status
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Revenue by Month (Last 12 months)
        $revenueByMonth = Order::select(
                DB::raw('YEAR(order_date) as year'),
                DB::raw('MONTH(order_date) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('order_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::create($item->year, $item->month, 1);
                return [
                    'month' => $date->format('M Y'),
                    'year' => $item->year,
                    'month_number' => $item->month,
                    'revenue' => (float) $item->total,
                ];
            });

        // Orders by Month (Last 12 months)
        $ordersByMonth = Order::select(
                DB::raw('YEAR(order_date) as year'),
                DB::raw('MONTH(order_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('order_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::create($item->year, $item->month, 1);
                return [
                    'month' => $date->format('M Y'),
                    'year' => $item->year,
                    'month_number' => $item->month,
                    'count' => (int) $item->count,
                ];
            });

        // Top Customers by Revenue
        $topCustomers = Customer::with('orders')
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'total_revenue' => (float) $customer->orders->sum('total_amount'),
                    'orders_count' => $customer->orders->count(),
                ];
            })
            ->sortByDesc('total_revenue')
            ->take(10)
            ->values();

        // Orders by Garment Type
        $ordersByGarmentType = Order::select('garment_type', DB::raw('count(*) as count'))
            ->whereNotNull('garment_type')
            ->groupBy('garment_type')
            ->get()
            ->pluck('count', 'garment_type')
            ->toArray();

        // Recent Orders (Last 30 days)
        $recentOrdersCount = Order::where('order_date', '>=', Carbon::now()->subDays(30))->count();
        $previousMonthOrdersCount = Order::whereBetween('order_date', [
            Carbon::now()->subDays(60),
            Carbon::now()->subDays(30)
        ])->count();

        // Revenue Growth
        $currentMonthRevenue = Order::whereMonth('order_date', Carbon::now()->month)
            ->whereYear('order_date', Carbon::now()->year)
            ->sum('total_amount');
        
        $lastMonthRevenue = Order::whereMonth('order_date', Carbon::now()->subMonth()->month)
            ->whereYear('order_date', Carbon::now()->subMonth()->year)
            ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        return response()->json([
            'overall_statistics' => [
                'total_customers' => $totalCustomers,
                'total_orders' => $totalOrders,
                'total_revenue' => (float) $totalRevenue,
                'average_order_value' => (float) $averageOrderValue,
            ],
            'orders_by_status' => $ordersByStatus,
            'revenue_by_month' => $revenueByMonth,
            'orders_by_month' => $ordersByMonth,
            'top_customers' => $topCustomers,
            'orders_by_garment_type' => $ordersByGarmentType,
            'recent_orders_count' => $recentOrdersCount,
            'previous_month_orders_count' => $previousMonthOrdersCount,
            'revenue_growth' => (float) $revenueGrowth,
            'current_month_revenue' => (float) $currentMonthRevenue,
            'last_month_revenue' => (float) $lastMonthRevenue,
        ]);
    }

    /**
     * Get quick statistics
     */
    public function statistics()
    {
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return response()->json([
            'total_customers' => $totalCustomers,
            'total_orders' => $totalOrders,
            'total_revenue' => (float) $totalRevenue,
            'average_order_value' => (float) $averageOrderValue,
            'orders_by_status' => $ordersByStatus,
        ]);
    }
}

