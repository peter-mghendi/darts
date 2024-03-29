<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class LecturerDashboard extends Component
{
    public Collection $ongoingLessons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $ongoingLessons)
    {
        $this->ongoingLessons = $ongoingLessons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.lecturer-dashboard');
    }
}
