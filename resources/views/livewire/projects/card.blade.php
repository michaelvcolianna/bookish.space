<x-shared.section>
    <div class="grid gap-2">
        <div class="flex flex-wrap gap-2 md:flex-row justify-between items-center">
            <h2 class="order-2 md:order-1 w-full md:w-auto">
                <x-shared.page-link
                    :href="$project->routeUrl()"
                    :label="$project->title"
                    class="text-lg font-bold"
                />
            </h2>

            <x-dynamic-component
                component="project.pills.{{ $project->visibility }}"
                class="order-1 md:order-2"
            />
        </div>

        <div class="flex flex-wrap gap-4 md:gap-8 items-center text-sm text-gray-600">
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

        <hr class="mt-2" />

        <div class="italic text-sm">
            tags coming soon
        </div>
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

    <x-jet-confirmation-modal wire:model.defer="confirmingProjectDeletion">
        <x-slot:title>
            Delete Project
        </x-slot:title>

        <x-slot:content>
            Are you sure you would like to delete this project? (Note: We'll
            hold on to the data for 30 days, so if you'd like to un-delete, just
            let us know.)
        </x-slot:content>

        <x-slot:footer>
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
        </x-slot:footer>
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model.defer="editingProject">
        <x-slot:title>
            Edit ‘{{ $project->title }}’
        </x-slot:title>

        <x-slot:content>
            <div>
                <x-jet-label
                    for="project-{{ $project->id }}-title"
                    value="Title"
                />
                <x-jet-input
                    class="block mt-1 w-full"
                    id="project-{{ $project->id }}-title"
                    type="text"
                    wire:model.defer="project.title"
                    required
                    autofocus
                />
                <x-jet-input-error for="project.title" class="mt-2" />
            </div>

            <div class="mt-4">
                <div class="block font-medium text-sm text-gray-700">
                    Status
                </div>
                <div class="flex flex-wrap gap-y-2 items-center justify-between mt-2">
                    @foreach(App\Models\Project::STATUS as $value => $label)
                        <x-form.radio
                            id="project-{{ $project->id }}-{{ $value }}"
                            model="status"
                            :value="$value"
                            :label="$label"
                        />
                    @endforeach
                </div>
                <x-jet-input-error for="status" class="mt-2" />
                <x-form.help>
                    <strong>Public</strong> projects are viewable by any user.
                    <br />
                    <strong>Unlisted</strong> projects are viewable by any user,
                    but only if they know the URL.
                </x-form.help>
            </div>

            <div class="mt-4">
                <div class="block font-medium text-sm text-gray-700">
                    Seeking
                </div>
                <div class="flex flex-wrap gap-y-2 items-center justify-between mt-2">
                    @foreach(App\Models\Project::SEEKING as $value => $label)
                        <x-form.radio
                            id="project-{{ $project->id }}-{{ $value }}"
                            model="seeking"
                            :value="$value"
                            :label="$label"
                        />
                    @endforeach
                </div>
                <x-jet-input-error for="seeking" class="mt-2" />
                <x-form.help>
                    The answers at the bottom of this form will change depending
                    on what you're seeking.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-preview"
                    value="Preview"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-preview"
                    wire:model.defer="project.preview"
                ></x-form.textarea>
                <x-jet-input-error for="project.preview" class="mt-2" />
                <x-form.help>
                    A short blurb describing your project – this could be the
                    hook, a snippet, or a summary. This field is optional but we
                    highly recommend filling it out, even if you have an
                    intriguing title.
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
                    wire:model.defer="project.genre"
                />
                <x-jet-input-error for="project.genre" class="mt-2" />
                <x-form.help>
                    Ex: Cookbook, YA Fantasy, Picture Book. This field is
                    optional but may be helpful to fill out.
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
                    wire:model.defer="project.word_count"
                />
                <x-jet-input-error for="project.word_count" class="mt-2" />
                <x-form.help>
                    This field is optional but may be helpful to fill out.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-similar_works"
                    value="Similar Works"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-similar_works"
                    wire:model.defer="project.similar_works"
                ></x-form.textarea>
                <x-jet-input-error for="project.similar_works" class="mt-2" />
                <x-form.help>
                    Don't limit yourself to other books – sometimes, a movie or
                    TV show makes a great comp. This field is optional but may
                    be helpful to fill out.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label
                    for="project-{{ $project->id }}-target_audience"
                    value="Target Audience"
                />
                <x-form.textarea
                    class="block mt-1 w-full h-32"
                    id="project-{{ $project->id }}-target_audience"
                    wire:model.defer="project.target_audience"
                ></x-form.textarea>
                <x-jet-input-error for="project.target_audience" class="mt-2" />
                <x-form.help>
                    The kind(s) of readers you think this project will appeal to
                    the most. This field is optional but may be helpful to fill
                    out.
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
                    wire:model.defer="project.content_notices"
                ></x-form.textarea>
                <x-jet-input-error for="project.content_notices" class="mt-2" />
                <x-form.help>
                    Any information that might help a reader who is sensitive to
                    certain content decide whether they can comfortably read
                    your project. (Think of guidance warnings or notices about
                    flashing lights proceeding a movie or TV show.) This field
                    is optional but we recommend it, especially if your work
                    contains subject matter that others need to avoid.
                </x-form.help>
            </div>

            <hr class="mt-4" />

            @if($seeking === 'readers')
                <div class="mt-4">
                    <x-jet-label
                        for="project-{{ $project->id }}-content_link"
                        value="Content Link"
                    />
                    <x-jet-input
                        class="block mt-1 w-full"
                        id="project-{{ $project->id }}-content_link"
                        type="text"
                        wire:model.defer="project.content_link"
                    />
                    <x-jet-input-error
                        for="project.content_link"
                        class="mt-2"
                    />
                    <x-form.help>
                        The URL to your story.
                    </x-form.help>
                </div>
            @endif

            @if($seeking === 'feedback')
                <div class="mt-4">
                    <div class="block font-medium text-sm text-gray-700">
                        Feedback Type
                    </div>
                    <div class="flex flex-wrap gap-y-2 items-center justify-between mt-2">
                        @foreach(App\Models\Project::FEEDBACK as $value => $label)
                            <x-form.radio
                                id="project-{{ $project->id }}-{{ $value }}"
                                model="project.feedback_type"
                                :value="$value"
                                :label="$label"
                            />
                        @endforeach
                    </div>
                    <x-jet-input-error
                        for="project.feedback_type"
                        class="mt-2"
                    />
                    <x-form.help>
                        <strong>Positivity Passes</strong> are for when you're
                        looking to see what's really working in the project.
                        <br />
                        <strong>Critiques</strong> can be overall or for
                        structure, plot, or other elements.
                        <br />
                        <strong>Editorial</strong> feedback can be a deep-dive
                        into capitalization/punctuation/etc. or seeking the
                        services of a professional editor.
                    </x-form.help>
                </div>
            @endif

            @if($seeking === 'agent')
                <div class="mt-4">
                    <x-jet-label
                        for="project-{{ $project->id }}-query_letter"
                        value="Query Letter"
                    />
                    <x-form.textarea
                        class="block mt-1 w-full h-80"
                        id="project-{{ $project->id }}-query_letter"
                        wire:model.defer="project.query_letter"
                    ></x-form.textarea>
                    <x-jet-input-error
                        for="project.query_letter"
                        class="mt-2"
                    />
                    <x-form.help>
                        For tips on crafting a catchy query letter, [link to
                        come].
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
                        wire:model.defer="project.synopsis"
                    ></x-form.textarea>
                    <x-jet-input-error for="project.synopsis" class="mt-2" />
                    <x-form.help>
                        For tips on getting the important bits into your
                        synopsis, [link to come].
                    </x-form.help>
                </div>
            @endif
        </x-slot:content>

        <x-slot:footer>
            @if($errors->any())
                <p class="text-sm text-red-600 mr-4 self-center" role="alert">
                    Please double-check the fields above for errors.
                </p>
            @endif

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
        </x-slot:footer>
    </x-jet-dialog-modal>
</x-shared.section>
