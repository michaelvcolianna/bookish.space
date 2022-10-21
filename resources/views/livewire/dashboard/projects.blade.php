@if($projects->isNotEmpty())
    <x-shared.split-section>
        <x-slot:title>Projects</x-slot:title>
        <x-slot:description>
            This is a list of your projects.
        </x-slot:description>

        @foreach($projects as $project)
            <div class="flex flex-wrap md:flex-nowrap gap-4 justify-between items-start">
                <div class="grid gap-2 w-full md:w-auto">
                    <div class="font-bold">{{ $project->title }}</div>

                    @if($project->genre)
                        <span class="text-sm text-gray-700">{{ $project->genre }}</span>
                    @endif

                    @if($project->word_count)
                        <span class="text-sm text-gray-700">{{ $project->word_count }} words</span>
                    @endif

                    <span class="text-sm text-gray-700 font-bold">
                        updated {{ $project->updated_at->diffForHumans() }}
                    </span>
                </div>

                <x-shared.page-link
                    :href="$project->routeUrl()"
                    label="View"
                    :isButton="true"
                />
            </div>

            @if(!$loop->last)
                <hr />
            @endif
        @endforeach

        @if($projects->hasPages())
            <x-slot:actions>
                {{ $projects->links('components.dashboard.pagination') }}
            </x-slot:actions>
        @endif
    </x-shared.split-section>
@else
    <div class="italic text-gray-500">
        You don't have any projects yet.
    </div>
@endif
