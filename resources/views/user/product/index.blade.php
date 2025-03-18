<x-layout>
    <section class="py-8 bg-white md:py-16 antialiased">
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <h3 class="text-2xl font-bold mb-2">All Products</h3>
            @if ($products->isEmpty())
                <p class="text-center text-2xl">No products found</p>
            @else      
            <section class="bg-white py-2 antialiased">
                <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-4">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($products as $product)
                                <x-product-card :product="$product" />
                     
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
            {{ $products->links() }}
        </div>
    </section>
    
</x-layout>