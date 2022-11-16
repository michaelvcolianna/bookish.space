<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;

class Card extends Component
{
    public $project;

    public $confirmingDelete;
    public $editingProject;
    public $taggingProject;

    protected $rules = [
        'project.content_link' => 'nullable|required_if:project.seeking,readers',
        'project.content_notices' => 'nullable',
        'project.feedback_type' => 'nullable|required_if:project.seeking,feedback',
        'project.genre' => 'required',
        'project.preview' => 'nullable',
        'project.query_letter' => 'nullable|required_if:project.seeking,agent',
        'project.seeking' => 'required',
        'project.similar_works' => 'nullable',
        'project.synopsis' => 'nullable|required_if:project.seeking,agent',
        'project.target_audience' => 'nullable',
        'project.title' => 'required',
        'project.word_count' => 'required',
    ];

    public function mount($project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.card');
    }

    public function tagProject()
    {
        $this->taggingProject = true;

        $this->emit('displayTagProjectForm', [
            'id' => $this->project->id,
        ]);
    }

    public function editProject()
    {
        $this->editingProject = true;

        $this->emit('displayEditProjectForm', [
            'id' => $this->project->id,
        ]);
    }

    public function deleteProject()
    {
        $title = $this->project->title;

        $this->project->delete();

        $this->dispatchBrowserEvent('banner-message', [
            'message' => sprintf('Deleted your project: "%s"!', $title),
        ]);

        $this->emit('updateProjects');
    }

    public function saveProject()
    {
        $this->validate();

        $this->project->save();

        $this->dispatchBrowserEvent('banner-message', [
            'message' => sprintf(
                'Updated your project: "%s"!',
                $this->project->title
            ),
            'style' => 'success',
        ]);

        $this->editingProject = false;
    }

    public function saveTags()
    {
        // @todo Tags

        $this->dispatchBrowserEvent('banner-message', [
            'message' => sprintf(
                'Updated your project: "%s"!',
                $this->project->title
            ),
            'style' => 'success',
        ]);

        $this->taggingProject = false;
    }
}
