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
                    <x-slot:description>This is a list of all your projects.</x-slot:description>

                    @dump(auth()->user()->projects)
                </x-shared.split-section>
            @endif
        </div>
    </div>
</x-app-layout>
