@props(['active' => false])

@php
    $class = 'flex items-center px-4 py-3 rounded-lg transition-all duration-200';

    if ($active) {
        $class .= ' bg-green-50 text-green-600';
    } else {
        $class .= ' text-gray-600 hover:text-green-600 hover:bg-green-50';
    }
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
