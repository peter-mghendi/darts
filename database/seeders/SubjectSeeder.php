<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 80;
        $perLevel = 20;
        $subjects = [];
        $now = now();

        for ($i = 1; $i <= $num; $i++) {
            $level = ceil($i / $perLevel);
            $levelId = $i % $perLevel ?: $perLevel;
            $id = $level . str_pad($levelId, 2, 0, STR_PAD_LEFT);

            $subjects[] = [
                'id' => "CCS $id",
                'name' => "Subject $id",
                'level' => $level,
                'stage' => $levelId % 2 !== 0 ? 1 : 2,
                'teacher_id' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ];
        };

        DB::table('subjects')->insert($subjects);
    }
}
