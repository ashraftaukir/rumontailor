<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>
    
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

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-8 animate-fadeInUp">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur opacity-75"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl">
                            <i class="fas fa-cut text-white text-3xl"></i>
                        </div>
                    </div>
                </div>
                <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 mb-2">
                    Tailor Admin
                </h2>
                <p class="text-lg text-gray-600 font-medium">
                    Sign in to access the admin panel
                </p>
            </div>
            
            <form class="mt-8 space-y-6" action="{{ route('admin.login') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="glass-effect rounded-xl shadow-xl border-l-4 border-red-500 p-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-exclamation-circle text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-2">
                                    There were errors with your submission
                                </h3>
                                <ul class="list-disc list-inside space-y-1 text-sm text-gray-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-indigo-600 mr-2"></i>Email address
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm" 
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                        >
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock text-indigo-600 mr-2"></i>Password
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="current-password" 
                            required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition bg-white shadow-sm" 
                            placeholder="Enter your password"
                        >
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm font-medium text-gray-700">
                            Remember me
                        </label>
                    </div>
                </div>
                
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center items-center py-4 px-4 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-xl shadow-indigo-500/50 hover:shadow-2xl hover:shadow-indigo-500/60 transform hover:scale-105 transition"
                    >
                        <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition"></i>
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
