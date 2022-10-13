<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Card extends Component
{
    /** @var \App\Models\Project */
    public $project;

    /** @var boolean */
    public $confirmingProjectDeletion;

    /**
     * Create a new component instance.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function mount(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.projects.card');
    }

    /**
     * Edit the project.
     *
     * @return void
     */
    public function editProject()
    {
        // nothing yet
    }

    /**
     * Delete the project.
     *
     * @return void
     */
    public function deleteProject()
    {
        $this->confirmingProjectDeletion = false;
    }
}
