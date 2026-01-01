<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
        }
        
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-border {
            position: relative;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        
        .gradient-border::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }
        
        .shimmer {
            position: relative;
            overflow: hidden;
        }
        
        .shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            100% {
                left: 100%;
            }
        }
        
        .icon-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-purple-50 to-blue-50 min-h-screen">
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="min-h-screen relative z-10">
        <!-- Navigation -->
        <nav class="glass-effect shadow-2xl border-b border-white/20 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-4 group">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition"></div>
                                <div class="relative w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition">
                                    <i class="fas fa-cut text-white text-xl"></i>
                                </div>
                            </div>
                            <h1 class="text-2xl font-black bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                                Tailor Admin
                            </h1>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.dashboard') }}" class="group px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-home mr-2 group-hover:rotate-12 transition"></i>Dashboard
                            </a>
                            <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-users mr-2"></i>Customers
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-shopping-bag mr-2"></i>Orders
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-chart-line mr-2"></i>Reports
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Quick Search -->
                        <div class="hidden md:block">
                            <form method="GET" action="{{ route('admin.orders.index') }}" class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       placeholder="Quick search orders..." 
                                       class="w-64 pl-10 pr-4 py-2 border-2 border-white/50 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white/80 backdrop-blur text-sm"
                                       onkeypress="if(event.key === 'Enter') this.form.submit()">
                            </form>
                        </div>
                        <div class="text-right px-4 py-2 rounded-xl bg-white/40 backdrop-blur">
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-purple-600 font-medium">Administrator</p>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="group inline-flex items-center px-5 py-2.5 text-sm font-bold rounded-xl text-white bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 shadow-lg shadow-red-500/50 hover:shadow-xl hover:shadow-red-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-sign-out-alt mr-2 group-hover:translate-x-1 transition"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Welcome Section -->
                <div class="mb-10 animate-fadeInUp">
                    <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-3">
                        Welcome back, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-xl text-gray-600 font-medium">Here's what's happening with your business today.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    <!-- Total Customers -->
                    <div class="stat-card glass-effect rounded-2xl shadow-xl p-7 border-l-4 border-blue-500 animate-fadeInUp" style="animation-delay: 0.1s;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Customers</p>
                                <p class="text-4xl font-black text-gray-900 mb-1">{{ $totalCustomers }}</p>
                                <div class="flex items-center text-green-600 text-sm font-semibold">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>12.5% increase</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/50 transform hover:rotate-12 transition">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-800 group">
                            View all <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>

                    <!-- Total Orders -->
                    <div class="stat-card glass-effect rounded-2xl shadow-xl p-7 border-l-4 border-green-500 animate-fadeInUp" style="animation-delay: 0.2s;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Orders</p>
                                <p class="text-4xl font-black text-gray-900 mb-1">{{ $totalOrders }}</p>
                                <div class="flex items-center text-green-600 text-sm font-semibold">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>8.2% increase</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/50 transform hover:rotate-12 transition">
                                <i class="fas fa-shopping-bag text-white text-2xl"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-bold text-green-600 hover:text-green-800 group">
                            View all <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>

                    <!-- Total Revenue -->
                    <div class="stat-card glass-effect rounded-2xl shadow-xl p-7 border-l-4 border-purple-500 animate-fadeInUp" style="animation-delay: 0.3s;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Total Revenue</p>
                                <p class="text-4xl font-black text-gray-900 mb-1">৳{{ number_format($totalRevenue, 2) }}</p>
                                <div class="flex items-center text-green-600 text-sm font-semibold">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>15.3% increase</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/50 transform hover:rotate-12 transition">
                                <i class="fas fa-coins text-white text-2xl"></i>
                            </div>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">All time revenue</p>
                    </div>

                    <!-- Pending Orders -->
                    <div class="stat-card glass-effect rounded-2xl shadow-xl p-7 border-l-4 border-yellow-500 animate-fadeInUp" style="animation-delay: 0.4s;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-600 mb-2 uppercase tracking-wider">Pending Orders</p>
                                <p class="text-4xl font-black text-gray-900 mb-1">{{ $pendingOrders }}</p>
                                <div class="flex items-center text-orange-600 text-sm font-semibold">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <span>Needs attention</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/50 transform hover:rotate-12 transition icon-bounce">
                                <i class="fas fa-clock text-white text-2xl"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.index') }}?status=pending" class="inline-flex items-center text-sm font-bold text-yellow-600 hover:text-yellow-800 group">
                            View pending <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions & Recent Orders -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Quick Actions Card -->
                    <div class="glass-effect rounded-2xl shadow-xl p-8 animate-fadeInUp" style="animation-delay: 0.5s;">
                        <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <i class="fas fa-bolt text-white"></i>
                            </div>
                            Quick Actions
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.customers.create') }}" class="group relative overflow-hidden flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 text-white rounded-2xl shadow-xl shadow-blue-500/50 hover:shadow-2xl hover:shadow-blue-500/60 transform hover:scale-105 transition">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition"></div>
                                <i class="fas fa-user-plus text-4xl mb-3 group-hover:scale-110 transition"></i>
                                <span class="font-bold text-lg">New Customer</span>
                            </a>
                            <a href="{{ route('admin.orders.create') }}" class="group relative overflow-hidden flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-500 via-green-600 to-emerald-700 text-white rounded-2xl shadow-xl shadow-green-500/50 hover:shadow-2xl hover:shadow-green-500/60 transform hover:scale-105 transition">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition"></div>
                                <i class="fas fa-plus-circle text-4xl mb-3 group-hover:scale-110 transition"></i>
                                <span class="font-bold text-lg">New Order</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="glass-effect rounded-2xl shadow-xl p-8 animate-fadeInUp" style="animation-delay: 0.6s;">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-gray-900 flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                    <i class="fas fa-history text-white"></i>
                                </div>
                                Recent Orders
                            </h3>
                            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 group">
                                View all <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentOrders as $order)
                                <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl hover:from-indigo-50 hover:to-purple-50 border border-gray-100 hover:border-indigo-200 shadow-sm hover:shadow-md transition transform hover:scale-[1.02]">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition shadow-sm">
                                            <i class="fas fa-shopping-bag text-indigo-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $order->order_number }}</p>
                                            <p class="text-xs text-gray-600 font-medium">{{ $order->customer->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-base font-black text-gray-900 mb-1">৳{{ number_format($order->total_amount, 2) }}</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm
                                            @if($order->status == 'completed') bg-gradient-to-r from-green-400 to-green-600 text-white
                                            @elseif($order->status == 'in_progress') bg-gradient-to-r from-blue-400 to-blue-600 text-white
                                            @else bg-gradient-to-r from-yellow-400 to-orange-500 text-white
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-sm text-gray-500 font-medium">No recent orders</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- User Info Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl p-8 text-white animate-fadeInUp" style="animation-delay: 0.7s;">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black mb-4 flex items-center">
                                <i class="fas fa-shield-alt mr-3"></i>
                                Account Information
                            </h3>
                            <div class="space-y-3 text-base font-medium">
                                <div class="flex items-center bg-white/10 backdrop-blur rounded-xl px-4 py-3">
                                    <i class="fas fa-user mr-3 w-5"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                                <div class="flex items-center bg-white/10 backdrop-blur rounded-xl px-4 py-3">
                                    <i class="fas fa-envelope mr-3 w-5"></i>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                                <div class="flex items-center bg-white/10 backdrop-blur rounded-xl px-4 py-3">
                                    <i class="fas fa-shield-alt mr-3 w-5"></i>
                                    <span>Administrator</span>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-0 bg-white rounded-full blur-2xl opacity-20 animate-pulse"></div>
                            <div class="relative w-28 h-28 bg-white/20 backdrop-blur rounded-full flex items-center justify-center border-4 border-white/30 shadow-2xl">
                                <i class="fas fa-user-circle text-6xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>