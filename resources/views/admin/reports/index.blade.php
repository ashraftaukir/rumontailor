<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="glass-effect shadow-2xl border-b border-white/20 sticky top-0 z-50" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-black text-xl">K</span>
                            </div>
                            <h1 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                                Tailor Admin
                            </h1>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-users mr-2"></i>Customers
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-shopping-bag mr-2"></i>Orders
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="group px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition"></i>Reports
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">Admin User</p>
                            <p class="text-xs text-gray-600">Administrator</p>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Page Header -->
            <div class="mb-8 animate-fadeInUp">
                <div class="glass-effect rounded-2xl shadow-2xl p-8" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                    <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-2">
                        Reports & Analytics
                    </h2>
                    <p class="text-xl text-gray-600 font-medium">Comprehensive insights into your business performance</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="glass-effect rounded-2xl shadow-2xl p-6 stat-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.1s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Revenue</p>
                            <p class="text-3xl font-black text-gray-900 mb-1">৳{{ number_format($totalRevenue, 2) }}</p>
                            <p class="text-xs text-gray-500">
                                @if($revenueGrowth > 0)
                                    <span class="text-green-600 font-semibold"><i class="fas fa-arrow-up mr-1"></i>{{ number_format($revenueGrowth, 1) }}%</span>
                                @elseif($revenueGrowth < 0)
                                    <span class="text-red-600 font-semibold"><i class="fas fa-arrow-down mr-1"></i>{{ number_format(abs($revenueGrowth), 1) }}%</span>
                                @else
                                    <span class="text-gray-600 font-semibold">No change</span>
                                @endif
                                vs last month
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-coins text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-2xl shadow-2xl p-6 stat-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.2s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Orders</p>
                            <p class="text-3xl font-black text-gray-900 mb-1">{{ number_format($totalOrders) }}</p>
                            <p class="text-xs text-gray-500">{{ $recentOrdersCount }} orders in last 30 days</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-shopping-bag text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-2xl shadow-2xl p-6 stat-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.3s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Customers</p>
                            <p class="text-3xl font-black text-gray-900 mb-1">{{ number_format($totalCustomers) }}</p>
                            <p class="text-xs text-gray-500">Active customers</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="glass-effect rounded-2xl shadow-2xl p-6 stat-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.4s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Avg Order Value</p>
                            <p class="text-3xl font-black text-gray-900 mb-1">৳{{ number_format($averageOrderValue, 2) }}</p>
                            <p class="text-xs text-gray-500">Per order average</p>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenue Chart -->
                <div class="glass-effect rounded-2xl shadow-2xl p-6" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.5s;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-area text-indigo-600 mr-2"></i>Revenue Trend (Last 12 Months)
                    </h3>
                    <canvas id="revenueChart" height="100"></canvas>
                </div>

                <!-- Orders Chart -->
                <div class="glass-effect rounded-2xl shadow-2xl p-6" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.6s;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-purple-600 mr-2"></i>Orders Trend (Last 12 Months)
                    </h3>
                    <canvas id="ordersChart" height="100"></canvas>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Orders by Status -->
                <div class="glass-effect rounded-2xl shadow-2xl p-6" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.7s;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-pie-chart text-pink-600 mr-2"></i>Orders by Status
                    </h3>
                    <canvas id="statusChart" height="100"></canvas>
                </div>

                <!-- Orders by Garment Type -->
                <div class="glass-effect rounded-2xl shadow-2xl p-6" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.8s;">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-tshirt text-blue-600 mr-2"></i>Orders by Garment Type
                    </h3>
                    <canvas id="garmentTypeChart" height="100"></canvas>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="glass-effect rounded-2xl shadow-2xl p-6 mb-8" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.9s;">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-trophy text-yellow-600 mr-2"></i>Top 10 Customers by Revenue
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Customer Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Total Orders</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topCustomers as $index => $customer)
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-bold text-sm">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $customer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->email ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $customer->orders_count ?? $customer->orders->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-indigo-600">৳{{ number_format($customer->total_revenue ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No customers found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($monthlyRevenueLabels),
                datasets: [{
                    label: 'Revenue (৳)',
                    data: @json($monthlyRevenueData),
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ৳' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyOrdersLabels),
                datasets: [{
                    label: 'Orders',
                    data: @json($monthlyOrdersData),
                    backgroundColor: 'rgba(139, 92, 246, 0.8)',
                    borderColor: 'rgb(139, 92, 246)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
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

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusData = @json($ordersByStatus);
        const statusLabels = Object.keys(statusData).map(status => status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' '));
        const statusValues = Object.values(statusData);
        const statusColors = {
            'pending': 'rgba(251, 191, 36, 0.8)',
            'in_progress': 'rgba(59, 130, 246, 0.8)',
            'completed': 'rgba(34, 197, 94, 0.8)',
            'delivered': 'rgba(139, 92, 246, 0.8)',
            'cancelled': 'rgba(239, 68, 68, 0.8)'
        };
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: Object.keys(statusData).map(status => statusColors[status] || 'rgba(156, 163, 175, 0.8)'),
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Garment Type Chart
        const garmentCtx = document.getElementById('garmentTypeChart').getContext('2d');
        const garmentData = @json($ordersByGarmentType);
        const garmentLabels = Object.keys(garmentData).map(type => type.charAt(0).toUpperCase() + type.slice(1));
        const garmentValues = Object.values(garmentData);
        
        new Chart(garmentCtx, {
            type: 'pie',
            data: {
                labels: garmentLabels,
                datasets: [{
                    data: garmentValues,
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>

