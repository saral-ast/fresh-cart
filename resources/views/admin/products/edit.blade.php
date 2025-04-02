<x-admin-layout>
    <div class="flex items-center justify-center h-auto p-6 mt-25">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-4">
                <i class="material-icons align-middle mr-2">edit</i>Edit Product
            </h1>

            <x-forms.form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data" id="edit-product">
                @csrf
                @method('PATCH')
                <div class="space-y-4">
                    <x-forms.input label="Product Name" name="name" type="text" placeholder="Enter product name" id="productName" value="{{ $product->name }}">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">inventory_2</i>
                    </x-forms.input>
                    <x-forms.input label="Slug" name="slug" type="text" placeholder="Auto Generated Slug" id="productSlug" value="{{ $product->slug }}">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">link</i>
                    </x-forms.input>
                    
                    <x-forms.field label="Category" name="category_id">
                        {{-- <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">category</i> --}}
                        <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </x-forms.field>

                    <x-forms.field label="Description" name="description">
                        {{-- <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">description</i> --}}
                        <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Enter product description">{{ $product->description }}</textarea>
                    </x-forms.field>

                    <div class="grid grid-cols-2 gap-4">
                        <x-forms.input label="Price" name="price" type="number" step="0.01" placeholder="Enter price" value="{{ $product->price }}">
                            <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">attach_money</i>
                        </x-forms.input>
                    </div>

                    <x-forms.field label="Featured" name="featured">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="featured" class="form-checkbox h-5 w-5 text-green-600" value="1" {{ $product->featured ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">
                                <i class="material-icons align-middle text-amber-500 mr-1">star</i>
                                Mark as featured product
                            </span>
                        </label>
                    </x-forms.field>

                    <!-- Product Image Upload with Preview -->
                    <x-forms.field label="Product Image" name="image">
                        <label class="block w-full cursor-pointer">
                            <div class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-900 
                                        hover:bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                <i class="material-icons text-gray-500 mr-2">cloud_upload</i>
                                <span id="fileLabel" class="text-gray-500">Choose an image...</span>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden">
                            </div>
                        </label>

                        <!-- Current Image Preview -->
                        <div id="currentImageContainer" class="mt-4">
                            <p class="text-gray-600 text-sm">
                                <i class="material-icons align-middle text-gray-500 mr-1">image</i>
                                Current Image:
                            </p>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Product Image" class="mt-2 rounded-lg shadow-md max-h-40">
                        </div>

                        <!-- New Image Preview Section -->
                        <div id="imagePreviewContainer" class="mt-4 hidden">
                            <p class="text-gray-600 text-sm">
                                <i class="material-icons align-middle text-gray-500 mr-1">image</i>
                                New Image Preview:
                            </p>
                            <img id="imagePreview" src="" alt="New Image Preview" class="mt-2 rounded-lg shadow-md max-h-40">
                        </div>
                    </x-forms.field>
                </div>

                <x-forms.button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center font-semibold">
                    Update Product
                </x-forms.button>

                <p class="text-sm text-gray-600 mt-3 text-center">
                    <a href="{{ route('admin.product.index') }}" class="text-green-600 hover:underline"><- Back to Products</a>
                </p>
            </x-forms.form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Generate the slug
                $("#productName").on("keyup", function () {
                    let productName = $(this).val().trim();

                    if (productName.length > 0) {
                        axios.get("/admin/generate-slug", {
                            params: { name: productName }
                        })
                        .then(function (response) {
                            $("#productSlug").val(response.data.slug);
                        })
                        .catch(function (error) {
                            console.error("Slug generation failed:", error);
                        });
                    } else {
                        $("#productSlug").val("");
                    }
                });

                // Image preview functionality

                
                // Form validation
                $('#edit-product').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 2
                        },
                        slug: {
                            required: true,
                            minlength: 2
                        },
                        category_id: {
                            required: true
                        },
                        description: {
                            required: true,
                            minlength: 10
                        },
                        price: {
                            required: true,
                            number: true,
                            min: 0
                        }
                    },
                    messages: {
                        name: {
                            required: 'Please enter product name',
                            minlength: 'Name must be at least 2 characters'
                        },
                        slug: {
                            required: 'Please enter product slug',
                            minlength: 'Slug must be at least 2 characters'
                        },
                        category_id: {
                            required: 'Please select a category'
                        },
                        description: {
                            required: 'Please enter product description',
                            minlength: 'Description must be at least 10 characters'
                        },
                        price: {
                            required: 'Please enter product price',
                            number: 'Please enter a valid price',
                            min: 'Price must be greater than or equal to 0'
                        }
                    },
                    errorPlacement: function(error, element) {
                        error.addClass('text-red-500');
                        error.insertAfter(element);
                    },
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid').addClass('is-valid');
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>