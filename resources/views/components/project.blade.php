<form wire:submit.prevent="{{ $submit }}">
    <div class="mt-4">
        <x-jet-label for="{{ $idPreface }}title" value="Title" />

        <x-jet-input
            class="block mt-1 w-full"
            id="{{ $idPreface }}title"
            type="text"
            wire:model.defer="{{ $modelPreface }}title"
            required
        />

        <x-jet-input-error for="{{ $modelPreface }}title" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-jet-label for="{{ $idPreface }}genre" value="Genre" />

        <x-form.select
            id="{{ $idPreface }}genre"
            wire:model.defer="{{ $modelPreface }}genre"
            required
        >
            @foreach(config('app.genres') as $key => $genre)
                <optgroup label="{{ $genre['__label'] }}">
                    @foreach($genre as $value => $label)
                        @if($value !== '__label')
                            <option value="{{ $key }}.{{ $value }}">
                                {{ $label }}
                            </option>
                        @endif
                    @endforeach
                </optgroup>
            @endforeach
        </x-form.select>

        <x-jet-input-error for="{{ $modelPreface }}genre" class="mt-2" />
    </div>

    <div class="mt-4">
        <x-jet-label for="{{ $idPreface }}word-count" value="Word Count" />

        <x-jet-input
            class="block mt-1 w-full"
            id="{{ $idPreface }}word-count"
            type="text"
            wire:model.defer="{{ $modelPreface }}word_count"
            required
        />

        <x-jet-input-error for="{{ $modelPreface }}word_count" class="mt-2" />
    </div>

    <div class="mt-4">
        <div class="block font-medium text-sm text-gray-700">
            Seeking
        </div>

        <div class="grid gap-4 items-center mt-2">
            @foreach(App\Models\Project::SEEKING as $value => $label)
                <label class="flex items-center">
                    <x-form.radio wire:model="{{ $modelPreface }}seeking" :value="$value" />

                    <span class="ml-2 text-sm text-gray-600">
                        {{ $label }}
                    </span>
                </label>
            @endforeach
        </div>

        <x-jet-input-error for="{{ $modelPreface }}seeking" class="mt-2" />

        <x-form.help>
            Some of the fields below will change depending on what you're
            seeking for this project.
        </x-form.help>
    </div>

    <div class="mt-4">
        <x-jet-label for="{{ $idPreface }}preview" value="Preview" />

        <x-form.textarea
            class="block mt-1 w-full h-32"
            id="{{ $idPreface }}preview"
            wire:model.defer="{{ $modelPreface }}preview"
        ></x-form.textarea>

        <x-jet-input-error for="{{ $modelPreface }}preview" class="mt-2" />

        <x-form.help>
            A short blurb describing your project – this could be the hook, a
            snippet, or a summary. This field is optional but we highly
            recommend filling it out, even if you have an intriguing title.
        </x-form.help>
    </div>

    <div class="mt-4">
        <x-jet-label
            for="{{ $idPreface }}similar-works"
            value="Similar Works"
        />

        <x-form.textarea
            class="block mt-1 w-full h-16"
            id="{{ $idPreface }}similar-works"
            wire:model.defer="{{ $modelPreface }}similar_works"
        ></x-form.textarea>

        <x-jet-input-error
            for="{{ $modelPreface }}similar_works"
            class="mt-2"
        />

        <x-form.help>
            Don't limit yourself to other books – sometimes, a movie or TV show
            makes a great comp. This field is optional but may be helpful to
            fill out.
        </x-form.help>
    </div>

    <div class="mt-4">
        <x-jet-label
            for="{{ $idPreface }}target-audience"
            value="Target Audience"
        />

        <x-form.textarea
            class="block mt-1 w-full h-32"
            id="{{ $idPreface }}target-audience"
            wire:model.defer="{{ $modelPreface }}target_audience"
        ></x-form.textarea>

        <x-jet-input-error
            for="{{ $modelPreface }}target_audience"
            class="mt-2"
        />

        <x-form.help>
            The kind(s) of readers you think this project will appeal to the
            most. This field is optional but may be helpful to fill out.
        </x-form.help>
    </div>

    <div class="mt-4">
        <x-jet-label
            for="{{ $idPreface }}content-notices"
            value="Content Notices"
        />

        <x-form.textarea
            class="block mt-1 w-full h-32"
            id="{{ $idPreface }}content-notices"
            wire:model.defer="{{ $modelPreface }}content_notices"
        ></x-form.textarea>

        <x-jet-input-error
            for="{{ $modelPreface }}content_notices"
            class="mt-2"
        />

        <x-form.help>
            Any information that might help a reader who is sensitive to certain
            content decide whether they can comfortably read your project.
            (Think of guidance warnings or notices about flashing lights
            proceeding a movie or TV show.) This field is optional but we
            recommend it, especially if your work contains subject matter that
            others might need to avoid.
        </x-form.help>
    </div>

    @if($seeking === 'readers')
        <div class="mt-4">
            <x-jet-label
                for="{{ $idPreface }}content-link"
                value="Content Link"
            />

            <x-jet-input
                class="block mt-1 w-full"
                id="{{ $idPreface }}content-link"
                type="text"
                wire:model.defer="{{ $modelPreface }}content_link"
            />

            <x-jet-input-error
                for="{{ $modelPreface }}content_link"
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

            <div class="grid gap-4 items-center mt-2">
                @foreach(App\Models\Project::FEEDBACK as $value => $label)
                    <label class="flex items-center">
                        <x-form.radio
                            wire:model.defer="{{ $modelPreface }}feedback_type"
                            :value="$value"
                        />

                        <span class="ml-2 text-sm text-gray-600">
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>

            <x-jet-input-error
                for="{{ $modelPreface }}feedback_type"
                class="mt-2"
            />

            <x-form.help>
                <strong>Positivity Passes</strong> are for when you're looking
                to see what's really working in the project.
                <br />
                <strong>Critiques</strong> can be overall or for structure,
                plot, or other elements.
                <br />
                <strong>Editorial</strong> feedback can be a deep-dive into
                capitalization/punctuation/etc. or seeking the services of a
                professional editor.
            </x-form.help>
        </div>
    @endif

    @if($seeking === 'agent')
        <div class="mt-4">
            <x-jet-label
                for="{{ $idPreface }}query-letter"
                value="Query Letter"
            />

            <x-form.textarea
                class="block mt-1 w-full h-80"
                id="{{ $idPreface }}query-letter"
                wire:model.defer="{{ $modelPreface }}query_letter"
            ></x-form.textarea>

            <x-jet-input-error
                for="{{ $modelPreface }}query_letter"
                class="mt-2"
            />

            <x-form.help>
                <a class="underline" href="#">Here are some helpful tips for
                crafting a catchy query letter.</a>
            </x-form.help>
        </div>

        <div class="mt-4">
            <x-jet-label for="{{ $idPreface }}synopsis" value="Synopsis" />

            <x-form.textarea
                class="block mt-1 w-full h-96"
                id="{{ $idPreface }}synopsis"
                wire:model.defer="{{ $modelPreface }}synopsis"
            ></x-form.textarea>

            <x-jet-input-error for="{{ $modelPreface }}synopsis" class="mt-2" />

            <x-form.help>
                <a class="underline" href="#">Here are some helpful tips on
                getting the important bits into your synopsis.</a>
            </x-form.help>
        </div>
    @endif

    <x-jet-validation-errors />

    <button class="hidden">Submit</button>
</form>
