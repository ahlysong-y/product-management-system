<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Product Statistics
        $totalProducts = Product::count();
        $totalStock = Product::sum('qty');
        $totalValue = Product::sum(DB::raw('qty * price'));
        $lowStock = Product::where('qty', '<', 10)->count();

        // Sales Statistics
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total');

        // Chart Data - Products
        $productNames = Product::pluck('name');
        $productQtys = Product::pluck('qty');

        // Best Selling Products with eager loading
        $bestSelling = Sale::query()
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->first();

        // Sales Chart Data - with eager loading to avoid N+1
        $salesData = Sale::with('product')
            ->latest()
            ->limit(50)
            ->get();

        $salesLabels = $salesData->pluck('product.name');
        $salesChartData = $salesData->pluck('total');

        // Low Stock Products
        $lowStockProducts = Product::where('qty', '<', 5)->get();

        // Today's Statistics
        $todaySales = Sale::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Sale::whereDate('created_at', Carbon::today())->sum('total');
        $todayProducts = Sale::whereDate('created_at', Carbon::today())
            ->with('product')
            ->latest()
            ->get();

        // Monthly Statistics
        $monthlyRevenue = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $monthlySales = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Yearly Statistics
        $yearlyRevenue = Sale::whereYear('created_at', now()->year)->sum('total');
        $yearlySales = Sale::whereYear('created_at', now()->year)->count();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalStock',
            'totalValue',
            'lowStock',
            'totalSales',
            'totalRevenue',
            'bestSelling',
            'productNames',
            'productQtys',
            'salesLabels',
            'salesChartData',
            'lowStockProducts',
            'todaySales',
            'todayRevenue',
            'todayProducts',
            'monthlyRevenue',
            'yearlyRevenue',
            'monthlySales',
            'yearlySales', // <--- ត្រូវតែមាន
            'salesData'
        ));
    }
}
