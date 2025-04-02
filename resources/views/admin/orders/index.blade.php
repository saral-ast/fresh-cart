<x-admin-layout>    
    <section class="bg-white p-6 md:p-10 space-y-8 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Order Management</h2>
            <p class="mt-1 text-sm text-gray-500">View and manage all customer orders</p>
        </div>

        <div class="mt-6 overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 border-b">Order ID</th>
                        <th class="px-6 py-3 border-b">Customer</th>
                        <th class="px-6 py-3 border-b">Date</th>
                        <th class="px-6 py-3 border-b">Total</th>
                        <th class="px-6 py-3 border-b">Status</th>
                        <th class="px-6 py-3 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4">
                                {{ $order->created_at->format('d M Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 font-medium">${{ number_format($order->total, 2) }}</td>
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
                                    class="preview-btn px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all"
                                    data-order-id="{{ $order->id }}"
                                    data-modal-target="orderModal"
                                    data-modal-toggle="orderModal">
                                    <i class="mdi mdi-eye mr-1"></i> Preview
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
            <div class="px-6 py-4">
                {{ $orders->links() }}
            </div>
            {{-- {{ $or ders->links() }} --}}
        </div>

        <!-- Order Modal -->
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
                    <div>
                        
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b">
                        <button data-modal-hide="orderModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Close</button>
                        <button type="button" id="update-status-btn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update Status</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            console.log(data);
                            
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
                                const row = $('<tr>').addClass('bg-white border-b');
                                row.html(`
                                    <td class="py-4 px-6">${item.product.name}</td>
                                    <td class="py-4 px-6">${item.quantity}</td>
                                    <td class="py-4 px-6">$${item.price}</td>
                                    <td class="py-4 px-6">$${(item.quantity * item.price).toFixed(2)}</td>
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
                        
                        // Update status in the table
                        const statusCell = $(`[data-order-id="${currentOrderId}"]`).closest('tr').find('td:nth-child(5) span');
                        statusCell.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                        
                        // Update status color
                        const statusColor = 
                            newStatus === 'completed' ? 'green' : 
                            newStatus === 'processing' ? 'blue' : 
                            newStatus === 'cancelled' ? 'red' : 'orange';
                        statusCell.css('backgroundColor', statusColor);
                        
                        // Show success message with SweetAlert2
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
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
</x-admin-layout>