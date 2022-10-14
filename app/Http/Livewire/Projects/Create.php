<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    /** @var boolean */
    public $displayingForm;

    /** @var string */
    public $seeking = null;
    public $title;

    /**
     * Validation rules for the fields.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'title' => 'required',
            'seeking' => [
                'required',
                'string',
                Rule::in(array_keys(Project::SEEKING)),
            ],
        ];
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.projects.create');
    }

    /**
     * Show the new project form.
     *
     * @return void
     */
    public function displayForm()
    {
        $this->displayingForm = true;
        $this->emit('displayNewProjectForm');
    }

    /**
     * Add a new project.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProject()
    {
        $this->validate();

        $project = Project::create([
            'user_id' => auth()->user()->id,
            'title' => $this->title,
            'seeking' => $this->seeking,
            'unlisted_at' => now(),
        ]);

        session()->flash(
            'flash.banner',
            sprintf('Created your project "%s"!', $project->title)
        );

        return redirect()->route('projects');
    }
}
