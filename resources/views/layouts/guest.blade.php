<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side: Image/Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-blue-600 justify-center items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-indigo-900 opacity-95"></div>
            <!-- decorative circles -->
            <div class="absolute top-0 -left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-2xl opacity-10"></div>
            <div class="absolute top-0 -right-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-2xl opacity-10"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-10"></div>
            
            <div class="relative z-10 text-center px-10 text-white flex flex-col items-center">
                <div class="mb-8 p-4 bg-white/10 rounded-2xl backdrop-blur-sm inline-block">
                    <x-application-logo class="w-20 h-20 text-white fill-current" />
                </div>
                <h1 class="text-4xl font-bold mb-4 tracking-tight">Product Management System</h1>
                <p class="text-lg text-blue-100 max-w-md mx-auto leading-relaxed">Streamline your inventory, track sales, and manage suppliers effortlessly in one secure platform.</p>
                
                <div class="mt-12 grid grid-cols-3 gap-6 text-center text-sm font-medium text-blue-200">
                    <div>
                        <div class="text-2xl font-bold text-white mb-1">Fast</div>
                        <div class="opacity-80">Processing</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white mb-1">Secure</div>
                        <div class="opacity-80">Data storage</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white mb-1">Easy</div>
                        <div class="opacity-80">To manage</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md">
                <div class="lg:hidden flex justify-center mb-8">
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <x-application-logo class="w-12 h-12 text-blue-600 fill-current" />
                    </div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
