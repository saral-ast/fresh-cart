<x-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">My Profile</h1>
            <p class="text-gray-600 mt-2">Manage your account details and view your order history.</p>
        </div>

        <!-- Profile Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: User Info and Edit Form -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-lg rounded-xl p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Account Details</h2>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
                    @endif

                    <!-- User Info (Visible by Default) -->
                    <div id="user-info" class="space-y-4">
                        <p><strong class="text-gray-700">Name:</strong> <span class="text-gray-600">{{ $user->name }}</span></p>
                        <p><strong class="text-gray-700">Email:</strong> <span class="text-gray-600">{{ $user->email }}</span></p>
                        <button id="edit-btn" 
                                class="mt-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg 
                                       font-medium transition duration-200 ease-in-out shadow-md hover:shadow-lg">
                            Edit Profile
                        </button>
                    </div>

                    <!-- Edit Form (Hidden by Default) -->
                    <form id="profile-form" action="{{ route('user.profile.update') }}" method="POST" 
                          class="space-y-6 hidden">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 
                                          focus:ring-green-400 focus:border-green-400 transition duration-200 
                                          @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 
                                          focus:ring-green-400 focus:border-green-400 transition duration-200 
                                          @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" 
                                    class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg 
                                           font-medium transition duration-200 ease-in-out shadow-md hover:shadow-lg">
                                Save Changes
                            </button>
                            <button type="button" id="cancel-btn" 
                                    class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg 
                                           font-medium transition duration-200 ease-in-out">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Shipping Addresses Section -->                
                <div class="mt-8 bg-white shadow-lg rounded-xl p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">My Addresses</h2>
                    
                    <div class="space-y-4">
                        @forelse($shippingAddresses as $address)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                                <p class="text-gray-800">{{ $address->address }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->city }}, {{ $address->state }}, {{ $address->postal_code }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->country }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500">No saved addresses found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right: Scrollable Order History -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-lg rounded-xl p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Order History</h2>

                    <div class="max-h-96 overflow-y-auto">
                        @forelse($orders as $order)
                            <div class="border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition duration-200">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="text-lg font-medium text-gray-800">Order #{{ $order->id }}</p>
                                        <p class="text-sm text-gray-600">Placed on: {{ $order->created_at->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-600">Status: 
                                            <span class="capitalize px-2 py-1 rounded-full text-xs 
                                                         {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 
                                                            'bg-yellow-100 text-yellow-700' }}">
                                                {{ $order->status }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-gray-800">${{ number_format($order->total, 2) }}</p>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-gray-700 font-medium mb-2">Items:</h3>
                                    <ul class="space-y-3">
                                        @foreach($order->ordersitem as $item)
                                            <li class="flex justify-between items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <span class="font-medium text-gray-800">{{ $item->product->name }}</span>
                                                    <span>(x{{ $item->quantity }})</span>
                                                </div>
                                                <span class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                                <!-- Shipping Address for this Order -->
                                @if($order->address)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h3 class="text-gray-700 font-medium mb-2">Shipping Address:</h3>
                                    <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">
                                        <p>{{ $order->address->address }}</p>
                                        <p>{{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->postal_code }}</p>
                                        <p>{{ $order->address->country }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 text-lg">No orders found.</p>
                                <a href="/products" class="mt-4 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">Start Shopping</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery + Axios Script -->
    <script>
        $(document).ready(function () {
            // Toggle form visibility with jQuery
            $('#edit-btn').on('click', function () {
                $('#user-info').addClass('hidden');
                $('#profile-form').removeClass('hidden');
            });

            $('#cancel-btn').on('click', function () {
                $('#user-info').removeClass('hidden');
                $('#profile-form').addClass('hidden');
            });

            // Handle form submission with Axios
            $('#profile-form').on('submit', function (e) {
                e.preventDefault();

                // Serialize form data with jQuery
                let formData = $(this).serializeArray();
                let data = {};
                formData.forEach(item => {
                    data[item.name] = item.value;
                });

                // Add CSRF token manually (Laravel requires this for POST requests)
                data['_token'] = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

                console.log('Form Data:', data); // Debug: Check what’s being sent

                axios.post($(this).attr('action'), data)
                    .then(function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Update displayed user info
                        $('#user-info p:first-child span').text(data.name);
                        $('#user-info p:last-child span').text(data.email);

                        // Hide form and show info
                        $('#user-info').removeClass('hidden');
                        $('#profile-form').addClass('hidden');
                    })
                    .catch(function (error) {
                        let errorMessage = '';
                        if (error.response && error.response.data.errors) {
                            Object.values(error.response.data.errors).forEach(err => {
                                errorMessage += err[0] + '<br>';
                            });
                        } else {
                            errorMessage = 'An unexpected error occurred.';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessage,
                        });
                    });
            });
        });
    </script>
</x-layout>