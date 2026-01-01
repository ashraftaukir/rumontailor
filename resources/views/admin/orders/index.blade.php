<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders - Admin Dashboard</title>
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
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
        }
        
        .table-row-hover {
            transition: all 0.2s ease;
        }
        
        .table-row-hover:hover {
            transform: translateX(4px);
            background: linear-gradient(to right, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                            <a href="{{ route('admin.customers.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-users mr-2"></i>Customers
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="group px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-shopping-bag mr-2 group-hover:rotate-12 transition"></i>Orders
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 hover:bg-white/60 hover:text-indigo-600 transition backdrop-blur">
                                <i class="fas fa-chart-line mr-2"></i>Reports
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
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

        <main class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="flex justify-between items-center mb-10 animate-fadeInUp">
                    <div>
                        <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-3">
                            Orders
                        </h2>
                        <p class="text-xl text-gray-600 font-medium">Manage all customer orders</p>
                    </div>
                    <a href="{{ route('admin.orders.create') }}" class="group inline-flex items-center px-6 py-3.5 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                        <i class="fas fa-plus-circle mr-2 text-lg group-hover:rotate-90 transition"></i>Create New Order
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 glass-effect rounded-xl shadow-xl border-l-4 border-green-500 p-5 animate-slideIn">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <p class="font-bold text-gray-900">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Search and Filter Form -->
                <div class="mb-6 glass-effect rounded-2xl shadow-xl p-6 animate-fadeInUp" style="animation-delay: 0.1s;">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
                        <!-- Search Bar -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Search by order number, customer name, phone, or email..." 
                                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                                </div>
                            </div>
                        </div>

                        <!-- Filters Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-filter mr-2 text-indigo-600"></i>Status
                                </label>
                                <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </div>

                            <!-- Garment Type Filter -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tshirt mr-2 text-purple-600"></i>Garment Type
                                </label>
                                <select name="garment_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                                    <option value="">All Types</option>
                                    <option value="shirt" {{ request('garment_type') == 'shirt' ? 'selected' : '' }}>👔 Shirt</option>
                                    <option value="pant" {{ request('garment_type') == 'pant' ? 'selected' : '' }}>👖 Pant</option>
                                    <option value="suit" {{ request('garment_type') == 'suit' ? 'selected' : '' }}>🤵 Suit</option>
                                </select>
                            </div>

                            <!-- Date From -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-pink-600"></i>From Date
                                </label>
                                <input type="date" 
                                       name="date_from" 
                                       value="{{ request('date_from') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-2 text-blue-600"></i>To Date
                                </label>
                                <input type="date" 
                                       name="date_to" 
                                       value="{{ request('date_to') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                                <i class="fas fa-search mr-2"></i>Search & Filter
                            </button>
                            @if(request()->anyFilled(['search', 'status', 'garment_type', 'date_from', 'date_to']))
                                <a href="{{ route('admin.orders.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition">
                                    <i class="fas fa-times mr-2"></i>Clear All
                                </a>
                            @endif
                        </div>

                        <!-- Active Filters Display -->
                        @if(request()->anyFilled(['search', 'status', 'garment_type', 'date_from', 'date_to']))
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Active Filters:</p>
                                <div class="flex flex-wrap gap-2">
                                    @if(request('search'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            Search: "{{ request('search') }}"
                                            <a href="{{ route('admin.orders.index', request()->except('search')) }}" class="ml-2 text-indigo-600 hover:text-indigo-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('status'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                                            <a href="{{ route('admin.orders.index', request()->except('status')) }}" class="ml-2 text-purple-600 hover:text-purple-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('garment_type'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                                            Type: {{ ucfirst(request('garment_type')) }}
                                            <a href="{{ route('admin.orders.index', request()->except('garment_type')) }}" class="ml-2 text-pink-600 hover:text-pink-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('date_from'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            From: {{ request('date_from') }}
                                            <a href="{{ route('admin.orders.index', request()->except('date_from')) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                    @if(request('date_to'))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            To: {{ request('date_to') }}
                                            <a href="{{ route('admin.orders.index', request()->except('date_to')) }}" class="ml-2 text-green-600 hover:text-green-800">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Orders Table -->
                <div class="glass-effect rounded-2xl shadow-2xl overflow-hidden animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-2 text-indigo-600"></i>Order Number
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2 text-indigo-600"></i>Customer
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2 text-indigo-600"></i>Date
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i>Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-coins mr-2 text-indigo-600"></i>Amount (৳)
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-2 text-indigo-600"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="table-row-hover">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="relative">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-xl blur opacity-50"></div>
                                                    <div class="relative w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                                        <i class="fas fa-shopping-bag text-white"></i>
                                                    </div>
                                                </div>
                                                <span class="text-sm font-black text-indigo-600">{{ $order->order_number }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="relative">
                                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full blur opacity-50"></div>
                                                    <div class="relative w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                                        <span class="text-xs font-black text-white">{{ strtoupper(substr($order->customer->name, 0, 1)) }}</span>
                                                    </div>
                                                </div>
                                                <span class="text-sm font-bold text-gray-900">{{ $order->customer->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                                                {{ $order->order_date->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black shadow-md
                                                @if($order->status == 'completed') bg-gradient-to-r from-green-400 to-green-600 text-white
                                                @elseif($order->status == 'in_progress') bg-gradient-to-r from-blue-400 to-blue-600 text-white
                                                @elseif($order->status == 'delivered') bg-gradient-to-r from-purple-400 to-purple-600 text-white
                                                @elseif($order->status == 'cancelled') bg-gradient-to-r from-red-400 to-red-600 text-white
                                                @else bg-gradient-to-r from-yellow-400 to-orange-500 text-white
                                                @endif">
                                                @if($order->status == 'completed')
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                @elseif($order->status == 'in_progress')
                                                    <i class="fas fa-spinner mr-2 animate-spin"></i>
                                                @elseif($order->status == 'delivered')
                                                    <i class="fas fa-truck mr-2"></i>
                                                @elseif($order->status == 'cancelled')
                                                    <i class="fas fa-times-circle mr-2"></i>
                                                @else
                                                    <i class="fas fa-clock mr-2"></i>
                                                @endif
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-base font-black text-gray-900">৳{{ number_format($order->total_amount, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="p-2.5 text-indigo-600 hover:bg-gradient-to-br hover:from-indigo-50 hover:to-purple-50 rounded-xl transition transform hover:scale-110 shadow-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.edit', $order) }}" class="p-2.5 text-blue-600 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 rounded-xl transition transform hover:scale-110 shadow-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2.5 text-red-600 hover:bg-gradient-to-br hover:from-red-50 hover:to-pink-50 rounded-xl transition transform hover:scale-110 shadow-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="glass-effect rounded-2xl shadow-xl p-12 inline-block">
                                                <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                                    <i class="fas fa-shopping-bag text-gray-400 text-4xl"></i>
                                                </div>
                                                <h3 class="text-2xl font-black text-gray-900 mb-3">
                                                    @if(request()->anyFilled(['search', 'status', 'garment_type', 'date_from', 'date_to']))
                                                        No orders found matching your filters
                                                    @else
                                                        No orders found
                                                    @endif
                                                </h3>
                                                <p class="text-gray-600 mb-8 font-medium">
                                                    @if(request()->anyFilled(['search', 'status', 'garment_type', 'date_from', 'date_to']))
                                                        Try adjusting your search or filters, or <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 font-bold hover:underline">clear all filters</a>.
                                                    @else
                                                        Get started by creating your first order.
                                                    @endif
                                                </p>
                                                @if(!request()->anyFilled(['search', 'status', 'garment_type', 'date_from', 'date_to']))
                                                    <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                                        <i class="fas fa-plus-circle mr-2 text-lg"></i>Create Order
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="mt-10">
                        <div class="glass-effect rounded-xl shadow-xl p-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
