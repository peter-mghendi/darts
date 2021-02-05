<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function show()
    {
        $subjects = Auth::user()->registeredSubjects->pluck('id');
        return view('timetable', [
            'lessons' => Lesson::whereIn('subject_id', $subjects)->get()
        ]);
    }
}
