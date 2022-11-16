<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;

class Listing extends Component
{
    public $projects;

    protected $listeners = [
        'updateProjects',
    ];

    public function mount()
    {
        $this->updateProjects();
    }

    public function render()
    {
        return view('livewire.projects.listing');
    }

    public function updateProjects()
    {
        $this->projects = auth()->user()->projects()->orderByDesc('updated_at')->get();
    }
}
