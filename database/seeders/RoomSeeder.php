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
        $num = 4;
        $rooms = [];

        for ($i = 0; $i < $num; $i++) $rooms[] = [
            'name' => 'Room ' . $i + 1
        ];

        DB::table('rooms')->insert($rooms);
    }
}
