<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
        <!-- Welcome Section - Enhanced with gradient background -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between bg-cover bg-center h-50" style="background-image: url('{{ asset('images/grocery-banner.png') }}');">
            <div class="py-5">
                <h1 class="text-2xl font-bold">Welcome back! FreshCart</h1>
                <p class="text-gray-600">Add new products to your inventory with ease.</p>
                <a href="{{ route('admin.product.create') }}" 
                   class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition shadow-md mt-4">
                    Create Product
                </a>
            </div>
        </div>

        <!-- Stats Section - Enhanced with better spacing and icons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Earnings Card -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Total Earnings</h3>
                    <div class="bg-red-100 text-red-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold">${{$totalEarnings ?? 0}}</h2>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <span class="text-green-500 mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </span>
                    <span>Monthly revenue</span>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Total Orders</h3>
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold">{{$totalOrders}}</h2>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <span class="text-green-500 mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </span>
                    <span>10+ New Sales</span>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-medium">Total Customers</h3>
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold">{{$totalCustomers}}</h2>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <span class="text-green-500 mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </span>
                    <span>30+ new in 2 days</span>
                </div>
            </div>
        </div>
        @can('manage_orders')
        <!-- Recent Orders Section - Enhanced with better spacing and style -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-medium">Order ID</th>
                            <th class="px-6 py-4 font-medium">Customer</th>
                            <th class="px-6 py-4 font-medium">Date</th>
                            <th class="px-6 py-4 font-medium">Total</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $order->created_at->format('d M Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'completed' => 'bg-green-100 text-green-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                        $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button type="button" 
                                        class="preview-btn px-3 py-1.5 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors flex items-center justify-center mx-auto"
                                        data-order-id="{{ $order->id }}"
                                        data-modal-target="orderModal"
                                        data-modal-toggle="orderModal">
                                        <span class="material-icons text-sm mr-1">visibility</span> Preview
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p>No orders found</p>
                                        <p class="text-sm mt-1">New orders will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Modal - Enhanced with better styling -->
        <div id="orderModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-xl shadow-2xl">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Order Details
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="orderModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <div class="flex flex-col h-full space-y-4">
                                    <!-- Order Info -->
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="text-sm font-semibold text-gray-500 mb-3">Order Information</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-gray-500">Order ID</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-order-id"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Date</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-order-date"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Customer</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-customer-name"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Total</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-order-total"></p>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Payment Information Section -->
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="text-sm font-semibold text-gray-500 mb-3">Payment Information</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-xs text-gray-500">Payment Status</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-payment-status"></p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">Payment Amount</p>
                                                <p class="text-sm font-medium text-gray-900" id="modal-payment-amount"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <!-- Address Information Section -->
                                <div class="bg-gray-50 p-4 rounded-lg h-full">
                                    <h4 class="text-sm font-semibold text-gray-500 mb-3">Shipping Address</h4>
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-900" id="modal-address-full"></p>
                                        <p class="text-sm text-gray-500 mt-1" id="modal-address-city-state"></p>
                                        <p class="text-sm text-gray-500" id="modal-address-country-postal"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Status Update -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-500 mb-3">Update Order Status</h4>
                            <select id="order-status" class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        
                        <!-- Order Items Table -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-500 mb-3">Order Items</h4>
                            <div class="overflow-x-auto rounded-lg border border-gray-200">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-items-container" class="bg-white divide-y divide-gray-200">
                                        <!-- Order items will be inserted here via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end p-6 space-x-3 border-t border-gray-200 rounded-b">
                        <button data-modal-hide="orderModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-colors">
                            Close
                        </button>
                        <button type="button" id="update-status-btn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition-colors">
                            Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @push('scripts')
        <script>
            $(document).ready(function() {
                const previewButtons = $('.preview-btn');
                const orderStatusSelect = $('#order-status');
                const updateStatusBtn = $('#update-status-btn');
                let currentOrderId = null;
    
                // Handle preview button clicks
                previewButtons.each(function() {
                    $(this).on('click', function() {
                        const orderId = $(this).data('order-id');
                        currentOrderId = orderId;
                        
                        // Fetch order details via Axios
                        axios.get(`/admin/orders/${orderId}`)
                            .then(response => {
                                const data = response.data;
                                
                                // Populate modal with order details
                                $('#modal-order-id').text('#' + data.order.id);
                                $('#modal-order-date').text(data.order.created_at);
                                $('#modal-customer-name').text(data.order.user.name);
                                $('#modal-order-total').text('$' + data.order.total);
                                
                                // Populate payment information
                                if (data.order.payment) {
                                    $('#modal-payment-status').text(data.order.payment.status.charAt(0).toUpperCase() + data.order.payment.status.slice(1));
                                    $('#modal-payment-amount').text('$' + data.order.payment.amount);
                                } else {
                                    $('#modal-payment-status').text('Not available');
                                    $('#modal-payment-amount').text('Not available');
                                }
                                
                                // Populate address information
                                if (data.order.address) {
                                    $('#modal-address-full').text(data.order.address.address);
                                    $('#modal-address-city-state').text(`${data.order.address.city}, ${data.order.address.state}`);
                                    $('#modal-address-country-postal').text(`${data.order.address.country}, ${data.order.address.postal_code}`);
                                } else {
                                    $('#modal-address-full').text('Not available');
                                    $('#modal-address-city-state').text('');
                                    $('#modal-address-country-postal').text('');
                                }
                                
                                // Set current status in dropdown
                                orderStatusSelect.val(data.order.status);
                                
                                // Populate order items
                                const itemsContainer = $('#order-items-container');
                                itemsContainer.empty();
                                
                                data.order.ordersitem.forEach(item => {
                                    const row = $('<tr>').addClass('hover:bg-gray-50');
                                    row.html(`
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.product.name}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.quantity}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${item.price}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">$${(item.quantity * item.price).toFixed(2)}</td>
                                    `);
                                    itemsContainer.append(row);
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching order details:', error);
                            });
                    });
                });
    
                // Handle status update
                updateStatusBtn.on('click', function() {
                    if (!currentOrderId) return;
                    
                    const newStatus = orderStatusSelect.val();
                    
                    // Send Axios request to update status
                    axios.patch(`/admin/orders/${currentOrderId}/status`, {
                        status: newStatus
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => {
                        const data = response.data;
                        if (data.success) {
                            // Close modal
                            $('[data-modal-hide="orderModal"]').click();
                            
                            // Refresh the page to show updated data
                            window.location.reload();
                            
                            // Show success message with SweetAlert2
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'rounded-xl shadow-md'
                                }
                            });
                            
                            Toast.fire({
                                icon: 'success',
                                title: 'Order status updated successfully!'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating order status:', error);
                        
                        // Show error message with SweetAlert2
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update order status. Please try again.'
                        });
                    });
                });
            });
        </script>
        @endpush
    </div>
</x-admin-layout>