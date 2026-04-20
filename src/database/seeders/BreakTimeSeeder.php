<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Models\Attendance;

class BreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendances = Attendance::all();
        foreach ($attendances as $attendance) {
            $attendanceDate = new CarbonImmutable($attendance['attendance_on']);
            $start_break_at = $attendanceDate->addHours(12)->addSeconds(random_int(-3600, 3600));
            $end_break_at = $attendanceDate->addHours(13)->addSeconds(random_int(-3600, 3600));
            $params[] = [
                'attendance_id' => $attendance['id'],
                'start_break_at' => $start_break_at,
                'end_break_at' => $end_break_at,
            ];
        }
        foreach ($params as $param) {
            DB::table('break_times')->insert($param);
        }
    }
}
