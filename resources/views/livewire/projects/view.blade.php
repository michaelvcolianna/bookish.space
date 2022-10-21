<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            View Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between gap-4 px-6">
                <h1 class="font-bold text-xl text-gray-800 w-full">
                    {{ $project->title }}
                </h1>

                <div>
                    <strong>By:</strong>
                    <span>{{ $project->user->name }}</span>
                </div>

                <div>
                    <strong>Updated:</strong>
                    <span>{{ $project->updated_at->diffForHumans() }}</span>
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
                <hr class="mt-4" />

                <div class="mt-4 px-6">
                    {{ $project->markdown('preview') }}
                </div>
            @endif

            <hr class="mt-4">

            <div class="mt-4 px-6 italic">tags coming soon</div>

            @if($project->content_notices)
                <hr class="mt-4" />

                <div class="mt-4 px-6 grid gap-4">
                    <strong>Content Notices:</strong>

                    <div>
                        {{ $project->markdown('content_notices') }}
                    </div>
                </div>
            @endif

            <hr class="mt-4" />

            <div class="mt-4 px-6 grid gap-4">
                <div>
                    <strong>Seeking:</strong>
                    <span>{{ $project->seeking_label }}</span>
                </div>

                @if($project->isSeekingAgent())
                    <div>
                        <strong>Query Letter:</strong>

                        @if($project->query_letter)
                            <div class="grid gap-4 mt-4">
                                {{ $project->markdown('query_letter') }}
                            </div>
                        @else
                            <em>Not entered yet.</em>
                        @endif
                    </div>

                    <div>
                        <strong>Synopsis:</strong>

                        @if($project->synopsis)
                            <div class="grid gap-4 mt-4">
                                {{ $project->markdown('synopsis') }}
                            </div>
                        @else
                            <em>Not entered yet.</em>
                        @endif
                    </div>
                @endif

                @if($project->isSeekingReaders())
                    <div>
                        <strong>Link to Project:</strong>

                        @if($project->content_link)
                            <x-shared.external-link
                                :href="$project->content_link"
                                :label="$project->content_link"
                            />
                        @else
                            <em>Not entered yet.</em>
                        @endif
                    </div>
                @endif

                @if($project->isSeekingFeedback())
                    <div>
                        <strong>Type of Feedback:</strong>

                        @if($project->feedback_type)
                            <span>{{ $project->feedback_label }}</span>
                        @else
                            <em>Not entered yet.</em>
                        @endif
                    </div>
                @endif
            </div>

            @if($project->similar_works)
                <hr class="mt-4" />

                <div class="mt-4 px-6 grid gap-4">
                    <strong>Similar Works:</strong>

                    <div>
                        {{ $project->markdown('similar_works') }}
                    </div>
                </div>
            @endif

            @if($project->target_audience)
                <hr class="mt-4" />

                <div class="mt-4 px-6 grid gap-4">
                    <strong>Target Audience:</strong>

                    <div>
                        {{ $project->markdown('target_audience') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
