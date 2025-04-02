<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm p-6 md:p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $page->title }}</h1>
            
            <div class="prose max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>

    @if(request()->routeIs('page') && request('slug') === 'contact-us')
        <x-nav-link href="{{ route('page', 'term-ad-condition') }}">Terms And Condition</x-nav-link>
    @endif
</x-layout>
