<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
use App\Models\RevisionAttendance;

class RevisionBreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $revisionAttendances = RevisionAttendance::with('attendance')->get();
        foreach ($revisionAttendances as $revision) {
            $revisionDate = new CarbonImmutable($revision['attendance']['punch_in_at'])->setTime(0, 0, 0);
            $startBreakAt = $revisionDate->addHours(12)->addSeconds(random_int(-3600, 3600));
            $endBreakAt = $revisionDate->addHours(13)->addSeconds(random_int(-3600, 3600));
            $params[] = [
                'revision_attendance_id' => $revision['id'],
                'start_break_at' => $startBreakAt,
                'end_break_at' => $endBreakAt,
            ];
        }
        foreach ($params as $param) {
            DB::table('revision_break_times')->insert($param);
        }
    }
}
