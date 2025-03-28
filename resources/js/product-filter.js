function initializeAddToCart() {
    $(".add-to-cart-form").each(function() {
        $(this).off("submit").on("submit", function(e) { // Use .off() to prevent duplicate handlers
            e.preventDefault();
            const form = $(this);
            const button = form.find('.add-to-cart-btn');
            
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
                            title: response.data.message || 'Product added to cart successfully.'
                        });

                        // Update cart counter
                        $('#cart-count').removeClass('hidden').addClass('text-white').text(response.data.cartCount);

                        // Change button to "Go to Cart"
                        button.prop('disabled', false);
                        button.html(`<a href="/cart" class="text-white">Go to Cart</a>`);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message || 'Failed to add product to cart.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please login first to add to cart.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/login";
                        }
                    });
                })
                .finally(() => {
                    if (!button.find("a").length) { // Revert if not "Go to Cart"
                        button.prop('disabled', false);
                        button.html('<svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" /></svg>Add to cart');
                    }
                });
        });
    });
}

// product-filter.js
$(document).ready(function() {
    // Set CSRF token for Axios
    axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

    // Load categories on page load
    loadCategories();

    // Handle filter changes
    $('#categoryFilter').on('change', filterProducts);
    $('#priceSort').on('change', filterProducts);

    function loadCategories() {
        const $select = $('#categoryFilter');
        $select.prop('disabled', true);
        $select.html('<option value="">Loading categories...</option>');

        axios.get('/api/categories/with-count')
            .then(function(response) {
                if (response.data.success) {
                    const categories = response.data.categories;
                    $select.empty();
                    $select.append('<option value="">All Categories</option>');
                    
                    categories.forEach(function(category) {
                        $select.append(`<option value="${category.id}">${category.name} (${category.count})</option>`);
                    });
                }
            })
            .catch(function(error) {
                console.error('Error loading categories:', error);
                $select.html('<option value="">Error loading categories</option>');
            })
            .finally(function() {
                $select.prop('disabled', false);
            });
    }

    function filterProducts(page = 1) {
        const categoryId = $('#categoryFilter').val();
        const sortPrice = $('#priceSort').val();
                
        axios.get('/api/products/filter', {
            params: {
                category_id: categoryId,  // Send actual value for category filtering
                sort_price: sortPrice || '',     // Send empty string if no sort selected
                page: page
            }
        })
        .then(function(response) {
            if (response.data.success) {
                const products = response.data.products.data;
                const $productGrid = $('#product-grid');

                // Clear existing products
                $productGrid.empty();
                
                if (products.length === 0) {
                    $productGrid.html('<p class="text-center text-2xl col-span-full">No products found</p>');
                    return;
                }
                
                // Update pagination links
                if (response.data.products.links) {
                    const paginationHtml = `
                        <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0 mt-6">
                            <div class="-mt-px flex w-0 flex-1">
                                ${response.data.products.current_page > 1 ? `
                                    <a href="#" data-page="${response.data.products.current_page - 1}" class="pagination-link inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
                                        </svg>
                                        Previous
                                    </a>
                                ` : ''}
                            </div>
                            <div class="flex">
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">${response.data.products.from}</span> to <span class="font-medium">${response.data.products.to}</span> of <span class="font-medium">${response.data.products.total}</span> results
                                </p>
                            </div>
                            <div class="-mt-px flex w-0 flex-1 justify-end">
                                ${response.data.products.current_page < response.data.products.last_page ? `
                                    <a href="#" data-page="${response.data.products.current_page + 1}" class="pagination-link inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                        Next
                                        <svg class="ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                ` : ''}
                            </div>
                        </nav>
                    `;
                    $('#pagination').html(paginationHtml);
                }

                // Append new products
                products.forEach(function(product) {
                    const productCard = `
                     
                        <div class="relative rounded-lg border-gray-200 bg-white p-4 shadow-sm border hover:border-green-400 hover:shadow-2xl transition-all duration-400">
                            <div class="h-65 w-full flex justify-center items-center">
                                <a href="/products/${product.slug}">
                                    <img class="h-full object-contain hover:scale-110 transition-all duration-300" src="/storage/${product.image}" alt="${product.name}" />
                                </a>
                            </div>
                            <div class="pt-4">
                                <p class="text-sm text-gray-500">${product.category.name}</p>
                                <a href="/products/${product.slug}" class="text-lg font-semibold leading-tight text-gray-900 hover:underline">${product.name}</a>
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="text-xl font-bold text-gray-900">$${product.price}</p>
                                    <form action="/cart/${product.slug}" method="POST" class="add-to-cart-form">
                                        <button type="submit" class="inline-flex items-center rounded-lg bg-green-600 text-white px-5 py-2.5 text-sm font-medium hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 add-to-cart-btn" data-slug="${product.slug}">
                                            <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                            </svg>
                                            Add to cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                    $productGrid.append(productCard);
                });

                // Reinitialize add-to-cart handlers for new products
                initializeAddToCart();

                // Initialize pagination click handlers
                $('.pagination-link').on('click', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    filterProducts(page);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        })
        .catch(function(error) {
            console.error('Error filtering products:', error);
            $('#product-grid').html('<p class="text-center text-2xl col-span-full">Error loading products</p>');
        });
    }
});