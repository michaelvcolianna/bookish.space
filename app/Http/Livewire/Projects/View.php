<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class View extends Component
{
    /** @var \App\Models\Project */
    public Project $project;

    /**
     * Create a new component instance.
     *
     * @param  string  $handle
     * @param  string  $slug
     * @return void
     */
    public function mount($handle, $slug)
    {
        $author = User::firstWhere('handle', $handle);
        abort_unless($author, 404);

        $project = $author->projects()->firstWhere('slug', $slug);
        abort_unless($project, 404);

        $this->project = $project;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.projects.view');
    }
}
