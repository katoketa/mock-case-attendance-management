<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = CarbonImmutable::today();
        for ($user_i = 1; $user_i <= DatabaseSeeder::DUMMY_USER_NUM; $user_i++) {
            for ($sub_day_j = 1; $sub_day_j <= 99; $sub_day_j++) {
                if ($sub_day_j % 10 === 0) {
                    // 10日間に1日データを作成しない
                    continue;
                }
                $attendanceOn = $today->subDays($sub_day_j);
                $punchInAt = $attendanceOn->addHours(9)->addSeconds(random_int(-3600, 3600));
                $punchOutAt = $attendanceOn->addHours(19)->addSeconds(random_int(-3600, 3600));
                $params[] = [
                    'user_id' => $user_i,
                    'attendance_on' => $attendanceOn,
                    'punch_in_at' => $punchInAt,
                    'punch_out_at' => $punchOutAt,
                    'remarks' => fake()->realText(30),
                ];
            }
        }
        foreach ($params as $param) {
            DB::table('attendances')->insert($param);
        }
    }
}
