<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    const DUMMY_USER_NUM = 10;      // 6以上にしてください

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(self::DUMMY_USER_NUM)->create();

        $this->call(AdminSeeder::class);
        $this->call(AttendanceSeeder::class);
        $this->call(RevisionAttendanceSeeder::class);
        $this->call(BreakTimeSeeder::class);
        $this->call(RevisionBreakTimeSeeder::class);
    }
}
