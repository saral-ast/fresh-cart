<x-layout>

        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 mb-3">
            <div class="bg-gray-100 px-6 py-10 rounded-lg"> <!-- Increased padding -->
                <h3 class="text-2xl font-bold text-gray-900">{{$category->name}}</h3>
            </div>
        </div>
           @if ($products->isEmpty())
                 <div class="p-6 bg-white mt-1.5">
                    <p class="text-center text-2xl">No products found</p>
                 </div>
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

</x-layout>
