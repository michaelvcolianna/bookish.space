<div id="project-card-{{ $project->id }}" class="sm:rounded-lg shadow-md">
    <div class="bg-white p-4 sm:p-6 grid gap-4 sm:rounded-tl-lg sm:rounded-tr-lg">
        @if($editingProject)
            <h2 class="text-xl font-bold">
                Project Settings
            </h2>

            <x-project submit="saveProject" :project="$project" />
        @else
            <h2 class="text-xl font-bold">
                <a
                    class="underline underline-offset-2"
                    href="{{ $project->url() }}"
                >
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

            @if($project->tags->isNotEmpty())
                <div class="flex gap-4 text-sm items-center">
                    <h3 class="font-bold text-gray-700">Tags</h3>

                    <ul class="flex gap-4">
                        @foreach($project->tags as $tag)
                            <li>
                                {{-- @todo Route url for tags --}}
                                <a class="underline" href="{{ $tag->slug }}">
                                    {{ $tag->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>

    <div
        class="
            flex flex-row justify-end px-6 py-4 bg-gray-100 gap-5 items-center
            sm:rounded-bl-lg sm:rounded-br-lg
        "
    >
        @can('update', $project)
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
                    <span class="sr-only md:not-sr-only">Delete Project</span>
                </x-jet-danger-button>

                <x-jet-secondary-button
                    wire:click="editProject"
                    class="flex items-center gap-2"
                >
                    <x-icon name="settings" />
                    <span class="sr-only md:not-sr-only">Project Settings</span>
                </x-jet-secondary-button>

                <x-jet-button
                    wire:click="tagProject"
                    class="flex items-center gap-2"
                >
                    <x-icon name="tag" />
                    <span class="sr-only md:not-sr-only">Tag Project</span>
                </x-jet-button>
            @endif

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

            <x-jet-dialog-modal wire:model="taggingProject">
                <x-slot:title>Tag "{{ $project->title }}"</x-slot:title>

                <x-slot:content>
                    <x-jet-label for="project-{{ $project->id }}-tags">
                        Enter your tags for the project below by searching for
                        existing ones or creating your own.
                    </x-jet-label>

                    <div class="mt-4 relative">
                        <form wire:submit.prevent="pickFirstTag">
                            <x-jet-input
                                id="project-{{ $project->id }}-tags"
                                type="text"
                                class="block mt-1 w-full"
                                wire:model.debounce.500ms="searchTag"
                                autocomplete="off"
                            />

                            @if($searchResults)
                                <ul
                                    class="
                                        absolute bg-white border rounded-md
                                        shadow max-h-full overflow-y-scroll
                                        text-sm cursor-pointer
                                    "
                                >
                                    @foreach($searchResults as $tagId => $tagName)
                                        <li
                                            class="py-2 px-4"
                                            wire:click="chooseTag({{ $tagId }})"
                                        >
                                            {{ $tagName }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                        <div class="mt-4">
                            <h3 class="font-bold text-lg">Existing Tags</h3>

                            @if($project->tags->isNotEmpty())
                                <ul class="mt-2 flex flex-wrap gap-2 text-sm">
                                    @foreach($project->tags as $tag)
                                        <li>
                                            <button
                                                type="button"
                                                class="
                                                    bg-gray-200 rounded p-2 flex
                                                    gap-1 items-center
                                                "
                                            >
                                                <x-icon
                                                    name="x"
                                                    wire:click="removeTag({{ $tag->id }})"
                                                />

                                                <span class="sr-only">
                                                    Remove tag
                                                </span>

                                                <span>{{ $tag->name }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="italic text-gray-600">None</div>
                            @endif
                        </div>
                    </div>
                </x-slot:content>

                <x-slot:footer>
                    <x-jet-secondary-button
                        wire:click="$set('taggingProject', false)"
                        wire:loading.attr="disabled"
                    >
                        Done
                    </x-jet-secondary-button>
                </x-slot:footer>
            </x-jet-dialog-modal>
        @else
            {{-- @todo Avatar or text "author" --}}
            <span class="text-xs font-light uppercase justify-self-start">
                Author
            </span>

            <a class="underline" href="{{ $project->user->url() }}">
                {{ $project->user->name }}
            </a>
        @endcan
    </div>
</div>
