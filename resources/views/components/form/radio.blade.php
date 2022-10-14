@props(['id', 'model' => null, 'value' => null, 'label'])

<div class="flex items-center gap-2">
    <input
        id="{{ $id }}"
        type="radio"
        wire:model="{{ $model ?? $id }}"
        value="{{ $value ?? $id }}"
        class="
            w-4 h-4 text-blue-600 bg-gray-100 border-gray-300
            focus:ring-blue-500 focus:ring-2
        "
    />
    <label for="{{ $id }}">{{ $label }}</label>
</div>
