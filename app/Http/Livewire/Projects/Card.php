<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
    public $password;
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
            'password' => 'required_if:status,password-protected',
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
        // Fake password for validation if needed
        if($this->project->password && !$this->password)
        {
            $this->password = time();
        }

        $this->validate();

        // Easy update for seeking
        $this->project->seeking = $this->seeking;

        // Remove unlisted if needed
        if(Str::contains($this->status, ['public', 'password-protected']))
        {
            $this->project->unlisted_at = null;
        }

        // Remove password if needed
        if(Str::contains($this->status, ['public', 'unlisted']))
        {
            $this->project->password = null;
        }

        // Unlist
        if($this->status === 'unlisted')
        {
            $this->project->unlisted_at = now();
        }

        // Set password if needed
        if
        (
            $this->status === 'password-protected'
            &&
            !Hash::check($this->password, $this->project->password)
        )
        {

            $this->project->password = Hash::make($this->password);
        }

        $this->project->save();
        $this->password = null;
        $this->editingProject = false;
    }

    /**
     * Delete the project.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProject()
    {
        session()->flash(
            'flash.banner',
            sprintf('Removed your project ‘%s’.', $this->project->title)
        );
        session()->flash('flash.bannerStyle', 'info');

        $this->project->delete();

        return redirect()->route('projects');
    }
}
