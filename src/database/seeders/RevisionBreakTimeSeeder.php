<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\RevisionAttendance;

class RevisionBreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $revisionAttendances = RevisionAttendance::all();
        foreach ($revisionAttendances as $revision) {
            $revisionDate = new Carbon($revision['punch_in_at']);
            $start_break_at = $revisionDate->addHours(12)->addSeconds(random_int(-3600, 3600));
            $end_break_at = $revisionDate->addHours(13)->addSeconds(random_int(-3600, 3600));
            $params[] = [
                'revision_attendance_id' => $revision['id'],
                'start_break_at' => $start_break_at,
                'end_break_at' => $end_break_at,
            ];
        }
        foreach ($params as $param) {
            DB::table('revision_break_times')->insert($param);
        }
    }
}
