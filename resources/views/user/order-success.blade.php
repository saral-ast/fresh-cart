<x-layout>
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <div class="bg-white p-8 rounded-lg shadow-lg border border-gray-100 text-center">
            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Order Placed Successfully!</h1>
            <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been received and is being processed.</p>
            
            <div class="bg-gray-50 p-6 rounded-md mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Order Details</h2>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-medium">{{ $order->id }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Amount:</span>
                    <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Status:</span>
                    <span class="font-medium capitalize">{{ $order->status }}</span>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Continue Shopping
                </a>
                <a href="#" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-6 rounded-lg text-center font-semibold transition duration-200 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    View Order History
                </a>
            </div>
        </div>
    </div>
</x-layout>