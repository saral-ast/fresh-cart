<x-admin-layout>
    <div class="flex items-center justify-center h-auto p-6 mt-25">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg px-8 py-6">
            <h1 class="text-2xl font-bold text-gray-900 text-center mb-4">
                <span class="material-icons mr-2 align-middle">description</span>Edit Static Page
            </h1>

            <x-forms.form method="POST" action="{{ route('admin.static-pages.update', $staticPage) }}" id="edit-static-page">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">title</span>
                        <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}" 
                               class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                               required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">link</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $staticPage->slug) }}" 
                               class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                               required>
                            <p class="text-xs text-gray-500 mt-1">URL-friendly name for the page (e.g., about-us, terms-of-service)</p>
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <div class="relative">
                        <span class="material-icons absolute left-3 top-3 text-gray-500">edit_note</span>
                        <textarea name="content" id="summernote" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                                  rows="6">{{ old('content', $staticPage->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center">
                    <span class="material-icons mr-2 text-gray-500">toggle_on</span>
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                           {{ old('is_active', $staticPage->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.static-pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex items-center">
                    <span class="material-icons mr-1 text-sm">arrow_back</span>
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex items-center">
                    <span class="material-icons mr-1 text-sm">save</span>
                    Update Static Page
                </button>
            </div>
        </x-forms.form>

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
            $('#title').on('blur', function() {
                if ($('#slug').val() === '') {
                    const title = $(this).val();
                    $.get('/admin/generate-slug', { name: title }, function(data) {
                        $('#slug').val(data.slug);
                        console.log(data.slug);
                    });
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>