<x-layout>
    <section class="py-8 bg-white md:py-16 antialiased">
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/3">
                    <select id="categoryFilter" class="w-full p-2 border rounded-lg">
                        <option value="">All Categories</option>
                    </select>
                </div>
                <div class="w-full md:w-1/3">
                    <select id="priceSort" class="w-full p-2 border rounded-lg">
                        <option value="">Sort by Price</option>
                        <option value="asc">Low to High</option>
                        <option value="desc">High to Low</option>
                    </select>
                </div>
            </div>
            <h3 class="text-2xl font-bold mb-2">All Products</h3>
            @if ($products->isEmpty())
                <p class="text-center text-2xl">No products found</p>
            @else      
            <section class="bg-white py-2 antialiased">
                <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-4">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" id="product-grid">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-4" id="pagination">
                        {{ $products->links() }}
                    </div>
                </div>
            </section>
            @endif
          
        </div>
    </section>
    
</x-layout>