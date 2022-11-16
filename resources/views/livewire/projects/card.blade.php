<div class="sm:rounded-lg shadow-md">
    <div class="bg-white p-4 grid gap-4">
        @if($editingProject)
            <h2 class="text-xl font-bold">
                Project Settings
            </h2>

            <x-project submit="saveProject" :project="$project" />
        @else
            <h2 class="text-xl font-bold">
                <a class="underline underline-offset-2" href="{{ $project->url() }}">
                    {{ $project->title }}
                </a>
            </h2>

            <div class="flex flex-wrap gap-x-4 text-sm text-gray-600">
                <div>
                    <strong>Updated:</strong>
                    <span>{{ $project->updated_at->diffForHumans() }}</span>
                </div>

                <div>
                    <strong>Seeking:</strong>
                    <span>{{ $project->seeking_label }}</span>
                </div>

                <div>
                    <strong>Genre:</strong>
                    <span>{{ $project->genre_label }}</span>
                </div>

                <div>
                    <strong>Word count:</strong>
                    <span>{{ $project->word_count }}</span>
                </div>
            </div>

            @if($project->preview)
                <div class="prose max-w-none font-light">
                    {{ $project->renderMarkdown('preview') }}
                </div>
            @endif
        @endif
    </div>

    @can('update', $project)
        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-right gap-3">
            @if($editingProject)
                <x-jet-secondary-button
                    wire:click="$toggle('editingProject')"
                    wire:loading.attr="disabled"
                >
                    Cancel
                </x-jet-secondary-button>

                <x-jet-button wire:click="saveProject">
                    Save
                </x-jet-button>
            @else
                <x-jet-danger-button
                    wire:click="$toggle('confirmingDelete')"
                    class="flex items-center gap-2"
                >
                    <x-icon name="trash-2" />
                    <span class="sr-only sm:not-sr-only">Delete Project</span>
                </x-jet-danger-button>

                <x-jet-secondary-button
                    wire:click="editProject"
                    class="flex items-center gap-2"
                >
                    <x-icon name="settings" />
                    <span class="sr-only sm:not-sr-only">Edit Project</span>
                </x-jet-secondary-button>
            @endif
        </div>

        <x-jet-confirmation-modal wire:model="confirmingDelete">
            <x-slot:title>
                Delete Project
            </x-slot:title>

            <x-slot:content>
                Are you sure you want to delete "{{ $project->title }}"?
            </x-slot:content>

            <x-slot:footer>
                <x-jet-secondary-button
                    wire:click="$toggle('confirmingDelete')"
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
            </x-slot:footer>
        </x-jet-confirmation-modal>
    @endcan
</div>
