$(document).ready(function () {
    $(".add-to-cart-form").each(function() {
        $(this).on("submit", function(e) {
            e.preventDefault();
            const form = $(this);
            const button = form.find('.add-to-cart-btn');
            const productSlug = button.data('slug');
            
            // Disable button and show loading state
            button.prop('disabled', true);
            button.html('<svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Adding...');
            
            axios.post(form.attr('action'), new FormData(form[0]))
                .then(response => {
                    if (response.data.success) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Product added to cart successfully!'
                        });

                        // Update cart counter if exists
                        const cartCounter = $('.cart-counter');
                        if (cartCounter.length) {
                            cartCounter.text(response.data.cartCount);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message || 'Failed to add product to cart.'
                        });
                    }
                })
                .catch(error => {
                    let errorMessage = 'Something went wrong! Please try again.';
                    
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage
                    });
                })
                .finally(() => {
                    // Reset button state
                    button.prop('disabled', false);
                    button.html('<svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" /></svg>Add to cart');
                });
        });
    });
});