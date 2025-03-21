@props(['item'])

<div class="grid grid-cols-12 items-center gap-4 border-b border-gray-300 py-4 px-6 relative shadow" id="cart-item-{{ $item['slug'] }}">
    
    <!-- Product Image -->
    <div class="col-span-2 flex justify-center">
        <img src="{{ asset('storage/' . $item['image']) }}" class="w-24 h-24 rounded-lg object-cover shadow-md" alt="{{ $item['name'] }}">
    </div>

    <!-- Product Details -->
    <div class="col-span-4">
        <h3 class="font-semibold text-gray-900 text-lg">{{ $item['name'] }}</h3>
        <p class="text-gray-500 text-sm truncate">{{ $item['description'] }}</p>
    </div>

    <!-- Product Price -->
    <div class="col-span-2 text-center">
        <p class="text-gray-700 text-sm">Price</p>
        <p class="text-gray-900 font-bold">${{ number_format($item['price'], 2) }}</p>
    </div>

    <!-- Quantity Controls -->
    <div class="col-span-2 flex items-center justify-center space-x-2">
        <form method="GET" class=".update-form" action="{{ route('cart.update') }}">
            @csrf
            <button type="button" class="decrement-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 transition"
            data-slug="{{ $item['slug'] }}">
            <svg class="w-4 h-4 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M1 1h16" />
            </svg>
        </button>
        </form>
        

        <input type="text" id="counter-input-{{ $item['slug'] }}" class="w-10 text-center border border-gray-300 rounded-md bg-white text-gray-900 text-sm font-semibold focus:ring-2 focus:ring-gray-200"
            value="{{ $item['quantity'] }}" required readonly />
        <form method="GET" class=".update-form" action="{{ route('cart.update') }}">
            @csrf
            <button type="button" class="increment-button w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 transition"
            data-slug="{{ $item['slug'] }}">
            <svg class="w-4 h-4 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 1v16M1 9h16" />
            </svg>
        </button>
        </form>
        
    </div>

    <!-- Total Price -->
    <div class="col-span-2 text-center">
        <p class="text-gray-700 text-sm">Total</p>
        <p class="text-gray-900 font-bold" id="product-total-{{ $item['slug'] }}">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
    </div>
    @php
       $slug = $item['slug'];
    @endphp
    <!-- Remove Button (Moved to Right Corner) -->
    <div class="absolute top-2 right-2">
      <form action="{{ route('cart.remove', $slug) }}" class = 'remove-item-form' method="POST" data-item-id="{{ $item['slug'] }}"> 
        @csrf
        @method('DELETE')
        <button type="submit" class="remove-item flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-50 transition-colors duration-200" data-slug="{{ $item['slug'] }}">
            <svg class="w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
      </form>
      {{-- <button type="button" class="remove-item flex items-center justify-center w-8 h-8 rounded-full hover:bg-red-50 transition-colors duration-200" 
    data-slug="{{ $item['slug'] }}">
    <svg class="w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button> --}}


    </div>

</div>

