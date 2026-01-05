<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Details - Admin Dashboard</title>
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
                            <a href="{{ route('admin.customers.index') }}" class="group px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/50 hover:shadow-xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-users mr-2 group-hover:rotate-12 transition"></i>Customers
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
                <div class="mb-8 flex justify-between items-center animate-fadeInUp">
                    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group font-bold">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition"></i>Back to Customers
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Customer
                    </a>
                </div>

                <!-- Customer Info Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8 mb-6 animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl blur opacity-50"></div>
                            <div class="relative w-20 h-20 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center text-white font-black text-3xl shadow-lg">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-2">
                                {{ $customer->name }}
                            </h2>
                            <p class="text-lg text-gray-600 font-medium">Customer Information</p>
                        </div>
                    </div>
                    
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="bg-white/50 rounded-xl p-4">
                            <dt class="text-sm font-bold text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-user text-indigo-600 mr-2"></i>Name
                            </dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $customer->name }}</dd>
                        </div>
                        <div class="bg-white/50 rounded-xl p-4">
                            <dt class="text-sm font-bold text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-envelope text-indigo-600 mr-2"></i>Email
                            </dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $customer->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white/50 rounded-xl p-4">
                            <dt class="text-sm font-bold text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-phone text-indigo-600 mr-2"></i>Phone
                            </dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $customer->phone ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white/50 rounded-xl p-4">
                            <dt class="text-sm font-bold text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>Address
                            </dt>
                            <dd class="text-lg font-bold text-gray-900">{{ $customer->address ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white/50 rounded-xl p-4">
                            <dt class="text-sm font-bold text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-shopping-bag text-indigo-600 mr-2"></i>Total Orders
                            </dt>
                            <dd class="text-lg font-black text-indigo-600">{{ $customer->orders->count() }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Orders Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8 animate-fadeInUp" style="animation-delay: 0.4s;">
                    <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <i class="fas fa-shopping-bag text-white"></i>
                        </div>
                        Orders
                    </h3>
                    @if($customer->orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-2 text-indigo-600"></i>Order Number
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
                                        <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-cog mr-2 text-indigo-600"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/50 divide-y divide-gray-200">
                                    @foreach($customer->orders as $order)
                                        <tr class="hover:bg-indigo-50/50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-black text-indigo-600">{{ $order->order_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                                                {{ $order->order_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-black shadow-md
                                                    @if($order->status == 'completed') bg-gradient-to-r from-green-400 to-green-600 text-white
                                                    @elseif($order->status == 'in_progress') bg-gradient-to-r from-blue-400 to-blue-600 text-white
                                                    @elseif($order->status == 'delivered') bg-gradient-to-r from-purple-400 to-purple-600 text-white
                                                    @elseif($order->status == 'cancelled') bg-gradient-to-r from-red-400 to-red-600 text-white
                                                    @else bg-gradient-to-r from-yellow-400 to-orange-500 text-white
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-900">৳{{ number_format($order->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800 font-bold group">
                                                    View <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                            </div>
                            <p class="text-lg text-gray-600 font-medium">No orders found for this customer.</p>
                        </div>
                    @endif
                </div>

                <!-- Customer Measurements Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8 mt-6 animate-fadeInUp" style="animation-delay: 0.6s;">
                    <h3 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <i class="fas fa-ruler-combined text-white"></i>
                        </div>
                        Customer Measurements
                    </h3>
                    @if($customer->measurements->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            @php
                                $shirtMeasurement = $customer->measurements->where('garment_type', 'shirt')->first();
                                $pantMeasurement = $customer->measurements->where('garment_type', 'pant')->first();
                                $suitMeasurement = $customer->measurements->where('garment_type', 'suit')->first();
                            @endphp

                            <!-- Shirt Measurements -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200 shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-black text-indigo-700 flex items-center">
                                        <i class="fas fa-tshirt mr-2 text-indigo-600"></i>Shirt
                                    </h4>
                                    @if($shirtMeasurement)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>Saved
                                        </span>
                                    @endif
                                </div>
                                @if($shirtMeasurement)
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Chest</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->chest ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Waist</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->waist ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Shoulder</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->shoulder_width ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Sleeve</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->sleeve_length ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Length</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->shirt_length ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Neck</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->neck ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Armhole</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->armhole ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Bicep</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->bicep ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Wrist</p>
                                                <p class="text-sm font-black text-gray-900">{{ $shirtMeasurement->wrist ?? 'N/A' }}"</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-ruler text-gray-300 text-3xl mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">No measurements saved</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Pant Measurements -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border-2 border-purple-200 shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-black text-purple-700 flex items-center">
                                        <i class="fas fa-vest mr-2 text-purple-600"></i>Pant
                                    </h4>
                                    @if($pantMeasurement)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>Saved
                                        </span>
                                    @endif
                                </div>
                                @if($pantMeasurement)
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Waist</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->waist ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Hip</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->hip ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Inseam</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->inseam ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Outseam</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->outseam ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Thigh</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->thigh ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Knee</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->knee ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Ankle</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->ankle ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Length</p>
                                                <p class="text-sm font-black text-gray-900">{{ $pantMeasurement->pant_length ?? 'N/A' }}"</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-ruler text-gray-300 text-3xl mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">No measurements saved</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Suit Measurements -->
                            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border-2 border-emerald-200 shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-black text-emerald-700 flex items-center">
                                        <i class="fas fa-vest mr-2 text-emerald-600"></i>Suit
                                    </h4>
                                    @if($suitMeasurement)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>Saved
                                        </span>
                                    @endif
                                </div>
                                @if($suitMeasurement)
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Chest</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->chest ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Waist</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->waist ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Shoulder</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->shoulder_width ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Sleeve</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->sleeve_length ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Jacket Length</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->jacket_length ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Hip</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->hip ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Inseam</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->inseam ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Outseam</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->outseam ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Thigh</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->thigh ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Knee</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->knee ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Ankle</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->ankle ?? 'N/A' }}"</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-600">Pant Length</p>
                                                <p class="text-sm font-black text-gray-900">{{ $suitMeasurement->pant_length ?? 'N/A' }}"</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-ruler text-gray-300 text-3xl mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">No measurements saved</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <i class="fas fa-ruler-combined text-gray-400 text-4xl"></i>
                            </div>
                            <p class="text-lg text-gray-600 font-medium">No measurements saved for this customer yet.</p>
                            <p class="text-sm text-gray-500 mt-2">Measurements will be saved automatically when orders are created.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
