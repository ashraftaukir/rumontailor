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
                            const existingItems = @json($order->items ?? []);

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
                                                    <input type="number" name="items[${itemIndex}][price]" step="0.01" min="0" value="${itemData ? itemData.price : '0'}" required
                                                        class="item-price w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white"
                                                        onchange="calculateTotal()">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                                                </label>
                                                <input type="text" name="items[${itemIndex}][description]" value="${itemData ? (itemData.description || '') : ''}"
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
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][chest]" step="0.01" min="0" value="${itemData ? (itemData.chest || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${itemData ? (itemData.waist || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][shoulder_width]" step="0.01" min="0" value="${itemData ? (itemData.shoulder_width || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][sleeve_length]" step="0.01" min="0" value="${itemData ? (itemData.sleeve_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shirt Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][shirt_length]" step="0.01" min="0" value="${itemData ? (itemData.shirt_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Neck</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][neck]" step="0.01" min="0" value="${itemData ? (itemData.neck || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Armhole</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][armhole]" step="0.01" min="0" value="${itemData ? (itemData.armhole || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Bicep</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][bicep]" step="0.01" min="0" value="${itemData ? (itemData.bicep || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Wrist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][wrist]" step="0.01" min="0" value="${itemData ? (itemData.wrist || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                            </div>

                                            <!-- Pant Measurements -->
                                            <div class="item-pant-measurements-${itemIndex} grid grid-cols-1 md:grid-cols-3 gap-4" style="display: ${itemData && itemData.garment_type === 'pant' ? 'grid' : 'none'};">
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${itemData ? (itemData.waist || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][hip]" step="0.01" min="0" value="${itemData ? (itemData.hip || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][inseam]" step="0.01" min="0" value="${itemData ? (itemData.inseam || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][outseam]" step="0.01" min="0" value="${itemData ? (itemData.outseam || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][thigh]" step="0.01" min="0" value="${itemData ? (itemData.thigh || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][knee]" step="0.01" min="0" value="${itemData ? (itemData.knee || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][ankle]" step="0.01" min="0" value="${itemData ? (itemData.ankle || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                <div><label class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                                    <div class="relative"><input type="number" name="items[${itemIndex}][pant_length]" step="0.01" min="0" value="${itemData ? (itemData.pant_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                            </div>

                                            <!-- Suit Measurements -->
                                            <div class="item-suit-measurements-${itemIndex}" style="display: ${itemData && itemData.garment_type === 'suit' ? 'block' : 'none'};">
                                                <div class="mb-4">
                                                    <h6 class="text-sm font-semibold text-gray-700 mb-2">Jacket</h6>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][chest]" step="0.01" min="0" value="${itemData ? (itemData.chest || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][waist]" step="0.01" min="0" value="${itemData ? (itemData.waist || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][shoulder_width]" step="0.01" min="0" value="${itemData ? (itemData.shoulder_width || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][sleeve_length]" step="0.01" min="0" value="${itemData ? (itemData.sleeve_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Jacket Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][jacket_length]" step="0.01" min="0" value="${itemData ? (itemData.jacket_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="text-sm font-semibold text-gray-700 mb-2">Pant</h6>
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][hip]" step="0.01" min="0" value="${itemData ? (itemData.hip || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][inseam]" step="0.01" min="0" value="${itemData ? (itemData.inseam || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][outseam]" step="0.01" min="0" value="${itemData ? (itemData.outseam || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][thigh]" step="0.01" min="0" value="${itemData ? (itemData.thigh || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][knee]" step="0.01" min="0" value="${itemData ? (itemData.knee || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][ankle]" step="0.01" min="0" value="${itemData ? (itemData.ankle || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
                                                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                                            <div class="relative"><input type="number" name="items[${itemIndex}][pant_length]" step="0.01" min="0" value="${itemData ? (itemData.pant_length || '') : ''}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"><span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span></div></div>
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
                                                placeholder="Additional notes for this item...">${itemData ? (itemData.notes || '') : ''}</textarea>
                                        </div>
                                    </div>
                                `;
                                
                                container.insertAdjacentHTML('beforeend', itemHtml);
                                if (itemData && itemData.garment_type) {
                                    updateItemMeasurements(itemIndex, itemData.garment_type);
                                }
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
                                const measurementsDiv = document.querySelector(`.item-measurements-${itemIndex}`);
                                const shirtDiv = document.querySelector(`.item-shirt-measurements-${itemIndex}`);
                                const pantDiv = document.querySelector(`.item-pant-measurements-${itemIndex}`);
                                const suitDiv = document.querySelector(`.item-suit-measurements-${itemIndex}`);

                                if (garmentType && measurementsDiv) {
                                    measurementsDiv.style.display = 'block';
                                    if (shirtDiv) shirtDiv.style.display = 'none';
                                    if (pantDiv) pantDiv.style.display = 'none';
                                    if (suitDiv) suitDiv.style.display = 'none';

                                    if (garmentType === 'shirt' && shirtDiv) {
                                        shirtDiv.style.display = 'grid';
                                    } else if (garmentType === 'pant' && pantDiv) {
                                        pantDiv.style.display = 'grid';
                                    } else if (garmentType === 'suit' && suitDiv) {
                                        suitDiv.style.display = 'block';
                                    }
                                } else if (measurementsDiv) {
                                    measurementsDiv.style.display = 'none';
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

                            function validateForm() {
                                const items = document.querySelectorAll('.order-item');
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
                            document.addEventListener('DOMContentLoaded', function() {
                                if (existingItems && existingItems.length > 0) {
                                    existingItems.forEach(item => {
                                        addOrderItem(item);
                                    });
                                } else {
                                    addOrderItem();
                                }
                            });
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