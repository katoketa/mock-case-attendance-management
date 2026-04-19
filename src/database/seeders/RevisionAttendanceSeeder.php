<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class RevisionAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::with('attendances')->get();
        foreach ($users as $user) {
            if ($user['id'] > 6) {
                break;
            }
            foreach ($user['attendances'] as $attendance) {
                if ($attendance['id'] > 5) {
                    break;
                }
                $revisionDate = new Carbon($attendance['punch_in_at']);
                $punch_in_at = $revisionDate->addHours(9)->addSeconds(random_int(-3600, 3600));
                $punch_out_at = $revisionDate->addHours(19)->addSeconds(random_int(-3600, 3600));
                if ($user['id'] <= 3) {
                    $is_approve = false;
                } else {
                    $is_approve = true;
                }
                $params[] = [
                    'attendance_id' => $attendance['id'],
                    'punch_in_at' => $punch_in_at,
                    'punch_out_at' => $punch_out_at,
                    'remarks' => fake()->realText(30),
                    'is_approve' => $is_approve,
                ];
            }
        }
        foreach ($params as $param) {
            DB::table('revision_attendances')->insert($param);
        }
    }
}
