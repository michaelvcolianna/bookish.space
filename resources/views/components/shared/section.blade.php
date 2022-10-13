<div {{ $attributes->merge(['class' => 'block']) }}>
    <div class="
        px-4 py-5 bg-white sm:p-6 shadow
        {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}
    ">
        {{ $slot }}
    </div>

    @if(isset($actions))
        <x-shared.actions>{{ $actions }}</x-shared.actions>
    @endif
</div>
