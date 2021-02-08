<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $property = match ($user->role) {
            'student'   => 'registered',
            'lecturer'  => 'taught',
            default     => throw new Exception("Invalid User Role")
        }
        . 'Subjects';

        $subjects = $user->$property->pluck('id');

        return view('timetable', [
            'lessons' => Lesson::whereIn('subject_id', $subjects)->get()
        ]);
    }
}
