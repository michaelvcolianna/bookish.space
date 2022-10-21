<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;

class Projects extends Component
{
    use WithPagination;

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.dashboard.projects', [
            'projects' => auth()->user()->projects()
                ->orderByDesc('updated_at')
                ->paginate(5),
        ]);
    }
}
