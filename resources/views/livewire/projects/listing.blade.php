<div class="grid gap-8">
    @if($projects->isNotEmpty())
        @foreach($projects as $project)
            <livewire:projects.card
                wire:key="project-{{ $project->id }}"
                :project="$project"
            />
        @endforeach
    @else
        <div class="p-8 text-3xl italic">You don't have any projects yet.</div>
    @endif
</div>
