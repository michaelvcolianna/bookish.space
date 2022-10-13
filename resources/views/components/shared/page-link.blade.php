@props(['route', 'label' => null])

<a
    href="{{ route($route) }}"
    {{ $attributes->merge(['class' => 'text-sm text-gray-700 underline']) }}
>
    {{ $label ?? $slot }}
</a>
