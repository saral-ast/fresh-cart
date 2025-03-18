<x-layout>

    <x-slider />

    <section class="py-8">
        <div class="container mx-auto px-4">
            <x-small-heading>Featured Catagories</x-small-heading>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($featuredCategories as $featuredCategory)
            <a href="{{ route('user.category.show', $featuredCategory->slug) }}">
                <x-catagory-card :category="$featuredCategory" />
            </a>
            @endforeach
            </div>
           
        </div>
    </section>

    <section class="mb-8">
        <div class="container mx-auto px-4 py-7">
            <div class="grid grid-cols-2 gap-6">
                <!-- Fruits & Vegetables -->
                <div class="relative flex items-center p-6 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="absolute inset-0 bg-cover bg-center" 
                         style="background-image: url({{ Vite::asset('resources/images/grocery-banner.png') }});">
                    </div>
                    <div class="relative z-10 p-6  backdrop-blur-md rounded-lg">
                        <h2 class="text-2xl font-bold text-gray-900">Fruits & Vegetables</h2>
                        <p class="text-gray-700">Get Upto <span class="font-bold">30%</span> Off</p>
                        <a href="#" class="mt-4 inline-block px-4 py-2 bg-gray-900 text-white rounded-md">Shop Now</a>
                    </div>
                </div>

                <!-- Freshly Baked Buns -->
                <div class="relative flex items-center p-6 bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="absolute inset-0 bg-cover bg-center" 
                         style="background-image: url({{ Vite::asset('resources/images/grocery-banner-2.jpg') }});">
                    </div>
                    <div class="relative z-10 p-6 backdrop-blur-md rounded-lg">
                        <h2 class="text-2xl font-bold text-gray-900">Freshly Baked Buns</h2>
                        <p class="text-gray-700">Get Upto <span class="font-bold">25%</span> Off</p>
                        <a href="#" class="mt-4 inline-block px-4 py-2 bg-gray-900 text-white rounded-md">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mx-auto px-4">
            <x-small-heading>Featured Products</x-small-heading>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                @foreach ($featuredProducts as $featuredProduct)
                {{-- <a href="{{ route('user.product.show', $featuredProduct->slug) }}"> --}}
                    <x-product-card :product="$featuredProduct" />

                @endforeach
            </div>
            {{-- <x-product-card :products="$featuredProducts" /> --}}
            <div class="mt-6">
                {{ $featuredProducts->links() }}
            </div>
        </div>
        </div>
    </section>
    <section class="py-12 bg-white mt-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                
                <!-- 10 Minute Grocery -->
                <div class="flex flex-col items-center px-4">
                    <img src="{{ Vite::asset('resources/images/clock.svg') }}" alt="Grocery Icon" class="w-10 h-10">

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">10 minute grocery now</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Get your order delivered to your doorstep at the earliest from FreshCart pickup stores near you.
                    </p>
                </div>
    
                <!-- Best Prices & Offers -->
                <div class="flex flex-col items-center">
                    <img src="{{ Vite::asset('resources/images/gift.svg') }}" alt="Grocery Icon" class="w-10 h-10">

                      
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Best Prices & Offers</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Cheaper prices than your local supermarket, great cashback offers to top it off. Get best prices & offers.
                    </p>
                </div>
    
                <!-- Wide Assortment -->
                <div class="flex flex-col items-center">
                    <img src="{{ Vite::asset('resources/images/package.svg') }}" alt="Grocery Icon" class="w-10 h-10">

                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Wide Assortment</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Choose from 5000+ products across food, personal care, household, bakery, veg and non-veg & other categories.
                    </p>
                </div>
    
                <!-- Easy Returns -->
                <div class="flex flex-col items-center">
                    <img src="{{ Vite::asset('resources/images/package.svg') }}" alt="Grocery Icon" class="w-10 h-10">
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Easy Returns</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Not satisfied with a product? Return it at the doorstep & get a refund within hours. No questions asked 
                        <a href="#" class="text-green-600 font-medium">policy</a>.
                    </p>
                </div>
    
            </div>
        </div>
    </section>
    
</x-layout>
