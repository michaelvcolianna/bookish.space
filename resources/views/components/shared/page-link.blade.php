<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $label ?? $slot }}
</a>
