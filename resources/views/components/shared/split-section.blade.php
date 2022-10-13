<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="
            px-4 py-5 bg-white sm:p-6 shadow
            {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}
        ">
            <div class="grid gap-6">
                {{ $slot }}
            </div>
        </div>

        @if(isset($actions))
            <x-shared.actions>{{ $actions }}</x-shared.actions>
        @endif
    </div>
</div>
