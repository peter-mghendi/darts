<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function show()
    {
        return view('timetable', ['lessons' => Lesson::all()]);
    }
}
