<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
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

        $subjects = $user->$property;
        $subjectIds = $subjects->pluck('id');
        $now = now();

        $data = [
            'lessons' => Lesson::with(['subject', 'room'])
                ->where('start_time', '<', $now)
                ->where('end_time', '>', $now)
                ->whereIn('subject_id', $subjectIds)->get()
        ];

        if ($user->role === 'student') {
            $data['subjectRecords'] = [];

            foreach ($subjects as $subject) {
                $lessons = $subject->lessons()->where('end_time', '<', now())->get();

                $data['subjectRecords'][$subject->id] = [
                    'occurrences' => $lessons->count(),
                    'attendances' => $lessons->filter(fn($l) => $l->students->contains($user))->count()
                ];
            }
        };

        return view('dashboard', $data);
    }
}
