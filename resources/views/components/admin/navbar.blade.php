<aside class="w-72 bg-white h-screen shadow-sm fixed flex flex-col justify-between border-r border-gray-200">
    <!-- Logo Section -->
    <div>
        <div class="p-6 flex items-center space-x-2 border-b border-gray-200">
            <a href="{{ route('home') }}">
                <img src="{{ Vite::asset('resources/images/freshcart-logo.svg') }}" class="h-8 w-auto transition-transform duration-200 hover:scale-105" alt="Logo">
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-6 px-6">
            <ul class="space-y-4">
                <li>
                    <x-admin.nav-link href="/admin/dashboard" :active="request()->is('admin/dashboard')" 
                        class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                        <i class="mdi mdi-view-dashboard text-xl mr-3"></i> 
                        <span class="font-medium">Dashboard</span>
                    </x-admin.nav-link>
                </li>

                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Store Management</p>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <x-admin.nav-link href="/admin/products" :active="request()->is('admin/products')"
                                class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-shopping text-xl mr-3"></i>
                                <span class="font-medium">Products</span>
                            </x-admin.nav-link>                               
                        </li>
                        <li>
                            <x-admin.nav-link href="/admin/categories" :active="request()->is('admin/categories')"
                                class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-shape text-xl mr-3"></i>
                                <span class="font-medium">Categories</span>
                            </x-admin.nav-link>
                        </li>
                        <li>
                            <x-admin.nav-link href="/dashboard/orders" :active="request()->is('admin/orders')"
                                class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-cart text-xl mr-3"></i>
                                <span class="font-medium">Orders</span>
                            </x-admin.nav-link>
                        </li>
                        <li>
                            <x-admin.nav-link href="/admin/customers" :active="request()->is('admin/customers')"
                                class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-account-group text-xl mr-3"></i>
                                <span class="font-medium">Customers</span>
                            </x-admin.nav-link>
                        </li>
                    </ul>
                </div>

                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                    <ul class="mt-4 space-y-3">
                        <li>
                            <x-admin.nav-link href="/dashboard/settings" :active="request()->is('dashboard/settings')"
                                class="flex items-center px-4 py-3 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <i class="mdi mdi-cog text-xl mr-3"></i>
                                <span class="font-medium">Settings</span>
                            </x-admin.nav-link>
                        </li>
                    </ul>
                </div>
            </ul>
        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="p-6 border-t border-gray-200">
        <form action="/admin/logout" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 font-medium text-sm shadow-sm hover:shadow-md">
                <i class="mdi mdi-logout text-lg mr-2"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>