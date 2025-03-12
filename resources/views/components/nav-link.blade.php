@props(['active' => false])

@php
    $class = 'inline-flex items-center transition-colors duration-200';

    if ($active) {
        $class .= ' text-green-600 font-medium';
    } else {
        $class .= ' text-gray-600 hover:text-green-600 font-medium';
    }
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
