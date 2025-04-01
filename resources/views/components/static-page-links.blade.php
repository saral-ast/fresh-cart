@php
    use App\Helpers\StaticPageHelper;
    $staticPages = StaticPageHelper::getAllPages();
@endphp

@if(count($staticPages) > 0)
<div class="footer-links">
    <h5 class="text-lg font-semibold mb-4">Important Links</h5>
    <ul class="space-y-2">
        @foreach($staticPages as $page)
        <li>
            <a href="{{ route('page', $page->slug) }}" class="text-gray-500 hover:text-green-500 transition">
                {{ $page->title }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif