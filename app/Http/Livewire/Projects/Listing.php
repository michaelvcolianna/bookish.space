<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;

class Listing extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $projects;

    /**
     * Events the component listens for.
     *
     * @var array
     */
    protected $listeners = ['updateProjects'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount()
    {
        $this->updateProjects();
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.projects.listing');
    }

    /**
     * Get the user's projects.
     *
     * @return void
     */
    public function updateProjects()
    {
        $this->projects = auth()->user()->projects()->orderByDesc('updated_at')->get();
    }
}
