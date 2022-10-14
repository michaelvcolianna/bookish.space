<div>
    <x-jet-button wire:click="displayForm">
        Add New Project
    </x-jet-button>

    <x-jet-dialog-modal wire:model="displayingForm">
        <x-slot name="title">
            New Project
        </x-slot>

        <x-slot name="content">
            <div class="text-gray-600 mt-2 mb-6">
                Enter the name of your project and what you're seeking for it.
                Your project will be created as "unlisted" to begin with, so you
                can fill in the other fields without worrying whether anyone
                will see it unfinished.
            </div>

            <div>
                <x-jet-label for="project-title" value="Title" />
                <x-jet-input
                    class="block mt-1 w-full"
                    id="project-title"
                    type="text"
                    wire:model="title"
                    required
                    autofocus
                />
                <x-jet-input-error for="title" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="project-seeking" value="Seeking" />
                <select
                    class="
                        border-gray-300 focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 rounded-md
                        shadow-sm mt-1 w-full
                    "
                    id="project-seeking"
                    wire:model="seeking"
                    required
                >
                    <option value="null" disabled>--- Choose ---</option>
                    @foreach(App\Models\Project::SEEKING as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="seeking" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                wire:click="$set('displayingForm', false)"
                wire:loading.attr="disabled"
            >
                Cancel
            </x-jet-secondary-button>

            <x-jet-button
                class="ml-3"
                wire:click="addProject"
                wire:loading.attr="disabled"
            >
                Add Project
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
