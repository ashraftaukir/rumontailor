<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the reports page
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
            ->get();

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
            ->get();

        // Top Customers by Revenue
        $topCustomers = Customer::with('orders')
            ->get()
            ->map(function ($customer) {
                $customer->total_revenue = $customer->orders->sum('total_amount');
                $customer->orders_count = $customer->orders->count();
                return $customer;
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

        // Format data for charts
        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        foreach ($revenueByMonth as $item) {
            $date = Carbon::create($item->year, $item->month, 1);
            $monthlyRevenueLabels[] = $date->format('M Y');
            $monthlyRevenueData[] = (float) $item->total;
        }

        $monthlyOrdersLabels = [];
        $monthlyOrdersData = [];
        foreach ($ordersByMonth as $item) {
            $date = Carbon::create($item->year, $item->month, 1);
            $monthlyOrdersLabels[] = $date->format('M Y');
            $monthlyOrdersData[] = (int) $item->count;
        }

        return view('admin.reports.index', compact(
            'totalCustomers',
            'totalOrders',
            'totalRevenue',
            'averageOrderValue',
            'ordersByStatus',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'monthlyOrdersLabels',
            'monthlyOrdersData',
            'topCustomers',
            'ordersByGarmentType',
            'recentOrdersCount',
            'previousMonthOrdersCount',
            'revenueGrowth',
            'currentMonthRevenue',
            'lastMonthRevenue'
        ));
    }
}

