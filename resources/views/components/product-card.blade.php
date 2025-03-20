
@props(['product'=>$product])

<div class="relative rounded-lg  border-gray-200 bg-white p-4 shadow-sm border  hover:border-green-400 hover:shadow-2xl transition-all duration-400">

    <!-- Product Image -->
    <div class="h-65 w-full flex justify-center items-center">
        <a href={{ route('user.product.show', $product->slug) }}>
            <img class="h-full object-contain hover:scale-110 transition-all duration-300" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product['name'] }}" />
        </a>
    </div>

    <!-- Product Details -->
    <div class="pt-4">
        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
        <a href="{{ route('user.product.show',$product->slug) }}" class="text-lg font-semibold leading-tight text-gray-900 hover:underline">{{ $product->name }}</a>

        <!-- Pricing & Add Button -->
        <div class="mt-4 flex items-center justify-between">
            <p class="text-xl font-bold text-gray-900">${{ $product->price }}</p>
            <form action="{{ route('cart.store',$product->slug) }}" method="POST" class="add-to-cart-form">
                @csrf
                <button type="submit" class="inline-flex items-center rounded-lg bg-green-600 text-white px-5 py-2.5 text-sm font-medium  hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 add-to-cart-btn" data-slug="{{ $product->slug }}">
                    <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                    </svg>
                    Add to cart
                </button>
            </form>
            
        </div>
    </div>
</div>

