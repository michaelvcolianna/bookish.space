<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Projects
        </h2>

        <livewire:projects.create wire-key="project-create" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-8">
                @forelse($projects as $project)
                    <livewire:projects.card
                        :project="$project"
                        wire:key="project-card-{{ $project->id }}"
                    />
                @empty
                    <div class="italic text-gray-500">
                        You don't have any projects yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
