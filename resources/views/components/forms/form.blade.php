<form {{ $attributes->merge(["class" => "max-w-2xl mx-auto space-y-6"]) }}>
    @csrf
    @if (strtoupper($attributes->get('method', 'POST')) !== 'GET' && strtoupper($attributes->get('method', 'POST')) !== 'POST')
        @method($attributes->get('method'))
    @endif

    {{ $slot }}
</form>
