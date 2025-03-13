<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white">
        <nav class="bg-white shadow-sm sticky top-0 z-50 px-12">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="flex-shrink-0">
                        <img class="w-auto h-8 transition-transform duration-200 hover:scale-105" 
                             src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" 
                             alt="FreshCart">
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
                        <x-nav-link href="/products" :active="request()->is('products')">Products</x-nav-link>
                        <x-nav-link href="/categories" :active="request()->is('categories')">Categories</x-nav-link>
                    </div>

                    <!-- Icons (Cart & Account) -->
                    <div class="flex items-center space-x-4">
                        @auth('user')
                        <div class="relative group">
                            <a href="#" class="flex items-center space-x-1 p-2  rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 text-gray-600 group-hover:text-green-600 transition-colors duration-200" 
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                                </svg>
                                <span class="hidden sm:inline text-gray-600 group-hover:text-green-600 transition-colors duration-200">Cart</span>
                            </a>
                        </div>
                        <div class="relative group">
                            <a href="#" class="flex items-center space-x-1 p-2  rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 text-gray-600 group-hover:text-green-600 transition-colors duration-200" 
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="2" 
                                          d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                <span class="hidden sm:inline text-gray-600 group-hover:text-green-600 transition-colors duration-200">Account</span>
                            </a>
                        </div>
                        <form action="/logout" method="POST" class="hidden md:block">
                            @csrf
                            <button class="flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out font-medium text-sm shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                        @endauth
                        @guest('user')
                        <div class="hidden md:flex md:items-center md:space-x-4">
                            <x-nav-link href="/login" :active="request()->is('login')"
                                class="px-4 py-2 text-green-600 hover:text-green-700 font-medium transition-colors duration-200">Login</x-nav-link>
                            <x-nav-link href="/register" :active="request()->is('register')"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out font-medium shadow-sm hover:shadow-md">Register</x-nav-link>
                        </div>
                        @endguest

                        <!-- Mobile menu button -->
                        <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-green-600 hover:bg-gray-100 transition duration-200"
                                aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <x-nav-link href="/" :active="request()->is('/')" 
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-100 transition-colors duration-200">Home</x-nav-link>
                        <x-nav-link href="/contact" :active="request()->is('contact')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-100 transition-colors duration-200">Contact</x-nav-link>
                        <x-nav-link href="/products" :active="request()->is('products')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-100 transition-colors duration-200">Products</x-nav-link>
                        <x-nav-link href="/categories" :active="request()->is('categories')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-100 transition-colors duration-200">Categories</x-nav-link>
                        @auth('user')
                        <form action="/logout" method="POST" class="mt-4">
                            @csrf
                            <button class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out font-medium text-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                        @endauth
                        @guest('user')
                        <div class="mt-4 space-y-2">
                            <x-nav-link href="/login" :active="request()->is('login')"
                                class="block w-full px-4 py-2 text-center text-green-600 hover:text-green-700 font-medium transition-colors duration-200">Login</x-nav-link>
                            <x-nav-link href="/register" :active="request()->is('register')"
                                class="block w-full px-4 py-2 text-center bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out font-medium">Register</x-nav-link>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <x-divider/>

        <!-- Main Content -->
        <main class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

        <footer class="bg-gray-100 w-full py-12">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <!-- About Us -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About Us</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            FreshCart is your one-stop online store for fresh groceries, organic produce, and daily essentials.
                            We're committed to bringing quality products right to your doorstep.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                        <ul class="text-gray-600 text-sm space-y-3">
                            <li><a href="/" class="hover:text-green-600 transition-colors duration-200">Home</a></li>
                            <li><a href="/shop" class="hover:text-green-600 transition-colors duration-200">Shop</a></li>
                            <li><a href="/about" class="hover:text-green-600 transition-colors duration-200">About Us</a></li>
                            <li><a href="/contact" class="hover:text-green-600 transition-colors duration-200">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Newsletter</h3>
                        <p class="text-gray-600 text-sm mb-4">Subscribe to get the latest deals and offers!</p>
                        <form class="space-y-3">
                            <input type="email" placeholder="Enter your email" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-medium shadow-sm hover:shadow-md">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="mt-12 pt-8 border-t border-gray-200 text-center text-sm text-gray-600">
                    © 2025 FreshCart. All rights reserved.
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script>
            // Mobile menu toggle
            document.querySelector('[aria-controls="mobile-menu"]').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobile-menu');
                const expanded = this.getAttribute('aria-expanded') === 'true';
                
                this.setAttribute('aria-expanded', !expanded);
                mobileMenu.classList.toggle('hidden');
                
                // Animate menu icon
                const icon = this.querySelector('svg');
                if (!expanded) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
                } else {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
                }
            });

            // Initialize dropdowns for cart and account
            const dropdownButtons = document.querySelectorAll('.group > a');
            dropdownButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const dropdown = button.nextElementSibling;
                    if (dropdown && dropdown.classList.contains('dropdown-menu')) {
                        dropdown.classList.toggle('hidden');
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.group')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (!menu.classList.contains('hidden')) {
                            menu.classList.add('hidden');
                        }
                    });
                }
            });
        </script>
    </body>
</html>