<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class AddButton extends Component
{
    public $creatingProject;

    public $content_link;
    public $content_notices;
    public $feedback_type;
    public $genre;
    public $preview;
    public $query_letter;
    public $seeking;
    public $similar_works;
    public $synopsis;
    public $target_audience;
    public $title;
    public $word_count;

    protected $rules = [
        'content_link' => 'nullable|required_if:seeking,readers',
        'content_notices' => 'nullable',
        'feedback_type' => 'nullable|required_if:seeking,feedback',
        'genre' => 'required',
        'preview' => 'nullable',
        'query_letter' => 'nullable|required_if:seeking,agent',
        'seeking' => 'required',
        'similar_works' => 'nullable',
        'synopsis' => 'nullable|required_if:seeking,agent',
        'target_audience' => 'nullable',
        'title' => 'required',
        'word_count' => 'required',
    ];

    public function render()
    {
        return view('livewire.projects.add-button');
    }

    public function displayForm()
    {
        $this->creatingProject = true;

        $this->emit('displayNewProjectForm');
    }

    public function createProject()
    {
        $data = $this->validate();
        $data['user_id'] = auth()->id();

        $project = Project::create($data);

        $this->dispatchBrowserEvent('banner-message', [
            'message' => sprintf(
                'Created your project: "%s"!',
                $project->title
            ),
            'style' => 'success',
        ]);

        $this->emit('updateProjects');

        $this->reset();
    }
}
