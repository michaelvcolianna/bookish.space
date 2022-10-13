@props(['label' => null])

<div {{ $attributes->merge(['class' => 'py-2 px-4 shadow-md rounded-full text-white font-bold text-xs uppercase'])}}>
    {{ $label ?? $slot }}
</div>
