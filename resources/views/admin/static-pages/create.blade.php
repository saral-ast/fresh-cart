<x-admin-layout>
    <div class="flex items-center justify-center h-auto p-6 mt-25">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-4">
                <span class="material-icons mr-2 align-middle">description</span>Create Static Page
            </h1>

            <x-forms.form method="POST" action="{{ route('admin.static-pages.store') }}" id="create-static-page">
                @csrf

                <div class="space-y-4">
                    <x-forms.input label="Title" name="title" type="text" placeholder="Enter page title" id="title">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">title</i>
                    </x-forms.input>
                    <x-forms.input label="Slug" name="slug" type="text" placeholder="Auto Generated Slug" id="pageSlug">
                        <i class="material-icons text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2">link</i>
                    </x-forms.input>
                    <p class="text-xs text-gray-500 mt-1">The slug will be used in the page URL.</p>

                    <x-forms.field label="Content" name="content">
                        <div class="relative">
                            <i class="material-icons text-gray-500 absolute left-3 top-3">edit_note</i>
                            <textarea name="content" id="summernote" class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                      rows="6">{{ old('content') }}</textarea>
                        </div>
                    </x-forms.field>

                    <x-forms.field label="Active" name="is_active">
                        <label class="inline-flex items-center">
                            <span class="material-icons mr-2 text-gray-500">toggle_on</span>
                            <input type="checkbox" name="is_active" id="is_active" class="form-checkbox h-5 w-5 text-green-600" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Mark as active page</span>
                        </label>
                    </x-forms.field>
                </div>

                <x-forms.button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-center font-semibold flex items-center justify-center">
                    <i class="material-icons mr-2">save</i>
                    Create Page
                </x-forms.button>

                <p class="text-sm text-gray-600 mt-3 text-center">
                    <a href="{{ route('admin.static-pages.index') }}" class="text-green-600 hover:underline flex items-center justify-center">
                        <- Back to Pages
                    </a>
                </p>
            </x-forms.form>
        </div>
    </div>

    @push('scripts')
    <!-- Include Summernote CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Enter your content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            let isSlugEdited = false;

            $('#pageSlug').on('input', function() {
                isSlugEdited = true;
            });

            $('#title').on('blur', function() {
                if (!isSlugEdited) {
                    const title = $(this).val().trim();
                    if (title !== '') {
                        $.ajax({
                            url: '/admin/generate-slug',
                            type: 'GET',
                            data: { name: title },
                            success: function(response) {
                                $('#pageSlug').val(response.slug);
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>