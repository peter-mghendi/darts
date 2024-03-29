<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 8;
        $rooms = [];
        $now = now();

        for ($i = 0; $i < $num; $i++) $rooms[] = [
            'name' => 'Room ' . $i + 1,
            'created_at' => $now,
            'updated_at' => $now
        ];

        DB::table('rooms')->insert($rooms);
    }
}
