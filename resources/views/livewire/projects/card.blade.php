<x-shared.section>
    <div class="grid gap-2">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold">{{ $project->title }}</h2>

            <x-dynamic-component
                component="project.pills.{{ $project->visibility_slug }}"
            />
        </div>

        <div class="flex gap-8 items-center text-sm text-gray-600">
            <div>
                <strong>Seeking:</strong>
                <span>{{ $project->seeking_label }}</span>
            </div>

            <div>
                <strong>Genre:</strong>
                <span>{{ $project->genre ?? 'Unknown' }}</span>
            </div>

            <div>
                <strong>Word count:</strong>
                <span>{{ $project->word_count ?? 'Unknown' }}</span>
            </div>
        </div>

        @if($project->preview)
            <div class="text-gray-600">
                {{ $project->preview }}
            </div>
        @endif
    </div>

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
            Are you sure you would like to delete this project? (Note: We'll
            hold on to the data for 30 days, so if you'd like to un-delete, just
            let us know.)
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

    <x-jet-dialog-modal wire:model="editingProject">
        <x-slot name="title">
            Edit ‘{{ $project->title }}’
        </x-slot>

        <x-slot name="content">
            <div>
                <x-jet-label
                    for="project-{{ $project->id }}-title"
                    value="Title"
                />
                <x-jet-input
                    class="block mt-1 w-full"
                    id="project-{{ $project->id }}-title"
                    type="text"
                    wire:model="project.title"
                    required
                    autofocus
                />
                <x-jet-input-error for="project.title" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-seeking"
                    value="Seeking"
                />
                <select
                    class="
                        border-gray-300 focus:border-indigo-300 focus:ring
                        focus:ring-indigo-200 focus:ring-opacity-50 rounded-md
                        shadow-sm mt-1 w-full
                    "
                    id="project-{{ $project->id }}-seeking"
                    wire:model="project.seeking"
                    required
                >
                    <option value="null" disabled>--- Choose ---</option>
                    @foreach(App\Models\Project::SEEKING as $n => $option)
                        <option value="{{ $n }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="project.seeking" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-preview"
                    value="Preview"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-preview"
                    wire:model="project.preview"
                ></x-form.textarea>
                <x-form.help>
                    A short blurb describing your project – this could be the
                    hook, a snippet, or a summary.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-genre"
                    value="Genre"
                />
                <x-jet-input
                    class="block mt-1 w-full"
                    id="project-{{ $project->id }}-genre"
                    type="text"
                    wire:model="project.genre"
                />
                <x-form.help>
                    Ex: Cookbook, YA Fantasy, Picture Book.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-word_count"
                    value="Word Count"
                />
                <x-jet-input
                    class="block mt-1 w-full"
                    id="project-{{ $project->id }}-word_count"
                    type="text"
                    wire:model="project.word_count"
                />
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-similar_works"
                    value="Similar Works"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-similar_works"
                    wire:model="project.similar_works"
                ></x-form.textarea>
                <x-form.help>
                    Don't limit yourself to other books – sometimes, a movie or
                    TV show makes a great comp.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-content_notices"
                    value="Content Notices"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-content_notices"
                    wire:model="project.content_notices"
                ></x-form.textarea>
                <x-form.help>
                    Any information that might help a reader who is sensitive to
                    certain content decide whether they can comfortably read
                    your project.
                </x-form.help>
            </div>

            @if($project->is_seeking_agent)
                <hr class="mt-4" />

                <div class="mt-4 text-lg font-bold">For Agents:</div>

                <div class="mt-4">
                    <x-jet-label
                        for="project-{{ $project->id }}-query_letter"
                        value="Query Letter"
                    />
                    <x-form.textarea
                        class="block mt-1 w-full h-80"
                        id="project-{{ $project->id }}-query_letter"
                        wire:model="project.query_letter"
                    ></x-form.textarea>
                    <x-form.help>
                        For tips on crafting a catchy query letter, [xyz].
                    </x-form.help>
                </div>

                <div class="mt-4">
                    <x-jet-label
                        for="project-{{ $project->id }}-synopsis"
                        value="Synopsis"
                    />
                    <x-form.textarea
                        class="block mt-1 w-full h-96"
                        id="project-{{ $project->id }}-synopsis"
                        wire:model="project.synopsis"
                    ></x-form.textarea>
                    <x-form.help>
                        For tips on getting the important bits into your
                        synopsis, [xyz].
                    </x-form.help>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button
                wire:click="cancelEditProject"
                wire:loading.attr="disabled"
            >
                Cancel
            </x-jet-secondary-button>

            <x-jet-button
                class="ml-3"
                wire:click="saveProject"
                wire:loading.attr="disabled"
            >
                Save
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</x-shared.section>
