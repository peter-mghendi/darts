<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class StudentDashboard extends Component
{
    public array $subjectRecords;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $subjectRecords)
    {
        $this->subjectRecords = $subjectRecords;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.student-dashboard');
    }
}
