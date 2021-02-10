<?php

namespace Database\Seeders;

use DateTimeImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    // TODO Update this to use Carbon?
    private array $subjects = [];

    private array $picked = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lessons')->insert($this->generate(12));
    }

    private function generate($weeks = 1)
    {
        $this->refresh();
        $now = date('Y-m-d H:i:s');

        $current = new DateTimeImmutable('first monday of last month 7am');

        foreach (range(1, $weeks * 5) as $day) {
            while ((int) $current->format('H') < 16) {
                if ((int) $current->format('H') === 13) {
                    $current = $current->modify('+1 hour');
                }

                $lessonEnd = $current->modify('+2 hours');
                $subjects = $this->getSubjects();

                foreach ($subjects as $subject) {
                    $sessions[] = [
                        'status'        => '',
                        'comment'       => '',
                        'start_time'    => $current->format('Y-m-d H:i:s'),
                        'end_time'      => $lessonEnd->format('Y-m-d H:i:s'),
                        'room_id'       => explode(' ', $subject)[1][0] ,
                        'subject_id'    => $subject,
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ];
                }

                $current = $lessonEnd;
            }

            if ($day % 5 === 0) $this->refresh();

            $current = $current->modify('next weekday 7am');
        }

        return $sessions;
    }

    private function refresh()
    {
        foreach (range(1, 4) as $year) {
            foreach (range(1, 20, 2) as $code) {
                $this->subjects[$year][] = "CCS $year" . str_pad($code, 2, '0', STR_PAD_LEFT);
            }
        }

        $this->picked = [];
    }

    private function getSubjects()
    {
        foreach ($this->subjects as $key => $year) {
            $codeKey = array_rand($year);
            $code = $year[$codeKey];
            $codes[] = $code;

            if (in_array($code, $this->picked)) {
                unset($this->subjects[$key][$codeKey]);
            } else {
                $this->picked[] = $code;
            }
        }

        return $codes;
    }
}
