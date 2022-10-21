<?php

namespace App\View\Components\Shared;

use Illuminate\View\Component;

class PageLink extends Component
{
    /** @var string */
    public $classes;
    public $href;
    public $label;

    /**
     * Create a new component instance.
     *
     * @param  string  $label
     * @param  string  $route
     * @param  string  $href
     * @param  boolean  $isButton
     * @return void
     */
    public function __construct($label, $route = null, $href = null, $isButton = false)
    {
        $this->classes = $isButton
            ? 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'
            : 'text-sm text-gray-700 underline'
        ;
        $this->href = $route
            ? route($route)
            : $href
        ;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.shared.page-link');
    }
}
