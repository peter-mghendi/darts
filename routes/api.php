<?php

use App\Models\Lesson;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/attendance', function (Request $request) {
    if ($request->user()->role !== 'lecturer') abort(Response::HTTP_FORBIDDEN);
    if (!$request->has(['student', 'lesson'])) abort(Response::HTTP_BAD_REQUEST);

    $data = $request->only('student', 'lesson');

    // Have to repeat this check because "" passes the one above
    if (!$data['student'] || !$data['lesson']) abort(Response::HTTP_BAD_REQUEST);

    $lesson = Lesson::with(['subject', 'subject.students'])->findOrFail($data['lesson']);

    // TODO: Make Institutional ID primary
    $student = $lesson->subject->students()
        ->where('institutional_id', $data['student'])
        ->where('role', 'student')
        ->firstOrFail();

    try {
        DB::table('attendances')->insert([
            'student_id' => $student->id,
            'lesson_id'  => $lesson->id
        ]);
    } catch (QueryException $qe) {
        if ($qe->errorInfo[1] == 1062) return $student; // Already in class.
        throw $qe;
    }

    return $student;
});
