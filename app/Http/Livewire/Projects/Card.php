<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;
use Spatie\Tags\Tag;

class Card extends Component
{
    public $project;

    public $confirmingDelete;
    public $editingProject;
    public $taggingProject;

    public $searchTag;
    public $searchResults;

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

    public function clearSearchResults()
    {
        $this->searchResults = [];
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

    public function tagProject()
    {
        $this->taggingProject = true;

        $this->emit('displayTagProjectForm', [
            'id' => $this->project->id,
        ]);
    }

    public function updatedSearchTag($value)
    {
        $value = trim($value);

        if($value)
        {
            $tags = Tag::containing($value)->get();

            if($tags->isNotEmpty())
            {
                foreach($tags as $tag)
                {
                    $this->searchResults[$tag->id] = $tag->name;
                }
            }
            else
            {
                $this->searchResults = [
                    sprintf('Add tag "%s"', $value),
                ];
            }
        }
        else
        {
            $this->clearSearchResults();
        }
    }

    public function chooseTag($id)
    {
        $tag = $id > 0
            ? Tag::find($id)->name
            : trim($this->searchTag)
        ;

        $this->project->attachTag($tag);

        $this->tagChosen();
    }

    public function pickFirstTag()
    {
        if(trim($this->searchTag))
        {
            $this->chooseTag(array_key_first($this->searchResults));
            $this->tagChosen();
        }
    }

    public function tagChosen()
    {
        $this->searchTag = null;
        $this->clearSearchResults();
        $this->project->refresh();
    }

    public function removeTag($id)
    {
        $this->project->detachTag(Tag::find($id)->name);
        $this->project->refresh();
    }
}
