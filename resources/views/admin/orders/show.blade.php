<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details - Admin Dashboard</title>
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
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
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
        <nav class="glass-effect shadow-2xl border-b border-white/20 sticky top-0 z-50" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
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
                <div class="mb-8 flex justify-between items-center animate-fadeInUp">
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group font-bold">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition"></i>Back to Orders
                    </a>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Order
                    </a>
                </div>

                <!-- Order Header Card -->
                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl p-8 mb-6 text-white animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-3xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold">{{ $order->order_number }}</h2>
                                    <p class="text-indigo-100">Order Details</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-6">
                                <div>
                                    <p class="text-sm text-indigo-100 mb-1">Total Amount</p>
                                    <p class="text-2xl font-bold">৳{{ number_format($order->total_amount, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-indigo-100 mb-1">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-white bg-opacity-20
                                        @if($order->status == 'completed') text-green-100
                                        @elseif($order->status == 'in_progress') text-blue-100
                                        @elseif($order->status == 'delivered') text-purple-100
                                        @elseif($order->status == 'cancelled') text-red-100
                                        @else text-yellow-100
                                        @endif">
                                        @if($order->status == 'completed')
                                            <i class="fas fa-check-circle mr-2"></i>
                                        @elseif($order->status == 'in_progress')
                                            <i class="fas fa-spinner mr-2"></i>
                                        @elseif($order->status == 'delivered')
                                            <i class="fas fa-truck mr-2"></i>
                                        @elseif($order->status == 'cancelled')
                                            <i class="fas fa-times-circle mr-2"></i>
                                        @else
                                            <i class="fas fa-clock mr-2"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-indigo-600 mr-2"></i>Customer Information
                        </h3>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                    {{ $order->customer->name }}
                                </a>
                                @if($order->customer->email)
                                    <p class="text-sm text-gray-500">{{ $order->customer->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Dates -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>Order Dates
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-700">Order Date</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $order->order_date->format('F d, Y') }}</span>
                            </div>
                            @if($order->delivery_date)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-truck text-gray-400 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-700">Delivery Date</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">{{ $order->delivery_date->format('F d, Y') }}</span>
                                </div>
                            @else
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-truck text-gray-400 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-700">Delivery Date</span>
                                    </div>
                                    <span class="text-sm text-gray-500">Not set</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                @if($order->items && $order->items->count() > 0)
                    <div class="glass-effect rounded-2xl shadow-2xl p-6 mb-6 animate-fadeInUp" style="animation-delay: 0.3s;">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-shopping-bag text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Order Items</h3>
                                    <p class="text-sm text-gray-600">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} in this order</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @foreach($order->items as $index => $item)
                                <div class="border-2 border-gray-200 rounded-xl p-6 bg-white/50">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                            <i class="fas fa-tshirt text-indigo-600 mr-2"></i>
                                            Item #{{ $index + 1 }}: 
                                            <span class="ml-2">
                                                @if($item->garment_type == 'shirt') 👔 Shirt
                                                @elseif($item->garment_type == 'pant') 👖 Pant
                                                @elseif($item->garment_type == 'suit') 🤵 Suit
                                                @else {{ ucfirst($item->garment_type) }}
                                                @endif
                                            </span>
                                        </h4>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">Price</p>
                                            <p class="text-xl font-black text-indigo-600">৳{{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>

                                    @if($item->description)
                                        <p class="text-gray-700 mb-4">{{ $item->description }}</p>
                                    @endif

                                    <!-- Item Measurements -->
                                    @if($item->chest || $item->waist || $item->shoulder_width || $item->sleeve_length || $item->shirt_length || $item->jacket_length || $item->neck || $item->armhole || $item->bicep || $item->wrist || $item->hip || $item->inseam || $item->outseam || $item->thigh || $item->knee || $item->ankle || $item->pant_length)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <h5 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                                <i class="fas fa-ruler-combined text-purple-600 mr-2"></i>Measurements
                                            </h5>
                                            
                                            <!-- Shirt Measurements -->
                                            @if($item->garment_type == 'shirt' && ($item->chest || $item->waist || $item->shoulder_width || $item->sleeve_length || $item->shirt_length || $item->neck || $item->armhole || $item->bicep || $item->wrist))
                                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                    @if($item->chest)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Chest</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->chest, 2) }}"</p></div>@endif
                                                    @if($item->waist)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Waist</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->waist, 2) }}"</p></div>@endif
                                                    @if($item->shoulder_width)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Shoulder Width</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->shoulder_width, 2) }}"</p></div>@endif
                                                    @if($item->sleeve_length)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Sleeve Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->sleeve_length, 2) }}"</p></div>@endif
                                                    @if($item->shirt_length)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Shirt Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->shirt_length, 2) }}"</p></div>@endif
                                                    @if($item->neck)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Neck</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->neck, 2) }}"</p></div>@endif
                                                    @if($item->armhole)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Armhole</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->armhole, 2) }}"</p></div>@endif
                                                    @if($item->bicep)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Bicep</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->bicep, 2) }}"</p></div>@endif
                                                    @if($item->wrist)<div class="bg-blue-50 rounded-lg p-2 border border-blue-100"><p class="text-xs text-gray-500 mb-1">Wrist</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->wrist, 2) }}"</p></div>@endif
                                                </div>
                                            @endif

                                            <!-- Pant Measurements -->
                                            @if($item->garment_type == 'pant' && ($item->waist || $item->hip || $item->inseam || $item->outseam || $item->thigh || $item->knee || $item->ankle || $item->pant_length))
                                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                    @if($item->waist)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Waist</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->waist, 2) }}"</p></div>@endif
                                                    @if($item->hip)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Hip</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->hip, 2) }}"</p></div>@endif
                                                    @if($item->inseam)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Inseam</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->inseam, 2) }}"</p></div>@endif
                                                    @if($item->outseam)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Outseam</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->outseam, 2) }}"</p></div>@endif
                                                    @if($item->thigh)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Thigh</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->thigh, 2) }}"</p></div>@endif
                                                    @if($item->knee)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Knee</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->knee, 2) }}"</p></div>@endif
                                                    @if($item->ankle)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Ankle</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->ankle, 2) }}"</p></div>@endif
                                                    @if($item->pant_length)<div class="bg-green-50 rounded-lg p-2 border border-green-100"><p class="text-xs text-gray-500 mb-1">Pant Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->pant_length, 2) }}"</p></div>@endif
                                                </div>
                                            @endif

                                            <!-- Suit Measurements -->
                                            @if($item->garment_type == 'suit')
                                                @if($item->chest || $item->waist || $item->shoulder_width || $item->sleeve_length || $item->jacket_length)
                                                    <div class="mb-4">
                                                        <h6 class="text-sm font-semibold text-gray-700 mb-2">Jacket</h6>
                                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                            @if($item->chest)<div class="bg-purple-50 rounded-lg p-2 border border-purple-100"><p class="text-xs text-gray-500 mb-1">Chest</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->chest, 2) }}"</p></div>@endif
                                                            @if($item->waist)<div class="bg-purple-50 rounded-lg p-2 border border-purple-100"><p class="text-xs text-gray-500 mb-1">Waist</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->waist, 2) }}"</p></div>@endif
                                                            @if($item->shoulder_width)<div class="bg-purple-50 rounded-lg p-2 border border-purple-100"><p class="text-xs text-gray-500 mb-1">Shoulder Width</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->shoulder_width, 2) }}"</p></div>@endif
                                                            @if($item->sleeve_length)<div class="bg-purple-50 rounded-lg p-2 border border-purple-100"><p class="text-xs text-gray-500 mb-1">Sleeve Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->sleeve_length, 2) }}"</p></div>@endif
                                                            @if($item->jacket_length)<div class="bg-purple-50 rounded-lg p-2 border border-purple-100"><p class="text-xs text-gray-500 mb-1">Jacket Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->jacket_length, 2) }}"</p></div>@endif
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($item->hip || $item->inseam || $item->outseam || $item->thigh || $item->knee || $item->ankle || $item->pant_length)
                                                    <div>
                                                        <h6 class="text-sm font-semibold text-gray-700 mb-2">Pant</h6>
                                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                                            @if($item->hip)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Hip</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->hip, 2) }}"</p></div>@endif
                                                            @if($item->inseam)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Inseam</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->inseam, 2) }}"</p></div>@endif
                                                            @if($item->outseam)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Outseam</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->outseam, 2) }}"</p></div>@endif
                                                            @if($item->thigh)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Thigh</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->thigh, 2) }}"</p></div>@endif
                                                            @if($item->knee)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Knee</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->knee, 2) }}"</p></div>@endif
                                                            @if($item->ankle)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Ankle</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->ankle, 2) }}"</p></div>@endif
                                                            @if($item->pant_length)<div class="bg-indigo-50 rounded-lg p-2 border border-indigo-100"><p class="text-xs text-gray-500 mb-1">Pant Length</p><p class="text-sm font-semibold text-gray-900">{{ number_format($item->pant_length, 2) }}"</p></div>@endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    @endif

                                    @if($item->notes)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-600"><strong>Notes:</strong> {{ $item->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($order->chest || $order->waist || $order->shoulder_width || $order->sleeve_length || $order->shirt_length || $order->jacket_length || $order->neck || $order->armhole || $order->bicep || $order->wrist || $order->hip || $order->inseam || $order->outseam || $order->thigh || $order->knee || $order->ankle || $order->pant_length)
                    <!-- Fallback: Show old measurements format for backward compatibility -->
                    <div class="glass-effect rounded-2xl shadow-2xl p-6 mb-6 animate-fadeInUp" style="animation-delay: 0.3s;">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-ruler-combined text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Measurements</h3>
                                    @if($order->garment_type)
                                        <p class="text-sm text-gray-600">
                                            @if($order->garment_type == 'shirt') 👔 Shirt
                                            @elseif($order->garment_type == 'pant') 👖 Pant
                                            @elseif($order->garment_type == 'suit') 🤵 Suit
                                            @else {{ ucfirst($order->garment_type) }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Shirt Measurements -->
                        @if($order->garment_type == 'shirt' && ($order->chest || $order->waist || $order->shoulder_width || $order->sleeve_length || $order->shirt_length || $order->neck || $order->armhole || $order->bicep || $order->wrist))
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-tshirt text-blue-600 mr-2"></i>Shirt Measurements
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @if($order->chest)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Chest</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->chest, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->waist)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Waist</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->waist, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->shoulder_width)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Shoulder Width</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->shoulder_width, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->sleeve_length)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Sleeve Length</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->sleeve_length, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->shirt_length)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Shirt Length</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->shirt_length, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->neck)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Neck</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->neck, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->armhole)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Armhole</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->armhole, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->bicep)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Bicep</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->bicep, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->wrist)
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                                            <p class="text-xs text-gray-500 mb-1">Wrist</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->wrist, 2) }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Pant Measurements -->
                        @if($order->garment_type == 'pant' && ($order->waist || $order->hip || $order->inseam || $order->outseam || $order->thigh || $order->knee || $order->ankle || $order->pant_length))
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-vest text-green-600 mr-2"></i>Pant Measurements
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @if($order->waist)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Waist</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->waist, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->hip)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Hip</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->hip, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->inseam)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Inseam</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->inseam, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->outseam)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Outseam</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->outseam, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->thigh)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Thigh</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->thigh, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->knee)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Knee</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->knee, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->ankle)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Ankle</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->ankle, 2) }}"</p>
                                        </div>
                                    @endif
                                    @if($order->pant_length)
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <p class="text-xs text-gray-500 mb-1">Pant Length</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ number_format($order->pant_length, 2) }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Suit Measurements -->
                        @if($order->garment_type == 'suit')
                            <!-- Suit Jacket -->
                            @if($order->chest || $order->waist || $order->shoulder_width || $order->sleeve_length || $order->jacket_length)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-vest text-purple-600 mr-2"></i>Suit Jacket
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @if($order->chest)
                                            <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                                                <p class="text-xs text-gray-500 mb-1">Chest</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->chest, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->waist)
                                            <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                                                <p class="text-xs text-gray-500 mb-1">Waist</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->waist, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->shoulder_width)
                                            <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                                                <p class="text-xs text-gray-500 mb-1">Shoulder Width</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->shoulder_width, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->sleeve_length)
                                            <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                                                <p class="text-xs text-gray-500 mb-1">Sleeve Length</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->sleeve_length, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->jacket_length)
                                            <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                                                <p class="text-xs text-gray-500 mb-1">Jacket Length</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->jacket_length, 2) }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Suit Pant -->
                            @if($order->hip || $order->inseam || $order->outseam || $order->thigh || $order->knee || $order->ankle || $order->pant_length)
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-vest text-indigo-600 mr-2"></i>Suit Pant
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @if($order->hip)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Hip</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->hip, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->inseam)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Inseam</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->inseam, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->outseam)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Outseam</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->outseam, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->thigh)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Thigh</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->thigh, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->knee)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Knee</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->knee, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->ankle)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Ankle</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->ankle, 2) }}"</p>
                                            </div>
                                        @endif
                                        @if($order->pant_length)
                                            <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                                                <p class="text-xs text-gray-500 mb-1">Pant Length</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ number_format($order->pant_length, 2) }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif

                <!-- Description -->
                @if($order->description)
                    <div class="glass-effect rounded-2xl shadow-2xl p-6 mb-6 animate-fadeInUp" style="animation-delay: 0.3s;">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                        </h3>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $order->description }}</p>
                    </div>
                @endif

                <!-- Notes -->
                @if($order->notes)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-sticky-note text-indigo-600 mr-2"></i>Notes
                        </h3>
                        <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>