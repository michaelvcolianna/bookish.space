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

    /**
     * Validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'project.title' => 'required',
            'project.seeking' => [
                'required',
                'integer',
                Rule::in(array_keys(Project::SEEKING)),
            ],
            'project.reader_type' => 'nullable',
            'project.feedback_type' => 'nullable',
            'project.genre' => 'nullable',
            'project.word_count' => 'nullable',
            'project.similar_works' => 'nullable',
            'project.preview' => 'nullable',
            'project.content_notices' => 'nullable',
            'project.query_letter' => 'nullable',
            'project.synopsis' => 'nullable',
            'project.password' => 'nullable',
            'project.unlisted_at' => 'nullable',
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
        $this->project->save();
        $this->editingProject = false;
    }

    /**
     * Delete the project.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProject()
    {
        $this->project->delete();

        return redirect()->route('projects');
    }
}
