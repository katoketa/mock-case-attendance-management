<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonImmutable;
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
            for ($attendance_i = 0; $attendance_i < 5; $attendance_i++) {
                $attendance = $user['attendances'][$attendance_i];
                $revisionDate = new CarbonImmutable($attendance['attendance_on']);
                $punchInAt = $revisionDate->addHours(9)->addSeconds(random_int(-3600, 3600));
                $punchOutAt = $revisionDate->addHours(19)->addSeconds(random_int(-3600, 3600));
                if ($user['id'] <= 3) {
                    $isApprove = false;
                } else {
                    $isApprove = true;
                }
                $params[] = [
                    'attendance_id' => $attendance['id'],
                    'punch_in_at' => $punchInAt,
                    'punch_out_at' => $punchOutAt,
                    'remarks' => fake()->realText(30),
                    'is_approve' => $isApprove,
                ];
            }
        }
        foreach ($params as $param) {
            DB::table('revision_attendances')->insert($param);
        }
    }
}
