<x-admin-layout>
    <div class="flex items-center justify-center h-auto p-6 mt-25">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-4">
                <i class="material-icons align-middle mr-2">add_circle</i>Add New Category
            </h1>

            <x-forms.form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" id="create-catagory">
                @csrf
                <div class="space-y-4">
                    <x-forms.input label="Category Name" name="name" type="text" placeholder="Enter category name" id="categoryName">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">category</i>
                    </x-forms.input>
                    
                    <x-forms.input label="Slug" name="slug" type="text" placeholder="Auto Generated Slug" id="categorySlug">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">link</i>
                    </x-forms.input>

                    <x-forms.field label="Featured" name="featured">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="featured" class="form-checkbox h-5 w-5 text-green-600" value="1">
                            <span class="ml-2 text-gray-700">
                                <i class="material-icons align-middle text-amber-500 mr-1">star</i>
                                Mark as featured category
                            </span>
                        </label>
                    </x-forms.field>

                    <!-- Category Image Upload with Preview -->
                    <x-forms.field label="Category Image" name="image">
                        <label class="block w-full cursor-pointer">
                            <div class="flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-900 
                                        hover:bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                <i class="material-icons text-gray-500 mr-2">cloud_upload</i>
                                <span id="fileLabel" class="text-gray-500">Choose an image...</span>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" required>
                            </div>
                        </label>

                        <!-- Image Preview Section -->
                        <div id="imagePreviewContainer" class="mt-4 hidden">
                            <p class="text-gray-600 text-sm">
                                <i class="material-icons align-middle text-gray-500 mr-1">image</i>
                                Selected Image:
                            </p>
                            <img id="imagePreview" src="" alt="Image Preview" class="mt-2 rounded-lg shadow-md max-h-40">
                        </div>
                    </x-forms.field>
                </div>

                <x-forms.button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center font-semibold flex items-center justify-center">
                    <i class="material-icons mr-2">save</i>
                    Add Category
                </x-forms.button>

                <p class="text-sm text-gray-600 mt-3 text-center">
                    <a href="{{ route('admin.categories') }}" class="text-green-600 hover:underline flex items-center justify-center">
                        {{-- <i class="material-icons text-sm mr-1">arrow_back</i> --}}
                        <-  Back to Categories
                    </a>
                </p>
            </x-forms.form>
        </div>
    </div>

    <!-- jQuery for Image Preview & Filename -->
    <!-- Add Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Display filename when a file is selected
                $("#imageInput").on("change", function() {
                    const fileName = $(this).val().split('\\').pop();
                    $("#fileLabel").text(fileName || "Choose an image...");
                    
                    // Preview the image
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $("#imagePreview").attr('src', e.target.result);
                            $("#imagePreviewContainer").removeClass('hidden');
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
                
                //generate the slug
                $("#categoryName").on("keyup", function () {
                    let categoryName = $(this).val().trim();

                    if (categoryName.length > 0) {
                        axios.get("/admin/generate-slug", {
                            params: { name: categoryName }
                        })
                        .then(function (response) {
                            $("#categorySlug").val(response.data.slug);
                        })
                        .catch(function (error) {
                            console.error("Slug generation failed:", error);
                        });
                    } else {
                        $("#categorySlug").val(""); // Clear slug if input is empty
                    }
                });

                $('#create-catagory').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 2,
                        },
                        slug: {
                            required: true,
                            minlength: 2,
                        },
                        image: {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: 'Please enter your name',
                            minlength: 'Name must be at least 2 characters',
                        },
                        slug: {
                            required: 'Please enter your slug',
                            minlength: 'Slug must be at least 2 characters',
                        },
                        image: {
                            required: 'Please select an image',
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.addClass('text-red-500');
                        error.insertAfter(element);
                    },
                    highlight: function (element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid').addClass('is-valid');
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>