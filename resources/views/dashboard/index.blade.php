<x-admin-layout>
    <div class="p-10 space-y-6">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between 
                    bg-cover bg-center h-50" 
             style="background-image: url('{{ asset('images/grocery-banner.png') }}');">
            <div>
                <h1 class="text-2xl font-bold">Welcome back! FreshCart</h1>
                <p class="text-gray-600">FreshCart is a simple & clean design for developers and designers.</p>
                <button class="bg-green-600 text-white px-4 py-2 mt-4 rounded-md">Create Product</button>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-red-100 text-red-600 p-2 rounded-full">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
                <p class="text-gray-500">Earnings</p>
                <h2 class="text-2xl font-bold">${{$totalEarnings ?? 0}}</h2>
                <p class="text-sm text-gray-500">Monthly revenue</p>
            </div>

            <!-- Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-yellow-100 text-yellow-600 p-2 rounded-full">
                    <i class="fa-solid fa-shopping-cart"></i>
                </div>
                <p class="text-gray-500">Orders</p>
                <h2 class="text-2xl font-bold">{{$totalOrders}}</h2>
                <p class="text-sm text-gray-500">10+ New Sales</p>
            </div>

            <!-- Customers Card -->
            <div class="bg-white p-6 rounded-lg shadow-md relative">
                <div class="absolute top-4 right-4 bg-blue-100 text-blue-600 p-2 rounded-full">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-gray-500">Customers</p>
                <h2 class="text-2xl font-bold">{{$totalCustomers}}</h2>
                <p class="text-sm text-gray-500">30+ new in 2 days</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
            <section class="bg-white p-8 antialiased md:p-12">
                <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Order Management</h2>
                    <p class="mt-1 text-sm text-gray-500">View and manage all customer orders</p>
                </div>
        
                <div class="mt-6 overflow-x-auto bg-white border border-gray-200 rounded-lg shadow-md">
                    <table class="w-full text-left">
                        <thead class="bg-gray-100">
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
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm font-medium text-white rounded-lg" 
                                            style="background-color: 
                                                {{ $order->status == 'completed' ? 'green' : 
                                                ($order->status == 'processing' ? 'blue' : 
                                                ($order->status == 'cancelled' ? 'red' : 'orange')) }};"> 
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" 
                                            class="preview-btn px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300"
                                            data-order-id="{{ $order->id }}"
                                            data-modal-target="orderModal"
                                            data-modal-toggle="orderModal">
                                            Preview
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No orders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        
                <!-- Order Modal -->
                <div id="orderModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 border-b rounded-t">
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
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Order ID</p>
                                        <p class="text-base font-medium text-gray-900" id="modal-order-id"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Date</p>
                                        <p class="text-base font-medium text-gray-900" id="modal-order-date"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Customer</p>
                                        <p class="text-base font-medium text-gray-900" id="modal-customer-name"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-500">Total</p>
                                        <p class="text-base font-medium text-gray-900" id="modal-order-total"></p>
                                    </div>
                                </div>
                                
                                <!-- Payment Information Section -->
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-gray-500 mb-2">Payment Information</p>
                                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-500">Payment Status</p>
                                            <p class="text-base font-medium text-gray-900" id="modal-payment-status"></p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-500">Payment Amount</p>
                                            <p class="text-base font-medium text-gray-900" id="modal-payment-amount"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Address Information Section -->
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-gray-500 mb-2">Shipping Address</p>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-base font-medium text-gray-900" id="modal-address-full"></p>
                                        <p class="text-sm text-gray-500" id="modal-address-city-state"></p>
                                        <p class="text-sm text-gray-500" id="modal-address-country-postal"></p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-gray-500 mb-2">Order Status</p>
                                    <select id="order-status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-sm font-semibold text-gray-500 mb-2">Order Items</p>
                                    <div class="overflow-x-auto relative">
                                        <table class="w-full text-sm text-left text-gray-500">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3 px-6">Product</th>
                                                    <th scope="col" class="py-3 px-6">Quantity</th>
                                                    <th scope="col" class="py-3 px-6">Price</th>
                                                    <th scope="col" class="py-3 px-6">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="order-items-container">
                                                <!-- Order items will be inserted here via JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    </div>
</x-admin-layout>
