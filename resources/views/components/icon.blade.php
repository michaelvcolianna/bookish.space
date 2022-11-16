@props(['name'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" {{ $attributes->merge(['class' => 'h-4 w-4', 'height' => 24, 'width' => 24, 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => 2, 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round']) }}>
    <x-dynamic-component component="icon.{{ $name }}" />
</svg>
