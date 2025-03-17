<x-admin-layout>
    <div class="flex items-center justify-center h-auto p-6 mt-25">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-4">
                Edit Customer
            </h1>

            <x-forms.form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" id="edit-customer">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <x-forms.input label="Name" name="name" type="text" placeholder="Enter customer name" id="customerName" value="{{ $customer->name }}" />
                    <x-forms.input label="Email" name="email" type="email" placeholder="Enter customer email" id="customerEmail" value="{{ $customer->email }}" />
                    <x-forms.input label="Phone" name="phone" type="tel" placeholder="Enter phone number" id="customerPhone" value="{{ $customer->phone }}" />
                    {{-- <x-forms.input label="Password" name="password" type="password" placeholder="Leave blank to keep current password" id="customerPassword" /> --}}
                    {{-- <x-forms.input label="Confirm Password" name="password_confirmation" type="password" placeholder="Confirm new password" id="customerPasswordConfirmation" /> --}}
                    
                    <x-forms.field label="Status" name="status">
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="active" {{ $customer->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $customer->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="banned" {{ $customer->status === 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </x-forms.field>
                </div>

                <x-forms.button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center font-semibold">
                    Update Customer
                </x-forms.button>
            </x-forms.form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.validator.addMethod("phoneFormat", function(value, element) {
                return this.optional(element) || /^\+?[1-9]\d{9,14}$/.test(value);
            }, "Please enter a valid phone number");

            $("#edit-customer").validate({
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
                        phoneFormat: true
                    },
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        minlength: 6,
                        equalTo: "#customerPassword"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    phone: {
                        required: "Please enter your phone number"
                    },
                    password: {
                        minlength: "Password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        minlength: "Password must be at least 6 characters long",
                        equalTo: "Passwords do not match"
                    }
                },
                errorClass: "text-red-500 text-sm mt-1",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('border-red-500').removeClass('border-gray-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500').addClass('border-gray-300');
                }
            });
        });
    </script>
</x-admin-layout>