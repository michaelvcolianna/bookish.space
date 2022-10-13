<x-shared.section>
    <div>{{ $project->title }} (more details to come)</div>

    <x-slot:actions>
        <x-jet-danger-button
            wire:click="$set('confirmingProjectDeletion', true)"
        >
            Delete Project
        </x-jet-danger-button>

        <x-jet-secondary-button class="ml-4" wire:click="editProject">
            Edit Project
        </x-jet-secondary-button>
    </x-slot:actions>

    <x-jet-confirmation-modal wire:model="confirmingProjectDeletion">
        <x-slot name="title">
            Delete Project
        </x-slot>

        <x-slot name="content">
            Are you sure you would like to delete this project?
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                wire:click="$toggle('confirmingProjectDeletion')"
                wire:loading.attr="disabled"
            >
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button
                class="ml-3"
                wire:click="deleteProject"
                wire:loading.attr="disabled"
            >
                Delete
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</x-shared.section>
