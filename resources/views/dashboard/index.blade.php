@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="row g-4">
        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card shadow border-0 bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title text-white-50">Total Products</h5>
                    <h2 class="display-6 fw-bold m-0">{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Stock -->
        <div class="col-md-3">
            <div class="card shadow border-0 bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title text-white-50">Total Stock</h5>
                    <h2 class="display-6 fw-bold m-0">{{ $totalStock }} <span class="fs-5 fw-normal">units</span></h2>
                </div>
            </div>
        </div>

        <!-- Total Value -->
        <div class="col-md-3">
            <div class="card shadow border-0 bg-warning text-dark h-100">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Value</h5>
                    <h2 class="display-6 fw-bold m-0">${{ number_format($totalValue, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-md-3">
            <div class="card shadow border-0 bg-danger text-white h-100">
                <div class="card-body">
                    <h5 class="card-title text-white-50">Low Stock Items</h5>
                    <h2 class="display-6 fw-bold m-0">{{ $lowStock }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="mb-4">Product Stock Chart</h4>
                    @if ($productNames && $productNames->count() > 0)
                        <div style="position: relative; height:40vh; width:100%">
                            <canvas id="productChart"></canvas>
                        </div>
                    @else
                        <div class="alert alert-info m-0">No products available to display chart</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="card shadow border-0 mt-4">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Low Stock Alert</h4>
        </div>
        <div class="card-body">
            @if ($lowStockProducts->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $product->qty }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-success mb-0">
                    All products are sufficiently stocked 😄
                </div>
            @endif
        </div>
    </div>

    <!-- Sales Revenue Chart -->
    <div class="card shadow border-0 mt-4">
        <div class="card-body">
            <h4 class="mb-4">Sales Revenue Chart</h4>
            <div style="position: relative; height:40vh; width:100%">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Sales Overview Cards -->
    <div class="row g-4 mt-1">
        <div class="col-md-4">
            <div class="card shadow border-0 bg-info text-white">
                <div class="card-body">
                    <h5>Total Sales</h5>
                    <h2>{{ $totalSales }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 bg-success text-white">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h2>${{ $totalRevenue }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 bg-dark text-white">
                <div class="card-body">
                    <h5>Best Selling</h5>
                    <h4>{{ $bestSelling->product->name ?? 'N/A' }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Today Sales Cards -->
    <div class="row g-4 mt-1">
        <div class="col-md-6">
            <div class="card shadow border-0 bg-primary text-white">
                <div class="card-body">
                    <h5>Today's Sales</h5>
                    <h2>{{ $todaySales }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow border-0 bg-warning text-dark">
                <div class="card-body">
                    <h5>Today's Revenue</h5>
                    <h2>${{ $todayRevenue }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Today Sold Products Table -->
    <div class="card shadow border-0 mt-4">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Today's Sold Products</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($todayProducts as $sale)
                        <tr>
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->qty }}</td>
                            <td>${{ $sale->total }}</td>
                            <td>{{ $sale->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Period Revenue & Sales -->
    <div class="row g-4 mt-1 mb-4">
        <div class="col-md-3">
            <div class="card shadow border-0 bg-success text-white">
                <div class="card-body">
                    <h5>Monthly Revenue</h5>
                    <h3>${{ $monthlyRevenue }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-dark text-white">
                <div class="card-body">
                    <h5>Yearly Revenue</h5>
                    <h3>${{ $yearlyRevenue }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-primary text-white">
                <div class="card-body">
                    <h5>Monthly Sales</h5>
                    <h3>{{ $monthlySales }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-warning text-dark">
                <div class="card-body">
                    <h5>Yearly Sales</h5>
                    <h3>{{ $yearlySales }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Script បង្កើត Chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Product Stock Chart
            const ctx = document.getElementById('productChart');
            if (ctx) {
                const productNames = {!! isset($productNames) ? json_encode($productNames) : '[]' !!};
                const productQtys = {!! isset($productQtys) ? json_encode($productQtys) : '[]' !!};

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: 'Product Quantity',
                            data: productQtys,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // 2. Sales Revenue Chart
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                const salesLabels = {!! isset($salesLabels) ? json_encode($salesLabels) : '[]' !!};
                const salesData = {!! isset($salesData) ? json_encode($salesData) : '[]' !!};

                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: salesLabels,
                        datasets: [{
                            label: 'Revenue ($)',
                            data: salesData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
