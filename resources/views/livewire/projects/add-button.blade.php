<div>
    <x-jet-button wire:click="displayForm" class="flex items-center gap-2">
        <x-icon name="plus" />
        <span class="sr-only sm:not-sr-only">Add Project</span>
    </x-jet-button>

    <x-jet-dialog-modal wire:model="creatingProject" maxWidth="7xl">
        <x-slot:title>Add a New Project</x-slot:title>

        <x-slot:content>
            <div>
                Enter the name of your project, the genre, the word count, and
                what you're seeking, plus any other optional details you'd like
                to include. Depending on what you're seeking, there may be one
                or two required fields at the end. The large text fields use
                <a class="underline" href="#">Markdown</a>.
            </div>

            <x-project submit="createProject" :seeking="$seeking" />
        </x-slot:content>

        <x-slot:footer>
            <x-jet-secondary-button
                wire:click="$set('creatingProject', false)"
                wire:loading.attr="disabled"
            >
                Cancel
            </x-jet-secondary-button>

            <x-jet-button
                class="ml-3"
                wire:click="createProject"
                wire:loading.attr="disabled"
            >
                Add Project
            </x-jet-button>
        </x-slot:footer>
    </x-jet-dialog-modal>
</div>
