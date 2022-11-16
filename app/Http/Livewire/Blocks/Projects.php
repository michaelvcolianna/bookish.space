<?php

namespace App\Http\Livewire\Blocks;

use Livewire\Component;

class Projects extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.blocks.projects');
    }
}
