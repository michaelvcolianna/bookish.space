<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Card extends Component
{
    /** @var \App\Models\Project */
    public $project;

    /** @var boolean */
    public $confirmingProjectDeletion;
    public $editingProject;

    /** @var string */
    public $seeking;
    public $status;

    /**
     * Validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in(array_keys(Project::STATUS)),
            ],
            'seeking' => [
                'required',
                'string',
                Rule::in(array_keys(Project::SEEKING)),
            ],
            'project.title' => 'required',
            'project.content_link' => 'required_if:seeking,readers',
            'project.feedback_type' => 'required_if:seeking,feedback',
            'project.genre' => 'nullable',
            'project.word_count' => 'nullable',
            'project.similar_works' => 'nullable',
            'project.target_audience' => 'nullable',
            'project.preview' => 'nullable',
            'project.content_notices' => 'nullable',
            'project.query_letter' => 'required_if:seeking,agent',
            'project.synopsis' => 'required_if:seeking,agent',
        ];
    }

    /**
     * Create a new component instance.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function mount(Project $project)
    {
        $this->project = $project;
        $this->seeking = $project->seeking;
        $this->status = $project->visibility;
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
        $this->editingProject = true;
        $this->emit('editProject', $this->project->id);
    }

    /**
     * Cancel editing.
     *
     * @return void
     */
    public function cancelEditProject()
    {
        $this->editingProject = false;
        $this->project->discardChanges();
    }

    /**
     * Save changes to the project.
     *
     * @return void
     */
    public function saveProject()
    {
        $this->validate();

        // Update the radios
        $this->project->seeking = $this->seeking;
        $this->project->unlisted_at = $this->status === 'public'
            ? null
            : now()
        ;

        $this->project->save();
        $this->editingProject = false;
    }

    /**
     * Delete the project.
     *
     * @return void
     */
    public function deleteProject()
    {
        $this->dispatchBrowserEvent('banner-message', [
            'message' => sprintf('Removed your project "%s".', $this->project->title),
            'style' => 'danger',
        ]);

        $this->emit('updateProjects');

        $this->project->delete();
    }
}
