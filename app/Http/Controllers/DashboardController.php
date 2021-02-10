<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $now = date('Y-m-d H:i:s');

        return view('dashboard', [
            'lessons' => Lesson::with(['subject', 'room'])
                ->where('start_time', '<', $now)
                ->where('end_time', '>', $now)
                ->whereIn('subject_id', $subjects)->get()
        ]);

        // return view('dashboard');
    }
}
