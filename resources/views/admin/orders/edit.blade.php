<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order - Admin Dashboard</title>
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

        <main class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="mb-8" style="animation: fadeInUp 0.6s ease-out forwards;">
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 group font-bold">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition"></i>Back to Orders
                    </a>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl blur opacity-50"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-edit text-white text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-2">
                                Edit Order
                            </h2>
                            <p class="text-xl text-gray-600 font-medium">Update order details</p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.2s;">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" id="order-form" onsubmit="return validateForm()">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order Number (Read-only) -->
                            <div class="md:col-span-2">
                                <label for="order_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-hashtag text-indigo-600 mr-2"></i>Order Number
                                </label>
                                <input type="text" name="order_number" id="order_number" value="{{ $order->order_number }}" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-white shadow-sm text-gray-500">
                                <p class="mt-2 text-xs text-gray-500 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>Order number cannot be changed
                                </p>
                            </div>

                            <!-- Customer Selection -->
                            <div class="md:col-span-2">
                                <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-indigo-600 mr-2"></i>Customer *
                                </label>
                                <select name="customer_id" id="customer_id" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} {{ $customer->email ? '(' . $customer->email . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Order Date -->
                            <div>
                                <label for="order_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar text-indigo-600 mr-2"></i>Order Date *
                                </label>
                                <input type="date" name="order_date" id="order_date" value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @error('order_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Status *
                                </label>
                                <select name="status" id="status" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="in_progress" {{ old('status', $order->status) == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Delivery Date -->
                            <div>
                                <label for="delivery_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-truck text-indigo-600 mr-2"></i>Delivery Date
                                </label>
                                <input type="date" name="delivery_date" id="delivery_date" value="{{ old('delivery_date', $order->delivery_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @error('delivery_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Total Amount (Auto-calculated) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-coins text-indigo-600 mr-2"></i>Total Amount (৳)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-500">৳</span>
                                    <input type="text" id="total_amount_display" value="{{ number_format($order->total_amount, 2) }}" readonly
                                        class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 font-bold text-lg">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Auto-calculated from items</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                                    placeholder="Enter order description...">{{ old('description', $order->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sticky-note text-indigo-600 mr-2"></i>Notes
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"
                                    placeholder="Additional notes...">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Order Items Section -->
                        <div class="mt-8 pt-8 border-t-2 border-gray-200">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Order Items</h3>
                                        <p class="text-sm text-gray-600">Add one or more garments to this order</p>
                                    </div>
                                </div>
                                <button type="button" onclick="addOrderItem()" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                                    <i class="fas fa-plus mr-2"></i>Add Item
                                </button>
                            </div>

                            <div id="order-items-container">
                                <!-- Items will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Old Measurements Section (Hidden, kept for backward compatibility) -->
                        <div class="mt-8 pt-8 border-t-2 border-gray-200" id="measurements-section" style="display: none;">
                            <div class="flex items-center mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-ruler-combined text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Measurements</h3>
                                    <p class="text-sm text-gray-600">Enter customer measurements (in inches)</p>
                                </div>
                            </div>

                            <!-- Shirt Measurements -->
                            <div id="shirt-measurements" style="display: {{ old('garment_type', $order->garment_type) == 'shirt' ? 'block' : 'none' }};">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-tshirt text-blue-600 mr-2"></i>Shirt Measurements
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="chest" class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                        <div class="relative">
                                            <input type="number" name="chest" id="chest" step="0.01" min="0" value="{{ old('chest', $order->chest) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                        <div class="relative">
                                            <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist', $order->waist) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="shoulder_width" class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                        <div class="relative">
                                            <input type="number" name="shoulder_width" id="shoulder_width" step="0.01" min="0" value="{{ old('shoulder_width', $order->shoulder_width) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="sleeve_length" class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                        <div class="relative">
                                            <input type="number" name="sleeve_length" id="sleeve_length" step="0.01" min="0" value="{{ old('sleeve_length', $order->sleeve_length) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="shirt_length" class="block text-sm font-medium text-gray-700 mb-1">Shirt Length</label>
                                        <div class="relative">
                                            <input type="number" name="shirt_length" id="shirt_length" step="0.01" min="0" value="{{ old('shirt_length', $order->shirt_length) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="neck" class="block text-sm font-medium text-gray-700 mb-1">Neck</label>
                                        <div class="relative">
                                            <input type="number" name="neck" id="neck" step="0.01" min="0" value="{{ old('neck', $order->neck) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="armhole" class="block text-sm font-medium text-gray-700 mb-1">Armhole</label>
                                        <div class="relative">
                                            <input type="number" name="armhole" id="armhole" step="0.01" min="0" value="{{ old('armhole', $order->armhole) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="bicep" class="block text-sm font-medium text-gray-700 mb-1">Bicep</label>
                                        <div class="relative">
                                            <input type="number" name="bicep" id="bicep" step="0.01" min="0" value="{{ old('bicep', $order->bicep) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="wrist" class="block text-sm font-medium text-gray-700 mb-1">Wrist</label>
                                        <div class="relative">
                                            <input type="number" name="wrist" id="wrist" step="0.01" min="0" value="{{ old('wrist', $order->wrist) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pant Measurements -->
                            <div id="pant-measurements" style="display: {{ old('garment_type', $order->garment_type) == 'pant' ? 'block' : 'none' }};">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-vest text-green-600 mr-2"></i>Pant Measurements
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                        <div class="relative">
                                            <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist', $order->waist) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="hip" class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                        <div class="relative">
                                            <input type="number" name="hip" id="hip" step="0.01" min="0" value="{{ old('hip', $order->hip) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="inseam" class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                        <div class="relative">
                                            <input type="number" name="inseam" id="inseam" step="0.01" min="0" value="{{ old('inseam', $order->inseam) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="outseam" class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                        <div class="relative">
                                            <input type="number" name="outseam" id="outseam" step="0.01" min="0" value="{{ old('outseam', $order->outseam) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="thigh" class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                        <div class="relative">
                                            <input type="number" name="thigh" id="thigh" step="0.01" min="0" value="{{ old('thigh', $order->thigh) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="knee" class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                        <div class="relative">
                                            <input type="number" name="knee" id="knee" step="0.01" min="0" value="{{ old('knee', $order->knee) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="ankle" class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                        <div class="relative">
                                            <input type="number" name="ankle" id="ankle" step="0.01" min="0" value="{{ old('ankle', $order->ankle) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="pant_length" class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                        <div class="relative">
                                            <input type="number" name="pant_length" id="pant_length" step="0.01" min="0" value="{{ old('pant_length', $order->pant_length) }}"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Suit Measurements -->
                            <div id="suit-measurements" style="display: {{ old('garment_type', $order->garment_type) == 'suit' ? 'block' : 'none' }};">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-vest text-purple-600 mr-2"></i>Suit Measurements
                                </h4>
                                
                                <!-- Suit Jacket -->
                                <div class="mb-6">
                                    <h5 class="text-md font-semibold text-gray-700 mb-3">Jacket</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div>
                                            <label for="chest" class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                            <div class="relative">
                                                <input type="number" name="chest" id="chest" step="0.01" min="0" value="{{ old('chest', $order->chest) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                            <div class="relative">
                                                <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist', $order->waist) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="shoulder_width" class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                            <div class="relative">
                                                <input type="number" name="shoulder_width" id="shoulder_width" step="0.01" min="0" value="{{ old('shoulder_width', $order->shoulder_width) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="sleeve_length" class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                            <div class="relative">
                                                <input type="number" name="sleeve_length" id="sleeve_length" step="0.01" min="0" value="{{ old('sleeve_length', $order->sleeve_length) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="jacket_length" class="block text-sm font-medium text-gray-700 mb-1">Jacket Length</label>
                                            <div class="relative">
                                                <input type="number" name="jacket_length" id="jacket_length" step="0.01" min="0" value="{{ old('jacket_length', $order->jacket_length) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Suit Pant -->
                                <div>
                                    <h5 class="text-md font-semibold text-gray-700 mb-3">Pant</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div>
                                            <label for="hip" class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                            <div class="relative">
                                                <input type="number" name="hip" id="hip" step="0.01" min="0" value="{{ old('hip', $order->hip) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="inseam" class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                            <div class="relative">
                                                <input type="number" name="inseam" id="inseam" step="0.01" min="0" value="{{ old('inseam', $order->inseam) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="outseam" class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                            <div class="relative">
                                                <input type="number" name="outseam" id="outseam" step="0.01" min="0" value="{{ old('outseam', $order->outseam) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="thigh" class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                            <div class="relative">
                                                <input type="number" name="thigh" id="thigh" step="0.01" min="0" value="{{ old('thigh', $order->thigh) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="knee" class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                            <div class="relative">
                                                <input type="number" name="knee" id="knee" step="0.01" min="0" value="{{ old('knee', $order->knee) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="ankle" class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                            <div class="relative">
                                                <input type="number" name="ankle" id="ankle" step="0.01" min="0" value="{{ old('ankle', $order->ankle) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="pant_length" class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                            <div class="relative">
                                                <input type="number" name="pant_length" id="pant_length" step="0.01" min="0" value="{{ old('pant_length', $order->pant_length) }}"
                                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JavaScript for Multiple Items -->
                        <script>
                            let itemCounter = 0;
                            @php
                                $existingItemsData = [];
                                if ($order->items) {
                                    $measurementFields = [
                                        'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
                                        'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
                                        'thigh', 'knee', 'ankle', 'pant_length'
                                    ];
                                    
                                    foreach ($order->items as $item) {
                                        // Get raw attributes to ensure we capture all values
                                        $attributes = $item->getAttributes();
                                        
                                        $itemArray = [
                                            'id' => $item->id,
                                            'garment_type' => $item->garment_type,
                                            'price' => $item->price !== null ? (string) $item->price : '',
                                            'description' => $item->description ?? '',
                                            'notes' => $item->notes ?? '',
                                        ];
                                        
                                        // Explicitly include all measurement fields - ensure we get all values
                                        foreach ($measurementFields as $field) {
                                            // Get the attribute value - this handles Laravel's casting
                                            $value = $item->getAttribute($field);
                                            
                                            // Convert to string for JavaScript/JSON
                                            // Handle null, empty string, or false as empty string
                                            if ($value === null || $value === '' || $value === false) {
                                                $itemArray[$field] = '';
                                            } else {
                                                // Convert to string - Laravel's decimal cast returns string already
                                                $itemArray[$field] = (string)$value;
                                            }
                                        }
                                        
                                        $existingItemsData[] = $itemArray;
                                    }
                                }
                            @endphp
                            const existingItems = @json($existingItemsData);
                            
                            console.log('=== EXISTING ITEMS DEBUG ===');
                            console.log('Order ID:', {{ $order->id }});
                            console.log('Items count from backend:', {{ $order->items ? $order->items->count() : 0 }});
                            console.log('Existing items data:', existingItems);
                            console.log('Existing items array length:', existingItems ? existingItems.length : 0);
                            
                            // Debug each item individually - show ALL measurement fields
                            if (existingItems && existingItems.length > 0) {
                                existingItems.forEach((item, idx) => {
                                    console.log(`=== Item ${idx + 1} (${item.garment_type}) - Full Data ===`);
                                    console.log('ID:', item.id);
                                    console.log('Garment Type:', item.garment_type);
                                    console.log('Price:', item.price);
                                    console.log('Description:', item.description);
                                    console.log('Notes:', item.notes);
                                    console.log('--- Shirt Measurements ---');
                                    console.log('  chest:', item.chest, '(type:', typeof item.chest, ')');
                                    console.log('  waist:', item.waist, '(type:', typeof item.waist, ')');
                                    console.log('  shoulder_width:', item.shoulder_width, '(type:', typeof item.shoulder_width, ')');
                                    console.log('  sleeve_length:', item.sleeve_length, '(type:', typeof item.sleeve_length, ')');
                                    console.log('  shirt_length:', item.shirt_length, '(type:', typeof item.shirt_length, ')');
                                    console.log('  neck:', item.neck, '(type:', typeof item.neck, ')');
                                    console.log('  armhole:', item.armhole, '(type:', typeof item.armhole, ')');
                                    console.log('  bicep:', item.bicep, '(type:', typeof item.bicep, ')');
                                    console.log('  wrist:', item.wrist, '(type:', typeof item.wrist, ')');
                                    console.log('--- Pant Measurements ---');
                                    console.log('  hip:', item.hip, '(type:', typeof item.hip, ')');
                                    console.log('  inseam:', item.inseam, '(type:', typeof item.inseam, ')');
                                    console.log('  outseam:', item.outseam, '(type:', typeof item.outseam, ')');
                                    console.log('  thigh:', item.thigh, '(type:', typeof item.thigh, ')');
                                    console.log('  knee:', item.knee, '(type:', typeof item.knee, ')');
                                    console.log('  ankle:', item.ankle, '(type:', typeof item.ankle, ')');
                                    console.log('  pant_length:', item.pant_length, '(type:', typeof item.pant_length, ')');
                                    console.log('--- Full Object ---');
                                    console.log(item);
                                });
                            }
                            
                            // Helper function to safely get field value (handles null, undefined, empty string)
                            function getFieldValue(itemData, field) {
                                if (!itemData) return '';
                                const value = itemData[field];
                                // Handle null, undefined, empty string, or empty array
                                if (value === null || value === undefined || value === '' || (Array.isArray(value) && value.length === 0)) {
                                    return '';
                                }
                                // For numeric values, ensure they're properly formatted
                                if (typeof value === 'number' || (!isNaN(value) && value !== '')) {
                                    return String(value);
                                }
                                return String(value);
                            }

                            function addOrderItem(itemData = null) {
                                const container = document.getElementById('order-items-container');
                                const itemIndex = itemCounter++;
                                const isExisting = itemData !== null;
                                
                                const itemHtml = `
                                    <div class="order-item mb-6 p-6 border-2 border-gray-200 rounded-xl bg-white/50" data-item-index="${itemIndex}">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-lg font-bold text-gray-900 flex items-center">
                                                <i class="fas fa-tshirt text-indigo-600 mr-2"></i>Item #${itemIndex + 1}
                                            </h4>
                                            <button type="button" onclick="removeOrderItem(this)" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white font-bold rounded-lg transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        ${isExisting ? `<input type="hidden" name="items[${itemIndex}][id]" value="${itemData.id}">` : ''}

                                        <!-- Hidden inputs for all measurement fields (always in DOM for form submission) -->
                                        <div style="display: none;">
                                            <input type="hidden" name="items[${itemIndex}][chest]" value="${getFieldValue(itemData, 'chest')}">
                                            <input type="hidden" name="items[${itemIndex}][waist]" value="${getFieldValue(itemData, 'waist')}">
                                            <input type="hidden" name="items[${itemIndex}][shoulder_width]" value="${getFieldValue(itemData, 'shoulder_width')}">
                                            <input type="hidden" name="items[${itemIndex}][sleeve_length]" value="${getFieldValue(itemData, 'sleeve_length')}">
                                            <input type="hidden" name="items[${itemIndex}][shirt_length]" value="${getFieldValue(itemData, 'shirt_length')}">
                                            <input type="hidden" name="items[${itemIndex}][jacket_length]" value="${getFieldValue(itemData, 'jacket_length')}">
                                            <input type="hidden" name="items[${itemIndex}][neck]" value="${getFieldValue(itemData, 'neck')}">
                                            <input type="hidden" name="items[${itemIndex}][armhole]" value="${getFieldValue(itemData, 'armhole')}">
                                            <input type="hidden" name="items[${itemIndex}][bicep]" value="${getFieldValue(itemData, 'bicep')}">
                                            <input type="hidden" name="items[${itemIndex}][wrist]" value="${getFieldValue(itemData, 'wrist')}">
                                            <input type="hidden" name="items[${itemIndex}][hip]" value="${getFieldValue(itemData, 'hip')}">
                                            <input type="hidden" name="items[${itemIndex}][inseam]" value="${getFieldValue(itemData, 'inseam')}">
                                            <input type="hidden" name="items[${itemIndex}][outseam]" value="${getFieldValue(itemData, 'outseam')}">
                                            <input type="hidden" name="items[${itemIndex}][thigh]" value="${getFieldValue(itemData, 'thigh')}">
                                            <input type="hidden" name="items[${itemIndex}][knee]" value="${getFieldValue(itemData, 'knee')}">
                                            <input type="hidden" name="items[${itemIndex}][ankle]" value="${getFieldValue(itemData, 'ankle')}">
                                            <input type="hidden" name="items[${itemIndex}][pant_length]" value="${getFieldValue(itemData, 'pant_length')}">
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-tshirt text-indigo-600 mr-2"></i>Garment Type *
                                                </label>
                                                <select name="items[${itemIndex}][garment_type]" class="item-garment-type w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white" required onchange="updateItemMeasurements(${itemIndex}, this.value)">
                                                    <option value="">Select type</option>
                                                    <option value="shirt" ${itemData && itemData.garment_type === 'shirt' ? 'selected' : ''}>👔 Shirt</option>
                                                    <option value="pant" ${itemData && itemData.garment_type === 'pant' ? 'selected' : ''}>👖 Pant</option>
                                                    <option value="suit" ${itemData && itemData.garment_type === 'suit' ? 'selected' : ''}>🤵 Suit</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-coins text-indigo-600 mr-2"></i>Price (৳) *
                                                </label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-3.5 text-gray-500">৳</span>
                                                    <input type="number" name="items[${itemIndex}][price]" step="0.01" min="0" value="${itemData && itemData.price !== null && itemData.price !== undefined ? itemData.price : '0'}" required
                                                        class="item-price w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                                                        onchange="calculateTotal()">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                                                </label>
                                                <input type="text" name="items[${itemIndex}][description]" value="${getFieldValue(itemData, 'description')}"
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                                                    placeholder="Item description...">
                                            </div>
                                        </div>

                                        <!-- Measurements for this item -->
                                        <div class="item-measurements-${itemIndex} mt-4" style="display: ${itemData && itemData.garment_type ? 'block' : 'none'};">
                                            <h5 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                                <i class="fas fa-ruler-combined text-purple-600 mr-2"></i>Measurements (in inches)
                                            </h5>
                                            
                                            <!-- Shirt Measurements -->
                                            <div class="item-shirt-measurements-${itemIndex} grid grid-cols-1 md:grid-cols-3 gap-4" style="display: ${itemData && itemData.garment_type === 'shirt' ? 'grid' : 'none'};">
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][chest]" step="0.01" min="0" value="${getFieldValue(itemData, 'chest')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'chest', this.value)" oninput="syncMeasurementField(${itemIndex}, 'chest', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${getFieldValue(itemData, 'waist')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'waist', this.value)" oninput="syncMeasurementField(${itemIndex}, 'waist', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][shoulder_width]" step="0.01" min="0" value="${getFieldValue(itemData, 'shoulder_width')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'shoulder_width', this.value)" oninput="syncMeasurementField(${itemIndex}, 'shoulder_width', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][sleeve_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'sleeve_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'sleeve_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'sleeve_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shirt Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][shirt_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'shirt_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'shirt_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'shirt_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Neck</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][neck]" step="0.01" min="0" value="${getFieldValue(itemData, 'neck')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'neck', this.value)" oninput="syncMeasurementField(${itemIndex}, 'neck', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Armhole</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][armhole]" step="0.01" min="0" value="${getFieldValue(itemData, 'armhole')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'armhole', this.value)" oninput="syncMeasurementField(${itemIndex}, 'armhole', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Bicep</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][bicep]" step="0.01" min="0" value="${getFieldValue(itemData, 'bicep')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'bicep', this.value)" oninput="syncMeasurementField(${itemIndex}, 'bicep', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Wrist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][wrist]" step="0.01" min="0" value="${getFieldValue(itemData, 'wrist')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'wrist', this.value)" oninput="syncMeasurementField(${itemIndex}, 'wrist', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                            </div>

                                            <!-- Pant Measurements -->
                                            <div class="item-pant-measurements-${itemIndex} grid grid-cols-1 md:grid-cols-3 gap-4" style="display: ${itemData && itemData.garment_type === 'pant' ? 'grid' : 'none'};">
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${getFieldValue(itemData, 'waist')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'waist', this.value)" oninput="syncMeasurementField(${itemIndex}, 'waist', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][hip]" step="0.01" min="0" value="${getFieldValue(itemData, 'hip')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'hip', this.value)" oninput="syncMeasurementField(${itemIndex}, 'hip', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][inseam]" step="0.01" min="0" value="${getFieldValue(itemData, 'inseam')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'inseam', this.value)" oninput="syncMeasurementField(${itemIndex}, 'inseam', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][outseam]" step="0.01" min="0" value="${getFieldValue(itemData, 'outseam')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'outseam', this.value)" oninput="syncMeasurementField(${itemIndex}, 'outseam', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][thigh]" step="0.01" min="0" value="${getFieldValue(itemData, 'thigh')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'thigh', this.value)" oninput="syncMeasurementField(${itemIndex}, 'thigh', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][knee]" step="0.01" min="0" value="${getFieldValue(itemData, 'knee')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'knee', this.value)" oninput="syncMeasurementField(${itemIndex}, 'knee', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][ankle]" step="0.01" min="0" value="${getFieldValue(itemData, 'ankle')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'ankle', this.value)" oninput="syncMeasurementField(${itemIndex}, 'ankle', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][pant_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'pant_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'pant_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'pant_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                            </div>

                                            <!-- Suit Measurements -->
                                            <div class="item-suit-measurements-${itemIndex}" style="display: ${itemData && itemData.garment_type === 'suit' ? 'block' : 'none'};">
                                                <div class="mb-4">
                                                    <h6 class="text-sm font-semibold text-gray-700 mb-2">Jacket</h6>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][chest]" step="0.01" min="0" value="${getFieldValue(itemData, 'chest')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'chest', this.value)" oninput="syncMeasurementField(${itemIndex}, 'chest', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${getFieldValue(itemData, 'waist')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'waist', this.value)" oninput="syncMeasurementField(${itemIndex}, 'waist', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][shoulder_width]" step="0.01" min="0" value="${getFieldValue(itemData, 'shoulder_width')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'shoulder_width', this.value)" oninput="syncMeasurementField(${itemIndex}, 'shoulder_width', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][sleeve_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'sleeve_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'sleeve_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'sleeve_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Jacket Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][jacket_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'jacket_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'jacket_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'jacket_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="text-sm font-semibold text-gray-700 mb-2">Pant</h6>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][hip]" step="0.01" min="0" value="${getFieldValue(itemData, 'hip')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'hip', this.value)" oninput="syncMeasurementField(${itemIndex}, 'hip', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][inseam]" step="0.01" min="0" value="${getFieldValue(itemData, 'inseam')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'inseam', this.value)" oninput="syncMeasurementField(${itemIndex}, 'inseam', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][outseam]" step="0.01" min="0" value="${getFieldValue(itemData, 'outseam')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'outseam', this.value)" oninput="syncMeasurementField(${itemIndex}, 'outseam', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][thigh]" step="0.01" min="0" value="${getFieldValue(itemData, 'thigh')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'thigh', this.value)" oninput="syncMeasurementField(${itemIndex}, 'thigh', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][knee]" step="0.01" min="0" value="${getFieldValue(itemData, 'knee')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'knee', this.value)" oninput="syncMeasurementField(${itemIndex}, 'knee', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][ankle]" step="0.01" min="0" value="${getFieldValue(itemData, 'ankle')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'ankle', this.value)" oninput="syncMeasurementField(${itemIndex}, 'ankle', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][pant_length]" step="0.01" min="0" value="${getFieldValue(itemData, 'pant_length')}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" onchange="syncMeasurementField(${itemIndex}, 'pant_length', this.value)" oninput="syncMeasurementField(${itemIndex}, 'pant_length', this.value)"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-sticky-note text-indigo-600 mr-2"></i>Item Notes
                                            </label>
                                            <textarea name="items[${itemIndex}][notes]" rows="2"
                                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                                                placeholder="Additional notes for this item...">${getFieldValue(itemData, 'notes')}</textarea>
                                        </div>
                                    </div>
                                `;
                                
                                container.insertAdjacentHTML('beforeend', itemHtml);
                                
                                // Use setTimeout to ensure DOM is ready before updating measurements
                                setTimeout(() => {
                                    if (itemData && itemData.garment_type) {
                                        console.log(`Calling updateItemMeasurements for item ${itemIndex} with garment_type: ${itemData.garment_type}`);
                                        updateItemMeasurements(itemIndex, itemData.garment_type);
                                        
                                        // Debug: Check if measurements are visible after update
                                        setTimeout(() => {
                                            const itemContainer = document.querySelector(`.order-item[data-item-index="${itemIndex}"]`);
                                            if (itemContainer) {
                                                const measurementsDiv = itemContainer.querySelector(`.item-measurements-${itemIndex}`);
                                                const shirtDiv = itemContainer.querySelector(`.item-shirt-measurements-${itemIndex}`);
                                                console.log(`After updateItemMeasurements for item ${itemIndex}:`, {
                                                    measurementsDivVisible: measurementsDiv ? measurementsDiv.style.display : 'not found',
                                                    shirtDivVisible: shirtDiv ? shirtDiv.style.display : 'not found',
                                                    shirtDivExists: !!shirtDiv
                                                });
                                                
                                                // Check if shirt measurement inputs have values
                                                if (shirtDiv && itemData.garment_type === 'shirt') {
                                                    const chestInput = shirtDiv.querySelector('input[name*="[chest]"]');
                                                    const shirtLengthInput = shirtDiv.querySelector('input[name*="[shirt_length]"]');
                                                    const neckInput = shirtDiv.querySelector('input[name*="[neck]"]');
                                                    console.log(`Shirt input values for item ${itemIndex}:`, {
                                                        chest: chestInput ? chestInput.value : 'input not found',
                                                        shirt_length: shirtLengthInput ? shirtLengthInput.value : 'input not found',
                                                        neck: neckInput ? neckInput.value : 'input not found'
                                                    });
                                                }
                                            }
                                        }, 50);
                                    }
                                }, 10);
                                
                                calculateTotal();
                            }

                            function removeOrderItem(button) {
                                const item = button.closest('.order-item');
                                item.remove();
                                renumberItems();
                                calculateTotal();
                            }

                            function renumberItems() {
                                const items = document.querySelectorAll('.order-item');
                                items.forEach((item, index) => {
                                    const header = item.querySelector('h4');
                                    if (header) {
                                        header.innerHTML = `<i class="fas fa-tshirt text-indigo-600 mr-2"></i>Item #${index + 1}`;
                                    }
                                });
                            }

                            function updateItemMeasurements(itemIndex, garmentType) {
                                // Find the item container first
                                const itemContainer = document.querySelector(`.order-item[data-item-index="${itemIndex}"]`);
                                if (!itemContainer) {
                                    console.warn(`Item container not found for index ${itemIndex}`);
                                    return;
                                }
                                
                                const measurementsDiv = itemContainer.querySelector(`.item-measurements-${itemIndex}`);
                                const shirtDiv = itemContainer.querySelector(`.item-shirt-measurements-${itemIndex}`);
                                const pantDiv = itemContainer.querySelector(`.item-pant-measurements-${itemIndex}`);
                                const suitDiv = itemContainer.querySelector(`.item-suit-measurements-${itemIndex}`);

                                console.log(`Updating measurements for item ${itemIndex}, garment type: ${garmentType}`, {
                                    measurementsDiv: !!measurementsDiv,
                                    shirtDiv: !!shirtDiv,
                                    pantDiv: !!pantDiv,
                                    suitDiv: !!suitDiv
                                });

                                if (garmentType && measurementsDiv) {
                                    measurementsDiv.style.display = 'block';
                                    if (shirtDiv) shirtDiv.style.display = 'none';
                                    if (pantDiv) pantDiv.style.display = 'none';
                                    if (suitDiv) suitDiv.style.display = 'none';

                                    if (garmentType === 'shirt' && shirtDiv) {
                                        shirtDiv.style.display = 'grid';
                                        console.log(`Showing shirt measurements for item ${itemIndex}`);
                                    } else if (garmentType === 'pant' && pantDiv) {
                                        pantDiv.style.display = 'grid';
                                        console.log(`Showing pant measurements for item ${itemIndex}`);
                                    } else if (garmentType === 'suit' && suitDiv) {
                                        suitDiv.style.display = 'block';
                                        console.log(`Showing suit measurements for item ${itemIndex}`);
                                    }
                                } else {
                                    if (!measurementsDiv) {
                                        console.warn(`Measurements div not found for item ${itemIndex}`);
                                    }
                                    if (measurementsDiv) {
                                        measurementsDiv.style.display = 'none';
                                    }
                                }
                            }

                            function calculateTotal() {
                                const priceInputs = document.querySelectorAll('.item-price');
                                let total = 0;
                                priceInputs.forEach(input => {
                                    total += parseFloat(input.value) || 0;
                                });
                                document.getElementById('total_amount_display').value = total.toFixed(2);
                            }

                            // Sync measurement field value to hidden input
                            function syncMeasurementField(itemIndex, field, value) {
                                // Find the item container - try multiple methods
                                let itemContainer = document.querySelector(`.order-item[data-item-index="${itemIndex}"]`);
                                
                                if (!itemContainer) {
                                    // Try to find by garment type selector
                                    const garmentSelect = document.querySelector(`select[name="items[${itemIndex}][garment_type]"]`);
                                    if (garmentSelect) {
                                        itemContainer = garmentSelect.closest('.order-item');
                                    }
                                }
                                
                                if (!itemContainer) {
                                    // Try to find by any input with this item index
                                    const anyInput = document.querySelector(`input[name="items[${itemIndex}][garment_type]"]`);
                                    if (anyInput) {
                                        itemContainer = anyInput.closest('.order-item');
                                    }
                                }
                                
                                if (itemContainer) {
                                    // Find the hidden input in the hidden inputs section (the one from template)
                                    const hiddenInputsSection = itemContainer.querySelector('div[style*="display: none"]');
                                    let targetHiddenInput = null;
                                    
                                    if (hiddenInputsSection) {
                                        targetHiddenInput = hiddenInputsSection.querySelector(`input[type="hidden"][name="items[${itemIndex}][${field}]"]`);
                                    }
                                    
                                    // If not found in hidden section, find any hidden input with this name
                                    if (!targetHiddenInput) {
                                        const allHiddenInputs = itemContainer.querySelectorAll(`input[type="hidden"][name="items[${itemIndex}][${field}]"]`);
                                        if (allHiddenInputs.length > 0) {
                                            targetHiddenInput = allHiddenInputs[0];
                                        }
                                    }
                                    
                                    if (targetHiddenInput) {
                                        // Update the hidden input
                                        targetHiddenInput.value = value || '';
                                        console.log(`Synced ${field} for item ${itemIndex}: ${value || '(empty)'}`);
                                        
                                        // Remove any duplicate hidden inputs (except the one we just updated)
                                        const allHiddenInputs = itemContainer.querySelectorAll(`input[type="hidden"][name="items[${itemIndex}][${field}]"]`);
                                        for (let i = 0; i < allHiddenInputs.length; i++) {
                                            if (allHiddenInputs[i] !== targetHiddenInput) {
                                                allHiddenInputs[i].remove();
                                            }
                                        }
                                    } else {
                                        // No hidden input exists, create one in the hidden section
                                        if (!hiddenInputsSection) {
                                            // Create hidden section if it doesn't exist
                                            const newHiddenSection = document.createElement('div');
                                            newHiddenSection.style.display = 'none';
                                            itemContainer.insertBefore(newHiddenSection, itemContainer.querySelector('.grid'));
                                        }
                                        
                                        const hiddenField = document.createElement('input');
                                        hiddenField.type = 'hidden';
                                        hiddenField.name = `items[${itemIndex}][${field}]`;
                                        hiddenField.value = value || '';
                                        (hiddenInputsSection || itemContainer).appendChild(hiddenField);
                                        console.log(`Created hidden input for ${field} in item ${itemIndex}: ${value || '(empty)'}`);
                                    }
                                } else {
                                    console.warn(`Could not find item container for index ${itemIndex}`);
                                }
                            }

                            // Ensure all measurement fields are included in form submission
                            function ensureAllMeasurementFields() {
                                const items = document.querySelectorAll('.order-item');
                                const measurementFields = [
                                    'chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length',
                                    'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam',
                                    'thigh', 'knee', 'ankle', 'pant_length'
                                ];
                                
                                items.forEach((item) => {
                                    // Extract the actual item index from the first form field in this item
                                    const firstInput = item.querySelector('input[name^="items["]');
                                    if (!firstInput) return;
                                    
                                    // Extract index from name like "items[0][garment_type]" -> 0
                                    const nameMatch = firstInput.name.match(/items\[(\d+)\]/);
                                    if (!nameMatch) return;
                                    
                                    const itemIndex = parseInt(nameMatch[1]);
                                    
                                    measurementFields.forEach(field => {
                                        const fieldName = `items[${itemIndex}][${field}]`;
                                        // Check if field exists
                                        let fieldInput = item.querySelector(`input[name="${fieldName}"]`);
                                        
                                        if (!fieldInput) {
                                            // Create hidden input if field doesn't exist
                                            const hiddenInput = document.createElement('input');
                                            hiddenInput.type = 'hidden';
                                            hiddenInput.name = fieldName;
                                            hiddenInput.value = '';
                                            item.appendChild(hiddenInput);
                                        } else if (fieldInput.value === '' && fieldInput.type !== 'hidden') {
                                            // Ensure empty values are explicitly set
                                            fieldInput.value = '';
                                        }
                                    });
                                });
                            }

                            function validateForm() {
                                // CRITICAL: Do final sync BEFORE ensureAllMeasurementFields
                                // This ensures we capture values from visible inputs before they're removed
                                console.log('=== FINAL SYNC BEFORE SUBMISSION ===');
                                const items = document.querySelectorAll('.order-item');
                                const measurementFields = ['chest', 'waist', 'shoulder_width', 'sleeve_length', 'shirt_length', 'jacket_length', 'neck', 'armhole', 'bicep', 'wrist', 'hip', 'inseam', 'outseam', 'thigh', 'knee', 'ankle', 'pant_length'];
                                
                                items.forEach((item) => {
                                    const firstInput = item.querySelector('input[name^="items["]');
                                    if (firstInput) {
                                        const nameMatch = firstInput.name.match(/items\[(\d+)\]/);
                                        if (nameMatch) {
                                            const itemIndex = parseInt(nameMatch[1]);
                                            
                                            // Get garment type to determine which measurement section is visible
                                            const garmentTypeSelect = item.querySelector(`select[name="items[${itemIndex}][garment_type]"]`);
                                            const garmentType = garmentTypeSelect ? garmentTypeSelect.value : '';
                                            
                                            // Final sync: Check all fields one more time
                                            measurementFields.forEach(field => {
                                                const fieldName = `items[${itemIndex}][${field}]`;
                                                
                                                // Find ALL inputs with this name (both visible and hidden, regardless of display state)
                                                const allInputs = item.querySelectorAll(`input[name="${fieldName}"]`);
                                                let value = '';
                                                let correctVisibleInput = null;
                                                
                                                // Step 1: Find the correct visible input based on garment type
                                                // For fields that appear in multiple sections (like waist), we need the one in the visible section
                                                allInputs.forEach(input => {
                                                    if (input.type === 'number') {
                                                        const inputValue = input.value || '';
                                                        
                                                        // Determine which section this input belongs to
                                                        const isInShirtSection = input.closest('.item-shirt-measurements-' + itemIndex) !== null;
                                                        const isInPantSection = input.closest('.item-pant-measurements-' + itemIndex) !== null;
                                                        const isInSuitSection = input.closest('.item-suit-measurements-' + itemIndex) !== null;
                                                        
                                                        // Check if this input is in the correct visible section based on garment type
                                                        let isCorrectSection = false;
                                                        if (garmentType === 'shirt' && isInShirtSection) {
                                                            isCorrectSection = true;
                                                        } else if (garmentType === 'pant' && isInPantSection) {
                                                            isCorrectSection = true;
                                                        } else if (garmentType === 'suit' && isInSuitSection) {
                                                            isCorrectSection = true;
                                                        }
                                                        
                                                        // Also check if the input is actually visible in the DOM
                                                        const isActuallyVisible = input.offsetParent !== null;
                                                        
                                                        // Use this input if it's in the correct section AND visible
                                                        if (isCorrectSection && isActuallyVisible) {
                                                            correctVisibleInput = input;
                                                            value = inputValue;
                                                            console.log(`Final sync: Found value in correct visible input items[${itemIndex}][${field}] = "${value}" (garment: ${garmentType})`);
                                                        }
                                                    }
                                                });
                                                
                                                // Step 2: If no correct visible input found, try to find any visible input with a value
                                                if (!correctVisibleInput || value === '') {
                                                    allInputs.forEach(input => {
                                                        if (input.type === 'number' && input.offsetParent !== null) {
                                                            const inputValue = input.value || '';
                                                            if (inputValue !== '' && value === '') {
                                                                correctVisibleInput = input;
                                                                value = inputValue;
                                                                console.log(`Final sync: Found value in any visible input items[${itemIndex}][${field}] = "${value}"`);
                                                            }
                                                        }
                                                    });
                                                }
                                                
                                                // Second priority: If no visible number input value found, check existing hidden input
                                                if (value === '' && correctVisibleInput === null) {
                                                    allInputs.forEach(input => {
                                                        if (input.type === 'hidden' && input.value && input.value !== '') {
                                                            value = input.value;
                                                            console.log(`Final sync: Using existing hidden value items[${itemIndex}][${field}] = "${value}"`);
                                                        }
                                                    });
                                                }
                                                
                                                // Find the hidden input in the hidden inputs section (the one from template)
                                                const hiddenInputsSection = item.querySelector('div[style*="display: none"]');
                                                let targetHiddenInput = null;
                                                
                                                if (hiddenInputsSection) {
                                                    targetHiddenInput = hiddenInputsSection.querySelector(`input[type="hidden"][name="${fieldName}"]`);
                                                }
                                                
                                                // If not found in hidden section, find any hidden input with this name
                                                if (!targetHiddenInput) {
                                                    const allHiddenInputs = item.querySelectorAll(`input[type="hidden"][name="${fieldName}"]`);
                                                    if (allHiddenInputs.length > 0) {
                                                        targetHiddenInput = allHiddenInputs[0];
                                                    }
                                                }
                                                
                                                if (targetHiddenInput) {
                                                    // Update the hidden input
                                                    targetHiddenInput.value = value;
                                                    console.log(`Final sync: Updated hidden input items[${itemIndex}][${field}] = "${value}"`);
                                                    
                                                    // Remove any duplicate hidden inputs (except the one we just updated)
                                                    const allHiddenInputs = item.querySelectorAll(`input[type="hidden"][name="${fieldName}"]`);
                                                    for (let i = 0; i < allHiddenInputs.length; i++) {
                                                        if (allHiddenInputs[i] !== targetHiddenInput) {
                                                            allHiddenInputs[i].remove();
                                                        }
                                                    }
                                                } else {
                                                    // No hidden input exists, create one in the hidden section
                                                    if (!hiddenInputsSection) {
                                                        // Create hidden section if it doesn't exist
                                                        const newHiddenSection = document.createElement('div');
                                                        newHiddenSection.style.display = 'none';
                                                        const firstGrid = item.querySelector('.grid');
                                                        if (firstGrid) {
                                                            item.insertBefore(newHiddenSection, firstGrid);
                                                        } else {
                                                            item.appendChild(newHiddenSection);
                                                        }
                                                    }
                                                    
                                                    const hiddenInput = document.createElement('input');
                                                    hiddenInput.type = 'hidden';
                                                    hiddenInput.name = fieldName;
                                                    hiddenInput.value = value;
                                                    (hiddenInputsSection || item).appendChild(hiddenInput);
                                                    console.log(`Final sync: Created hidden input items[${itemIndex}][${field}] = "${value}"`);
                                                }
                                                
                                                // Step 3: Remove ALL number inputs for this field to avoid duplicate submission
                                                // The hidden input will be submitted instead
                                                allInputs.forEach(input => {
                                                    if (input.type === 'number') {
                                                        input.remove();
                                                    }
                                                });
                                            });
                                        }
                                    }
                                });
                                
                                // Now run ensureAllMeasurementFields as a backup
                                console.log('=== RUNNING ensureAllMeasurementFields AS BACKUP ===');
                                ensureAllMeasurementFields();
                                
                                // Re-check items after sync (reuse the items variable from above)
                                if (items.length === 0) {
                                    alert('Please add at least one item to the order.');
                                    return false;
                                }
                                
                                let hasValidItem = false;
                                items.forEach(item => {
                                    const garmentType = item.querySelector('.item-garment-type').value;
                                    const price = item.querySelector('.item-price').value;
                                    if (garmentType && price && parseFloat(price) > 0) {
                                        hasValidItem = true;
                                    }
                                });
                                
                                if (!hasValidItem) {
                                    alert('Please add at least one valid item with garment type and price.');
                                    return false;
                                }
                                
                                return true;
                            }

                            // Load existing items on page load
                            function loadExistingItems() {
                                const container = document.getElementById('order-items-container');
                                if (!container) {
                                    console.error('Order items container not found!');
                                    return;
                                }
                                
                                console.log('Loading existing items:', existingItems);
                                console.log('Existing items count:', existingItems ? existingItems.length : 0);
                                
                                if (existingItems && existingItems.length > 0) {
                                    existingItems.forEach((item, index) => {
                                        console.log(`Loading item ${index}:`, item);
                                        addOrderItem(item);
                                    });
                                } else {
                                    console.log('No existing items found');
                                }
                            }

                            // Execute when DOM is ready
                            function initPage() {
                                // Wait a tiny bit to ensure all DOM is ready
                                setTimeout(function() {
                                    loadExistingItems();
                                }, 100);
                            }

                            // Execute immediately if DOM is ready, otherwise wait for DOMContentLoaded
                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', initPage);
                            } else {
                                // DOM is already loaded
                                initPage();
                            }
                        </script>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.orders.index') }}" class="px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-white shadow-sm transition">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 text-white font-medium rounded-lg shadow-lg hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>