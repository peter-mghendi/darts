<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registrations = [];
        $current = 401;
        $subjects = 8;

        for ($i = 0; $i < $subjects; $i++) {
            $registrations[] = [
                'student_id' => 3,
                'subject_id' => "CCS $current"
            ];

            $current += 2;
        }

        DB::table('registrations')->insert($registrations);
    }
}
