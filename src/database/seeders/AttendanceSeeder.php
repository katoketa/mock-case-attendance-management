<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::today();
        for ($user_i = 1; $user_i <= 10; $user_i++) {
            for ($sub_day_j = 1; $sub_day_j <= 99; $sub_day_j++) {
                if ($sub_day_j % 10 === 0) {
                    // 10日間に1日データを作成しない
                    continue;
                }
                $attendanceDate = $now->subDay($sub_day_j);
                $punch_in_at = $attendanceDate->addHour(9)->addSecond(random_int(-3600, 3600));
                $punch_out_at = $attendanceDate->addHour(19)->addSecond(random_int(-3600, 3600));
                $params[] = [
                    'user_id' => $user_i,
                    'punch_in_at' => $punch_in_at,
                    'punch_out_at' => $punch_out_at,
                    'remarks' => fake()->realText(30),
                ];
            }
        }
    }
}
