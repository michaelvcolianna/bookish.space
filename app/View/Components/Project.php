<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Project extends Component
{
    public $project;

    public $idPreface;
    public $modelPreface;
    public $seeking;
    public $submit;

    public function __construct($submit, $seeking = null, $project = null)
    {
        $this->submit = $submit;
        $this->project = $project;

        $this->seeking = $project->seeking ?? $seeking;

        $this->idPreface = $project
            ? sprintf('project-%s-', $project->id)
            : 'project-'
        ;

        $this->modelPreface = $project ? 'project.' : '';
    }

    public function render()
    {
        return view('components.project');
    }
}
