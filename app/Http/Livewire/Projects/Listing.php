<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;
use Livewire\WithPagination;

class Listing extends Component
{
    use WithPagination;

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
        return view('livewire.projects.listing', [
            'projects' => auth()->user()->projects()
                ->orderByDesc('updated_at')
                ->paginate(10),
        ]);
    }

    /**
     * Get the user's projects.
     *
     * @return void
     */
    public function updateProjects()
    {
        //
    }
}
