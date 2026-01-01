<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers - Admin Dashboard</title>
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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
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

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <!-- Header -->
                <div class="flex justify-between items-center mb-10 animate-fadeInUp">
                    <div>
                        <h2 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-3">
                            Customers
                        </h2>
                        <p class="text-xl text-gray-600 font-medium">Manage your customer database</p>
                    </div>
                    <a href="{{ route('admin.customers.create') }}" class="group inline-flex items-center px-6 py-3.5 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                        <i class="fas fa-plus-circle mr-2 text-lg group-hover:rotate-90 transition"></i>Add New Customer
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

                <!-- Search Form -->
                <div class="mb-6 glass-effect rounded-2xl shadow-xl p-6 animate-fadeInUp" style="animation-delay: 0.1s;">
                    <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by name, email, phone, or address..." 
                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white">
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.customers.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition">
                                    <i class="fas fa-times mr-2"></i>Clear
                                </a>
                            @endif
                        </div>
                    </form>
                    @if(request('search'))
                        <div class="mt-4 text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-2"></i>Showing results for: <strong>"{{ request('search') }}"</strong>
                        </div>
                    @endif
                </div>

                <!-- Customers Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($customers as $customer)
                        <div class="card-hover glass-effect rounded-2xl shadow-xl p-6 border border-white/50 animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                            <div class="flex items-start justify-between mb-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl blur opacity-50"></div>
                                        <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center text-white font-black text-xl shadow-lg transform hover:rotate-12 transition">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900 mb-1">{{ $customer->name }}</h3>
                                        <div class="flex items-center text-sm font-bold text-purple-600">
                                            <i class="fas fa-shopping-bag mr-2"></i>
                                            <span>{{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-3 mb-5">
                                @if($customer->email)
                                    <div class="flex items-center text-sm text-gray-700 bg-white/50 rounded-lg px-3 py-2">
                                        <i class="fas fa-envelope w-5 text-indigo-500 mr-3"></i>
                                        <span class="truncate font-medium">{{ $customer->email }}</span>
                                    </div>
                                @endif
                                @if($customer->phone)
                                    <div class="flex items-center text-sm text-gray-700 bg-white/50 rounded-lg px-3 py-2">
                                        <i class="fas fa-phone w-5 text-indigo-500 mr-3"></i>
                                        <span class="font-medium">{{ $customer->phone }}</span>
                                    </div>
                                @endif
                                @if($customer->address)
                                    <div class="flex items-start text-sm text-gray-700 bg-white/50 rounded-lg px-3 py-2">
                                        <i class="fas fa-map-marker-alt w-5 text-indigo-500 mr-3 mt-0.5"></i>
                                        <span class="line-clamp-2 font-medium">{{ $customer->address }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-5 border-t border-gray-200">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="group inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                    View Details <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                                </a>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.customers.edit', $customer) }}" class="p-2.5 text-blue-600 hover:bg-gradient-to-br hover:from-blue-50 hover:to-indigo-50 rounded-xl transition transform hover:scale-110 shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-red-600 hover:bg-gradient-to-br hover:from-red-50 hover:to-pink-50 rounded-xl transition transform hover:scale-110 shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="glass-effect rounded-2xl shadow-2xl p-16 text-center animate-fadeInUp">
                                <div class="relative w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <i class="fas fa-users text-gray-400 text-4xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 mb-3">
                                    @if(request('search'))
                                        No customers found for "{{ request('search') }}"
                                    @else
                                        No customers found
                                    @endif
                                </h3>
                                <p class="text-gray-600 mb-8 font-medium">
                                    @if(request('search'))
                                        Try adjusting your search terms or <a href="{{ route('admin.customers.index') }}" class="text-indigo-600 font-bold hover:underline">clear the search</a>.
                                    @else
                                        Get started by creating your first customer.
                                    @endif
                                </p>
                                @if(!request('search'))
                                    <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition">
                                        <i class="fas fa-plus-circle mr-2 text-lg"></i>Create Customer
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="mt-10">
                        <div class="glass-effect rounded-xl shadow-xl p-4">
                            {{ $customers->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
