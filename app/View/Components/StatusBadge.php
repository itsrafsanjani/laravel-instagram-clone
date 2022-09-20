<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusBadge extends Component
{
    public string $statusType;

    public string $statusText;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($statusType, $statusText)
    {
        $this->statusType = $statusType;
        $this->statusText = $statusText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status-badge');
    }
}
