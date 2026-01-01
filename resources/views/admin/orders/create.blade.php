<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Order - Admin Dashboard</title>
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
                            <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl blur opacity-50"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-plus text-white text-2xl"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-2">
                                Create New Order
                            </h2>
                            <p class="text-xl text-gray-600 font-medium">Fill in the details to create a new order</p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); animation: fadeInUp 0.6s ease-out forwards; animation-delay: 0.2s;">
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Selection -->
                            <div class="md:col-span-2">
                                <label for="customer_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user text-indigo-600 mr-2"></i>Customer *
                                </label>
                                <select name="customer_id" id="customer_id" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
                                    <option value="">Select a customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
                                <input type="date" name="order_date" id="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
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
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-coins text-indigo-600 mr-2"></i>Total Amount (৳) *
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-500">৳</span>
                                    <input type="number" name="total_amount" id="total_amount" step="0.01" min="0" value="{{ old('total_amount') }}" required
                                        class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
                                </div>
                                @error('total_amount')
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
                                <input type="date" name="delivery_date" id="delivery_date" value="{{ old('delivery_date') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
                                @error('delivery_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Garment Type -->
                            <div>
                                <label for="garment_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tshirt text-indigo-600 mr-2"></i>Garment Type *
                                </label>
                                <select name="garment_type" id="garment_type" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm">
                                    <option value="">Select garment type</option>
                                    <option value="shirt" {{ old('garment_type') == 'shirt' ? 'selected' : '' }}>👔 Shirt</option>
                                    <option value="pant" {{ old('garment_type') == 'pant' ? 'selected' : '' }}>👖 Pant</option>
                                    <option value="suit" {{ old('garment_type') == 'suit' ? 'selected' : '' }}>🤵 Suit</option>
                                </select>
                                @error('garment_type')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                                </label>
                                <textarea name="description" id="description" rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none bg-white shadow-sm"
                                    placeholder="Enter order description...">{{ old('description') }}</textarea>
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
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none bg-white shadow-sm"
                                    placeholder="Additional notes...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Measurements Section -->
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
                            <div id="shirt-measurements" style="display: none;">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-tshirt text-blue-600 mr-2"></i>Shirt Measurements
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="chest" class="block text-sm font-medium text-gray-700 mb-1">Chest</label>
                                        <div class="relative">
                                            <input type="number" name="chest" id="chest" step="0.01" min="0" value="{{ old('chest') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                        <div class="relative">
                                            <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="shoulder_width" class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                        <div class="relative">
                                            <input type="number" name="shoulder_width" id="shoulder_width" step="0.01" min="0" value="{{ old('shoulder_width') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="sleeve_length" class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                        <div class="relative">
                                            <input type="number" name="sleeve_length" id="sleeve_length" step="0.01" min="0" value="{{ old('sleeve_length') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="shirt_length" class="block text-sm font-medium text-gray-700 mb-1">Shirt Length</label>
                                        <div class="relative">
                                            <input type="number" name="shirt_length" id="shirt_length" step="0.01" min="0" value="{{ old('shirt_length') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="neck" class="block text-sm font-medium text-gray-700 mb-1">Neck</label>
                                        <div class="relative">
                                            <input type="number" name="neck" id="neck" step="0.01" min="0" value="{{ old('neck') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="armhole" class="block text-sm font-medium text-gray-700 mb-1">Armhole</label>
                                        <div class="relative">
                                            <input type="number" name="armhole" id="armhole" step="0.01" min="0" value="{{ old('armhole') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="bicep" class="block text-sm font-medium text-gray-700 mb-1">Bicep</label>
                                        <div class="relative">
                                            <input type="number" name="bicep" id="bicep" step="0.01" min="0" value="{{ old('bicep') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="wrist" class="block text-sm font-medium text-gray-700 mb-1">Wrist</label>
                                        <div class="relative">
                                            <input type="number" name="wrist" id="wrist" step="0.01" min="0" value="{{ old('wrist') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pant Measurements -->
                            <div id="pant-measurements" style="display: none;">
                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-vest text-green-600 mr-2"></i>Pant Measurements
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div>
                                        <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                        <div class="relative">
                                            <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="hip" class="block text-sm font-medium text-gray-700 mb-1">Hip</label>
                                        <div class="relative">
                                            <input type="number" name="hip" id="hip" step="0.01" min="0" value="{{ old('hip') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="inseam" class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                        <div class="relative">
                                            <input type="number" name="inseam" id="inseam" step="0.01" min="0" value="{{ old('inseam') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="outseam" class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                        <div class="relative">
                                            <input type="number" name="outseam" id="outseam" step="0.01" min="0" value="{{ old('outseam') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="thigh" class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                        <div class="relative">
                                            <input type="number" name="thigh" id="thigh" step="0.01" min="0" value="{{ old('thigh') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="knee" class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                        <div class="relative">
                                            <input type="number" name="knee" id="knee" step="0.01" min="0" value="{{ old('knee') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="ankle" class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                        <div class="relative">
                                            <input type="number" name="ankle" id="ankle" step="0.01" min="0" value="{{ old('ankle') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="pant_length" class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                        <div class="relative">
                                            <input type="number" name="pant_length" id="pant_length" step="0.01" min="0" value="{{ old('pant_length') }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Suit Measurements -->
                            <div id="suit-measurements" style="display: none;">
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
                                                <input type="number" name="chest" id="chest" step="0.01" min="0" value="{{ old('chest') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="waist" class="block text-sm font-medium text-gray-700 mb-1">Waist</label>
                                            <div class="relative">
                                                <input type="number" name="waist" id="waist" step="0.01" min="0" value="{{ old('waist') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="shoulder_width" class="block text-sm font-medium text-gray-700 mb-1">Shoulder Width</label>
                                            <div class="relative">
                                                <input type="number" name="shoulder_width" id="shoulder_width" step="0.01" min="0" value="{{ old('shoulder_width') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="sleeve_length" class="block text-sm font-medium text-gray-700 mb-1">Sleeve Length</label>
                                            <div class="relative">
                                                <input type="number" name="sleeve_length" id="sleeve_length" step="0.01" min="0" value="{{ old('sleeve_length') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="jacket_length" class="block text-sm font-medium text-gray-700 mb-1">Jacket Length</label>
                                            <div class="relative">
                                                <input type="number" name="jacket_length" id="jacket_length" step="0.01" min="0" value="{{ old('jacket_length') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                                                <input type="number" name="hip" id="hip" step="0.01" min="0" value="{{ old('hip') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="inseam" class="block text-sm font-medium text-gray-700 mb-1">Inseam</label>
                                            <div class="relative">
                                                <input type="number" name="inseam" id="inseam" step="0.01" min="0" value="{{ old('inseam') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="outseam" class="block text-sm font-medium text-gray-700 mb-1">Outseam</label>
                                            <div class="relative">
                                                <input type="number" name="outseam" id="outseam" step="0.01" min="0" value="{{ old('outseam') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="thigh" class="block text-sm font-medium text-gray-700 mb-1">Thigh</label>
                                            <div class="relative">
                                                <input type="number" name="thigh" id="thigh" step="0.01" min="0" value="{{ old('thigh') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="knee" class="block text-sm font-medium text-gray-700 mb-1">Knee</label>
                                            <div class="relative">
                                                <input type="number" name="knee" id="knee" step="0.01" min="0" value="{{ old('knee') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="ankle" class="block text-sm font-medium text-gray-700 mb-1">Ankle</label>
                                            <div class="relative">
                                                <input type="number" name="ankle" id="ankle" step="0.01" min="0" value="{{ old('ankle') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="pant_length" class="block text-sm font-medium text-gray-700 mb-1">Pant Length</label>
                                            <div class="relative">
                                                <input type="number" name="pant_length" id="pant_length" step="0.01" min="0" value="{{ old('pant_length') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <span class="absolute right-3 top-2.5 text-xs text-gray-500">in</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- JavaScript to show/hide measurements based on garment type -->
                        <script>
                            function updateMeasurementsDisplay() {
                                const garmentType = document.getElementById('garment_type').value;
                                const measurementsSection = document.getElementById('measurements-section');
                                const shirtMeasurements = document.getElementById('shirt-measurements');
                                const pantMeasurements = document.getElementById('pant-measurements');
                                const suitMeasurements = document.getElementById('suit-measurements');
                                
                                // Get all input fields in each section
                                const shirtInputs = shirtMeasurements.querySelectorAll('input[type="number"]');
                                const pantInputs = pantMeasurements.querySelectorAll('input[type="number"]');
                                const suitInputs = suitMeasurements.querySelectorAll('input[type="number"]');
                                
                                if (garmentType) {
                                    measurementsSection.style.display = 'block';
                                    
                                    // Hide all sections and disable their inputs
                                    shirtMeasurements.style.display = 'none';
                                    pantMeasurements.style.display = 'none';
                                    suitMeasurements.style.display = 'none';
                                    shirtInputs.forEach(input => input.disabled = true);
                                    pantInputs.forEach(input => input.disabled = true);
                                    suitInputs.forEach(input => input.disabled = true);
                                    
                                    // Show relevant section and enable its inputs
                                    if (garmentType === 'shirt') {
                                        shirtMeasurements.style.display = 'block';
                                        shirtInputs.forEach(input => input.disabled = false);
                                    } else if (garmentType === 'pant') {
                                        pantMeasurements.style.display = 'block';
                                        pantInputs.forEach(input => input.disabled = false);
                                    } else if (garmentType === 'suit') {
                                        suitMeasurements.style.display = 'block';
                                        suitInputs.forEach(input => input.disabled = false);
                                    }
                                } else {
                                    measurementsSection.style.display = 'none';
                                    shirtInputs.forEach(input => input.disabled = true);
                                    pantInputs.forEach(input => input.disabled = true);
                                    suitInputs.forEach(input => input.disabled = true);
                                }
                            }
                            
                            document.getElementById('garment_type').addEventListener('change', updateMeasurementsDisplay);
                            
                            // Trigger on page load if value exists
                            if (document.getElementById('garment_type').value) {
                                updateMeasurementsDisplay();
                            }
                        </script>

                        <!-- Form Actions -->
                        <div class="mt-8 flex justify-end space-x-4 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('admin.orders.index') }}" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                <i class="fas fa-check mr-2"></i>Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>