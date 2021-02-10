<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendances = [];
        $student = User::with('registeredSubjects')->find(3);
        $subjects = $student->registeredSubjects->pluck('id');
        $lessons = Lesson::where('start_time', '<', now())
            ->whereIn('subject_id', $subjects)->get();

        foreach ($lessons as $lesson) {
            if (random_int(1, 10) < 8) {
                $attendances[] = [
                    'lesson_id'     => $lesson->id,
                    'student_id'    => $student->id,
                    'time_in'       => $this->randomDateNear($lesson->start_time, true),
                    'time_out'      => $this->randomDateNear($lesson->end_time, false)
                ];
            }
        }

        DB::table('attendances')->insert($attendances);
    }

    private function randomDateNear(string $dateString, bool $forward): string
    {
        $interval = random_int(0, 15);

        if ($interval === 0) return $dateString;

        $operation = ($forward ? 'add' : 'sub') . 'Minutes';

        $new = CarbonImmutable::createFromFormat('Y-m-d H:i:s', $dateString)
            ->$operation(5)
            ->timestamp;

        $old = strtotime($dateString);

        return date('Y-m-d H:i:s', random_int(min($old, $new), max($old, $new)));
    }
}
