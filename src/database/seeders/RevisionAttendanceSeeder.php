<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RevisionAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::today();
        for ($user_i = 1; $user_i <= 6; $user_i++) {
            for ($sub_day_j = 1; $sub_day_j <= 3; $sub_day_j++) {
                $revisionDate = $now->subDays($sub_day_j);
                $punch_in_at = $revisionDate->addHours(9)->addSeconds(random_int(-3600, 3600));
                $punch_out_at = $revisionDate->addHours(19)->addSeconds(random_int(-3600, 3600));
                if ($user_i <= 3) {
                    $is_approve = false;
                } else {
                    $is_approve = true;
                }
                $params[] = [
                    'user_id' => $user_i,
                    'punch_in_at' => $punch_in_at,
                    'punch_out_at' => $punch_out_at,
                    'remarks' => fake()->realText(30),
                    'is_approve' => $is_approve,
                ];
            }
        }
        foreach ($params as $param) {
            DB::table('revision_attendance')->insert($param);
        }
    }
}
