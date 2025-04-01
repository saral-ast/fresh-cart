<x-layout>

{{-- @section('title', $page->meta_title ?? $page->title)

@section('meta')
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">
@endsection --}}


<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>
        
        <div class="prose max-w-none">
            {!! $page->content !!}
        </div>
    </div>
</div>


</x-layout>