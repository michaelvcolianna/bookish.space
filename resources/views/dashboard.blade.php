<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->has_projects)
                <x-shared.split-section>
                    <x-slot:title>Projects</x-slot:title>
                    <x-slot:description>
                        This is a list of some recent projects.
                    </x-slot:description>

                    @foreach(auth()->user()->projects()->orderByDesc('updated_at')->paginate(5) as $project)
                        <div class="flex justify-between items-center">
                            <div class="font-bold">{{ $project->title }}</div>

                            <a
                                href="#{{ $project->slug }}"
                                class="text-sm text-gray-700 underline"
                            >
                                View
                            </a>
                        </div>
                    @endforeach
                </x-shared.split-section>
            @endif
        </div>
    </div>
</x-app-layout>
