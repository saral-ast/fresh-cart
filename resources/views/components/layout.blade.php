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
        <nav class="bg-gradient-to-r from-gray-50 to-white shadow-md sticky top-0 z-50 px-12">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="">
                        <img class="w-auto h-10" 
                             src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" 
                             alt="FreshCart">
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex md:items-center md:space-x-8">
                        <x-nav-link href="/" :active="request()->is('/')" 
                            class="relative text-gray-700 hover:text-green-600 font-medium transition-all duration-200 
                                   after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 
                                   after:bg-green-600 after:transition-all after:duration-300 hover:after:w-full">
                            Home
                        </x-nav-link>
                                 

                        <x-nav-link href="{{ route('page', 'contact-us') }}" :active="request()->is('contact-us')"
                            class="relative text-gray-700 hover:text-green-600 font-medium transition-all duration-200 
                               after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 
                               after:bg-green-600 after:transition-all after:duration-300 hover:after:w-full">
                            Contact Us
                        </x-nav-link>
  
                        
                        <x-nav-link href="/products" :active="request()->is('products')"
                            class="relative text-gray-700 hover:text-green-600 font-medium transition-all duration-200 
                                   after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 
                                   after:bg-green-600 after:transition-all after:duration-300 hover:after:w-full">
                            Products
                        </x-nav-link>
                        
                        
                        <!-- Categories with Dropdown -->
                        <div class="category-trigger">
                            <x-nav-link href="/categories" :active="request()->is('categories')"
                                class="flex items-center relative text-gray-700 hover:text-green-600 font-medium 
                                       transition-all duration-200 after:content-[''] after:absolute after:bottom-0 
                                       after:left-0 after:w-0 after:h-0.5 after:bg-green-600 after:transition-all 
                                       after:duration-300 hover:after:w-full">
                                Categories
                            </x-nav-link>
                            
                            <!-- Improved Dropdown Menu -->
                            <div class="category-dropdown absolute top-full left-0 right-0 mt-4 bg-white shadow-xl 
                                        rounded-xl hidden z-50 border border-gray-100 p-6 transition-all duration-300 
                                        ease-in-out opacity-0 scale-95 origin-top data-[visible]:opacity-100 
                                        data-[visible]:scale-100">
                                <div class="max-w-screen-xl mx-auto">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Explore Categories</h3>
                                    <div class="grid grid-cols-3 gap-4">
                                        @php
                                            $categories = \App\Models\Admin\Category::all();
                                        @endphp
                                        @forelse($categories as $category)
                                            <a href="{{ route('user.category.show', $category->slug) }}"
                                               class="px-4 py-3 text-gray-700 hover:text-white hover:bg-green-500 
                                                      rounded-lg text-center whitespace-normal transition duration-300 
                                                      ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                                {{ $category->name }}
                                            </a>
                                        @empty
                                            <div class="px-4 py-2 text-gray-500 col-span-3 text-center">No categories found</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" id="search-input" placeholder="Search products..." 
                               class="w-64 pl-10 pr-3 py-2 border border-gray-200 rounded-full 
                                      focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 
                                      transition duration-300 bg-gray-50" autocomplete="off">
                        <div id="search-results" class="absolute left-0 right-0 mt-2 bg-white shadow-lg rounded-lg overflow-hidden z-50 hidden"></div>
                    </div>
                    

                    <!-- Icons (Cart & Account) -->
                    <div class="flex items-center space-x-4">
                        @auth('user')
                        <x-nav-link href="{{ route('cart.show') }}" :active="request()->is('cart')" 
                            class="relative flex items-center space-x-1 p-2 rounded-lg transition-all duration-200 
                                   group hover:bg-gray-100" title="View Cart">
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-green-600 transition-transform duration-200 
                                        group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg>
                            <span class="hidden sm:inline">Cart</span>
                            <span id="cart-count" class="absolute -top-1 -right-2 bg-red-500 text-xs font-bold px-2 py-1 
                                   rounded-full {{ session('cart') ? 'text-white' : 'hidden' }}">
                                {{ session('cart') ? count(session('cart')) : 0 }}
                            </span>
                        </x-nav-link>
                        
                        <x-nav-link href="/profile" :active="request()->is('profile')" 
                            class="flex items-center space-x-1 p-2 rounded-lg transition-all duration-200 group 
                                   hover:bg-gray-100" title="My Account">
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-green-600 transition-transform duration-200 
                                        group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="2" 
                                      d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            <span class="hidden sm:inline">Profile</span>
                        </x-nav-link>
                        <form action="/logout" method="POST" class="hidden md:block">
                            @csrf
                            <button class="flex items-center space-x-2 px-4 py-2 bg-green-600 hover:bg-green-700 
                                           text-white rounded-lg transition duration-200 ease-in-out font-medium text-sm 
                                           shadow-sm hover:shadow-md">
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
                                class="px-4 py-2 text-green-600 hover:text-green-700 font-medium transition-colors duration-200">
                                Login
                            </x-nav-link>
                            <x-nav-link href="/register" :active="request()->is('register')"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition 
                                       duration-200 ease-in-out font-medium shadow-sm hover:shadow-md">
                                Register
                            </x-nav-link>
                        </div>
                        @endguest

                        <!-- Mobile menu button -->
                        <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md 
                                text-gray-600 hover:text-green-600 hover:bg-gray-100 transition duration-200"
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
                        <!-- Mobile Search Bar -->
                        <div class="relative mb-3 px-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" id="mobile-search-input" placeholder="Search products..." 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-full 
                                          focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 
                                          transition duration-300 bg-gray-50">
                            <div id="mobile-search-results" class="absolute left-0 right-0 mt-2 bg-white shadow-lg 
                                   rounded-lg overflow-hidden z-50 hidden"></div>
                        </div>
                        
                        <x-nav-link href="/" :active="request()->is('/')" 
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 
                                   hover:bg-gray-100 transition-colors duration-200">Home</x-nav-link>
                        <x-nav-link href="/contact" :active="request()->is('contact')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 
                                   hover:bg-gray-100 transition-colors duration-200">Contact</x-nav-link>
                        <x-nav-link href="/products" :active="request()->is('products')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 
                                   hover:bg-gray-100 transition-colors duration-200">Products</x-nav-link>
                        <x-nav-link href="/categories" :active="request()->is('categories')"
                            class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-green-600 
                                   hover:bg-gray-100 transition-colors duration-200">Categories</x-nav-link>
                        @auth('user')
                        <form action="/logout" method="POST" class="mt-4">
                            @csrf
                            <button class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-green-600 
                                           hover:bg-green-700 text-white rounded-lg transition duration-200 ease-in-out 
                                           font-medium text-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                        @endauth
                        @guest('user')
                        <div class="mt-4 space-y-2">
                            <x-nav-link href="/login" :active="request()->is('login')"
                                class="block w-full px-4 py-2 text-center text-green-600 hover:text-green-700 font-medium 
                                       transition-colors duration-200">Login</x-nav-link>
                            <x-nav-link href="/register" :active="request()->is('register')"
                                class="block w-full px-4 py-2 text-center bg-green-600 hover:bg-green-700 text-white 
                                       rounded-lg transition duration-200 ease-in-out font-medium">Register</x-nav-link>
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
        <!-- Static Block Footer Content -->
        @php
            use App\Helpers\StaticBlockHelper;
        @endphp
        <div class="mt-8 pt-6 border-t border-gray-200">
            {!! StaticBlockHelper::render('footer', '') !!}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function () {
                // Mobile menu toggle
                $('[aria-controls="mobile-menu"]').on('click', function () {
                    let mobileMenu = $('#mobile-menu');
                    let expanded = $(this).attr('aria-expanded') === 'true';
        
                    $(this).attr('aria-expanded', !expanded);
                    mobileMenu.toggleClass('hidden');
        
                    // Animate menu icon
                    let icon = $(this).find('svg');
                    if (!expanded) {
                        icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>');
                    } else {
                        icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>');
                    }
                });

                let timeoutId;

                // Categories dropdown hover with delay
                $('.category-trigger').hover(
                    function() {
                        clearTimeout(timeoutId);
                        $(this).find('.category-dropdown')
                            .removeClass('hidden')
                            .attr('data-visible', 'true');
                    },
                    function() {
                        let $dropdown = $(this).find('.category-dropdown');
                        timeoutId = setTimeout(function() {
                            $dropdown.addClass('hidden')
                                .removeAttr('data-visible');
                        }, 300);
                    }
                );

                $('.category-dropdown').hover(
                    function() {
                        clearTimeout(timeoutId);
                        $(this).removeClass('hidden')
                            .attr('data-visible', 'true');
                    },
                    function() {
                        let $dropdown = $(this);
                        timeoutId = setTimeout(function() {
                            $dropdown.addClass('hidden')
                                .removeAttr('data-visible');
                        }, 300);
                    }
                );
            });
        </script>
        @stack('scripts')
    </body>
</html>