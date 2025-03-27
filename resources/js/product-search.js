/**
 * Product Search with Debouncing
 */

$(document).ready(function() {
    // Common search functionality for both desktop and mobile
    function setupSearch(inputSelector, resultsSelector) {
        const searchInput = $(inputSelector);
        const searchResults = $(resultsSelector);
        let debounceTimer;
        
        // Function to perform the search with debouncing
        searchInput.on('input', function() {
            const query = $(this).val().trim();
            
            // Clear any existing timeout
            clearTimeout(debounceTimer);
            
            // Hide results if query is empty
            if (query === '') {
                searchResults.html('').addClass('hidden');
                return;
            }
            
            // Set a new timeout for debouncing (300ms)
            debounceTimer = setTimeout(function() {
                // Show loading indicator
                searchResults.html('<div class="p-4 text-center text-gray-500">Searching...</div>').removeClass('hidden');
                
                // Make AJAX request to search endpoint
                $.ajax({
                    url: '/search/products',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        // Process search results
                        if (response.products && response.products.length > 0) {
                            let resultsHtml = '';
                            
                            // Build results HTML
                            response.products.forEach(function(product) {
                                resultsHtml += `
                                    <a href="/products/${product.slug}" class="block p-3 hover:bg-gray-50 transition duration-200 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded overflow-hidden">
                                                <img src="/storage/${product.image}" alt="${product.name}" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 truncate">${product.name}</p>
                                                <p class="text-sm text-green-600">$${product.price}</p>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });
                            
                            // Add view all results link
                            resultsHtml += `
                                <a href="/products?search=${encodeURIComponent(query)}" class="block p-3 text-center text-sm text-green-600 hover:text-green-700 font-medium hover:bg-gray-50 transition duration-200">
                                    View all results
                                </a>
                            `;
                            
                            searchResults.html(resultsHtml).removeClass('hidden');
                        } else {
                            searchResults.html('<div class="p-4 text-center text-gray-500">No products found</div>').removeClass('hidden');
                        }
                    },
                    error: function(error) {
                        console.error('Search error:', error);
                        searchResults.html('<div class="p-4 text-center text-red-500">Error searching products</div>').removeClass('hidden');
                    }
                });
            }, 300); // 300ms debounce delay
        });
        
        // Close search results when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest(inputSelector + ', ' + resultsSelector).length) {
                searchResults.addClass('hidden');
            }
        });
        
        // Prevent form submission on enter key
        searchInput.on('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                // Optionally redirect to search results page
                const query = $(this).val().trim();
                if (query !== '') {
                    window.location.href = `/products?search=${encodeURIComponent(query)}`;
                }
            }
        });
    }
    
    // Setup desktop search
    setupSearch('#search-input', '#search-results');
    
    // Setup mobile search
    setupSearch('#mobile-search-input', '#mobile-search-results');
});