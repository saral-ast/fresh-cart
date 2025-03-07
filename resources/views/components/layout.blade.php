<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />


        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white px-40">
        <nav class="bg-white">
            <div class="max-w-screen-xl mx-auto px-2 py-4 flex justify-between items-center">
                
                <!-- Logo -->
                <a href="/">
                    <img class="w-auto h-8" src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" alt="Logo">
                </a>
    
                <!-- Desktop Menu -->
                <div class="flex space-x-6">
                    <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="/contact" :active="request()->is('/contact')">Contact</x-nav-link>
                    <x-nav-link href="/product" :active="request()->is('/product')">Product</x-nav-link>       
                </div>
    
                <!-- Icons (Cart & Account) -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="flex items-center space-x-1 p-2 hover:bg-gray-200 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                        </svg> 
                        <span class="hidden sm:inline">Cart</span>
                    </a>
                    <a href="#" class="flex items-center space-x-1 p-2 hover:bg-gray-200 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="hidden sm:inline">Account</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <x-divider/>
    
        <!-- Main Content -->
        <main class="max-w-screen-xl mx-auto p-6">
            {{ $slot }}
        </main>
    
        {{-- <footer class="bg-gray-100 text-center py-4">
            <p class="text-gray-600 text-sm">© 2025 FreshCart. All rights reserved.</p>
        </footer> --}}
    
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </body>
    
</html>
