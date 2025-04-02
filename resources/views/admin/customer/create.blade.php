<x-admin-layout>
    <div class="p-6 md:p-10 space-y-8">
       
        
        <div class="w-full max-w-2xl mx-auto bg-white rounded-xl shadow-lg px-8 py-6">
            <h2 class="text-2xl md:text-2xl font-bold text-gray-800 flex items-center justify-center">
                <span class="material-icons mr-2 text-gray-600">person_add</span>
                Add New Customer
            </h2>
            <x-forms.form method="POST" action="{{ route('admin.customers.store') }}" id="create-customer">
                @csrf
                <div class="space-y-4">
                    <x-forms.input label="Name" name="name" type="text" placeholder="Enter customer name" id="customerName">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">person</i>
                    </x-forms.input>
                    <x-forms.input label="Email" name="email" type="email" placeholder="Enter customer email" id="customerEmail">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">email</i>
                    </x-forms.input>
                    <x-forms.input label="Phone" name="phone" type="tel" placeholder="Enter phone number" id="customerPhone">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">phone</i>
                    </x-forms.input>
                    <x-forms.input label="Password" name="password" type="password" placeholder="Enter password" id="customerPassword">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">lock</i>
                    </x-forms.input>
                    <x-forms.input label="Confirm Password" name="password_confirmation" type="password" placeholder="Confirm password" id="customerPasswordConfirmation">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">lock_outline</i>
                    </x-forms.input>
                    
                    <x-forms.field label="Status" name="status">
                        <div class="relative">
                            <select name="status" id="status" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="true">Active</option>
                                <option value="false">Inactive</option>
                            </select>
                            <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">toggle_on</span>
                        </div>
                    </x-forms.field>
                </div>

                <x-forms.button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center font-semibold flex items-center justify-center">
                    <i class="material-icons mr-2">save</i>
                    Add Customer
                </x-forms.button>
                <p class="text-sm text-gray-600 mt-3 text-center">
                    <a href="{{ route('admin.customers') }}" class="text-green-600 hover:underline"><- Back to Customer</a>
                </p>
            </x-forms.form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.validator.addMethod("phoneFormat", function(value, element) {
                return this.optional(element) || /^\+?[1-9]\d{9,14}$/.test(value);
            }, "Please enter a valid phone number");

            $("#create-customer").validate({
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
                        required: true,
                        minlength: 6,
                    },
                    password_confirmation: {
                        required: true,
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
                        required: "Please enter a password",
                        minlength: "Password must be at least 6 characters long",
                        // pattern: "Password must contain at least one uppercase letter, one lowercase letter, and one number"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorClass: "text-red-500 text-sm mt-1",
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("border-red-500").removeClass("border-gray-300");
                },
                unhighlight: function(element) {
                    $(element).removeClass("border-red-500").addClass("border-gray-300");
                }
            });
        });
    </script>
</x-admin-layout>