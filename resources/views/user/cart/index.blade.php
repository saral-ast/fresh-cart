<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-gray-900 mb-6">Shopping Cart</h2>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Cart Items Section -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-md">
                    <div class="space-y-1">
                        @if (isset($cart) && count($cart) > 0)
                            @foreach ($cart as $item)
                                <x-product-item :item="$item"/>
                            @endforeach
                        @endif
                        <div class="empty-cart p-8 {{ $cart ? 'hidden' : 'text-center' }}">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-4 text-gray-600 text-lg">Your cart is empty</p>
                            <a href="/" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-base font-semibold text-gray-900">
                            <span>Total</span>
                            <span id='total'>${{$total}}</span>
                        </div>
                    </div>

                    <button type="button" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors proceed-to-checkout">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
   <script>
       $(document).ready(function () {
    $(".remove-item").click(function (e) {
        e.preventDefault();
        let $form = $(this).closest("form");
        let $action = $form.attr("action");
        let $slug = $(this).data("slug");

        axios.delete($action, { slug: $slug })
            .then(function (response) {
                if (response.data.success) {
                    $('#cart-item-' + $slug).remove();
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    if (response.data.cartCount == 0) {
                        $('.empty-cart').removeClass('hidden').addClass('text-center');
                        $('#cart-count').removeClass('text-white').addClass('hidden');
                    }
                    $('#cart-count').text(response.data.cartCount);
                    $('#total').text('$' + response.data.total);
                }
            })
            .catch(function (error) {
                $('#cart-item-' + $slug).remove();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: error.data.message
                });
            });
    });

    $(".increment-button").on("click", function () {
        let slug = $(this).data("slug");
        let form = $(this).closest("form");
        updateQuantity(slug, 1, form);
    });

    $(".decrement-button").on("click", function () {
        let slug = $(this).data("slug");
        let form = $(this).closest("form");
        updateQuantity(slug, -1, form);
    });

    function updateQuantity(slug, change, form) {
        let inputField = $("#counter-input-" + slug);
        let currentQuantity = parseInt(inputField.val());

        let newQuantity = currentQuantity + change;
        if (newQuantity < 1) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Quantity cannot be less than 1'
            });
            return;
        }

        axios.post(form.attr('action'), {
            slug: slug,
            quantity: newQuantity,
        })
        .then(response => {
            if (response.data.success) {
                inputField.val(newQuantity);
                $("#product-total-" + slug).text("$" + response.data.new_total);
                $('#total').text('$' + response.data.cartTotal);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Cart updated successfully'
                });
            }
        })
        .catch(error => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: error.response?.data?.message || 'Error updating cart'
            });
        });
    }

    // Proceed to Checkout Click Event
    $(".proceed-to-checkout").click(function (e) {
        e.preventDefault();
        let total = parseFloat($('#total').text().replace('$', ''));

        if (total === 0) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Your cart is empty. Add products first!'
            });

            setTimeout(() => {
                window.location.href = "{{ route('user.product.index') }}"; // Redirect to products page after 3 seconds
            }, 3000);
        } else {
            window.location.href = "/checkout"; // Proceed to checkout if total > 0
        }
    });

});

   </script>
   
@endpush
</x-layout>
