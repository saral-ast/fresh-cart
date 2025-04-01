<x-layout>
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Checkout</h1>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="md:col-span-2 bg-white p-6 md:p-8 rounded-lg shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold mb-6 text-gray-700 border-b pb-3">Billing Details</h2>
                <x-forms.form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" class="space-y-5">
                    @csrf
                    
                    <!-- User Details -->
                    <div class="space-y-4">
                        <x-forms.input label="Full Name" name="name" placeholder="Enter your full name" value="{{ $user->name }}" class="focus:ring-green-500" />
                        <x-forms.input label="Email" name="email" type="email" placeholder="example@email.com" value="{{ $user->email }}" class="focus:ring-green-500" />
                        <x-forms.input label="Phone" name="phone" type="tel" placeholder="1234567890" value="{{ $user->phone }}" class="focus:ring-green-500" />
                    </div>

                    <!-- Saved Addresses Section - Only show if addresses exist -->
                    @if($user->addresses->count() > 0)
                    <div class="pt-4" id="saved-addresses-section">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Saved Addresses</h3>
                        <div class="space-y-4">
                            @foreach($user->addresses as $address)
                                <div class="flex items-start space-x-3 p-4 border rounded-lg hover:border-green-500 transition-colors 
                                    {{ $address->is_default ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                    <input type="radio" name="saved_address" id="address_{{ $address->id }}" 
                                        value="{{ $address->id }}" 
                                        class="mt-1 saved-address-radio"
                                        data-address="{{ $address->address }}"
                                        data-city="{{ $address->city }}"
                                        data-state="{{ $address->state }}"
                                        data-country="{{ $address->country }}"
                                        data-postal_code="{{ $address->postal_code }}"
                                        {{ $address->is_default ? 'checked' : '' }}>
                                    <label for="address_{{ $address->id }}" class="flex-1 cursor-pointer">
                                        <div class="font-medium">{{ $address->address }}</div>
                                        <div class="text-sm text-gray-600">
                                            {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                        </div>
                                        <div class="text-sm text-gray-600">{{ $address->country }}</div>
                                        @if($address->is_default)
                                            <span class="text-xs text-green-600 mt-1">Default Address</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                            
                            <div class="mt-4 flex justify-between items-center">
                                <button type="button" id="add-new-address" class="text-green-600 hover:underline">
                                    Add New Address
                                </button>
                                <span class="text-gray-500 text-sm">or</span>
                                <button type="button" id="toggle-new-address" class="text-blue-600 hover:underline">
                                    Enter New Address
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- New Address Section -->
                    <div class="pt-4 new-address-section" style="display: none;">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">
                            {{ $user->addresses->count() > 0 ? 'New Address' : 'Shipping Address' }}
                        </h3>
                        <div class="space-y-4">
                            <x-forms.input label="Address" name="address" placeholder="Street address or P.O. Box" class="focus:ring-green-500" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-forms.input label="City" name="city" placeholder="Your city" class="focus:ring-green-500" />
                                <x-forms.select label="State" name="state" class="focus:ring-green-500">
                                    <option value="">Select State</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                </x-forms.select>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-forms.select label="Country" name="country" class="focus:ring-green-500">
                                    <option value="">Select Country</option>
                                    <option value="India">India</option>
                                </x-forms.select>
                                <x-forms.input label="ZIP Code" name="postal_code" placeholder="12345" class="focus:ring-green-500" />
                            </div>
                            <div class="mt-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="make_default" class="text-green-600 focus:ring-green-500 rounded">
                                    <span class="ml-2 text-gray-700">Set as default address</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="pt-4">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Payment Method</h3>
                        <x-forms.select label="Payment Method" name="payment_method" class="focus:ring-green-500">
                            <option value="">Select Payment Method</option>
                            <option value="cod">Cash on Delivery</option>
                            <option value="credit_card">Credit/Debit Card</option>
                            <option value="paypal">PayPal</option>
                        </x-forms.select>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <x-forms.button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-center font-semibold transition duration-200 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            Place Order
                        </x-forms.button>
                    </div>
                </x-forms.form>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg shadow-lg border border-gray-100 h-fit">
                <div class="p-6 md:p-8">
                    <h2 class="text-xl font-bold mb-5 text-gray-800 border-b pb-3">Order Summary</h2>
                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1 mb-4">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                                <div class="flex-1">
                                    <p class="text-gray-800 font-medium">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="text-gray-900 font-semibold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="space-y-2 pt-2 border-t border-gray-200">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200">
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-6 bg-gray-100 p-4 rounded-md text-sm text-gray-600">
                        <p class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg> 
                            Secure checkout
                        </p>
                        <p class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> 
                            Fast delivery
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    $(document).ready(function() {
        const form = $("#checkout-form");
        const newAddressSection = $('.new-address-section');
        const savedAddressesSection = $('#saved-addresses-section');
        const newAddressFields = $('input[name="address"], input[name="city"], select[name="state"], select[name="country"], input[name="postal_code"]');
        const savedAddressRadios = $('.saved-address-radio');

        // Form Validation
        form.validate({
            rules: {
                name: { 
                    required: true, 
                    minlength: 3 
                },
                email: { 
                    required: true, 
                    email: true 
                },
                phone: { 
                    required: true, 
                    digits: true, 
                    minlength: 10, 
                    maxlength: 10 
                },
                saved_address: {
                    required: function() {
                        return newAddressSection.is(':hidden');
                    }
                },
                address: {
                    required: function() {
                        return newAddressSection.is(':visible');
                    }
                },
                city: {
                    required: function() {
                        return newAddressSection.is(':visible');
                    }
                },
                state: {
                    required: function() {
                        return newAddressSection.is(':visible');
                    }
                },
                country: {
                    required: function() {
                        return newAddressSection.is(':visible');
                    }
                },
                postal_code: {
                    required: function() {
                        return newAddressSection.is(':visible');
                    },
                    digits: true,
                    minlength: 5,
                    maxlength: 6
                },
                payment_method: { 
                    required: true 
                }
            },
            messages: {
                name: {
                    required: "Please enter your full name",
                    minlength: "Name must be at least 3 characters"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email"
                },
                phone: {
                    required: "Please enter your phone number",
                    digits: "Phone number must be numeric",
                    minlength: "Phone number must be 10 digits",
                    maxlength: "Phone number must be 10 digits"
                },
                saved_address: {
                    required: "Please select a saved address"
                },
                address: {
                    required: "Please enter your address"
                },
                city: {
                    required: "Please enter your city"
                },
                state: {
                    required: "Please select a state"
                },
                country: {
                    required: "Please select a country"
                },
                postal_code: {
                    required: "Please enter your ZIP Code",
                    digits: "ZIP Code must be numeric",
                    minlength: "ZIP Code must be at least 5 digits",
                    maxlength: "ZIP Code cannot exceed 6 digits"
                },
                payment_method: {
                    required: "Please select a payment method"
                }
            },
            errorClass: "text-red-500 text-sm",
            errorPlacement: function(error, element) {
                if (element.attr("name") === "saved_address") {
                    error.insertBefore(savedAddressesSection);
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Toggle New Address Section
        $('#toggle-new-address, #add-new-address').on('click', function() {
            // Deselect saved addresses
            savedAddressRadios.prop('checked', false);
            
            // Toggle new address section
            if (newAddressSection.is(':hidden')) {
                newAddressSection.slideDown(300);
                // Enable new address fields
                newAddressFields.prop('disabled', false);
            } else {
                newAddressSection.slideUp(300);
                // Disable and clear new address fields
                newAddressFields.prop('disabled', true).val('');
            }
        });

        // Saved Address Selection
        savedAddressRadios.on('change', function() {
            if ($(this).is(':checked')) {
                // Hide and clear new address section
                newAddressSection.slideUp(300);
                newAddressFields.prop('disabled', true).val('');

                // Populate form with selected address data
                $('input[name="address"]').val($(this).data('address'));
                $('input[name="city"]').val($(this).data('city'));
                $('select[name="state"]').val($(this).data('state'));
                $('select[name="country"]').val($(this).data('country'));
                $('input[name="postal_code"]').val($(this).data('postal_code'));
            }
        });

        // If no saved addresses, show new address section by default
        @if($user->addresses->count() === 0)
            newAddressSection.show();
            $('#toggle-new-address, #add-new-address').hide();
        @endif
    });
    </script>
    @endpush
</x-layout>