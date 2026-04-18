<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'name' => config('auth.admin_name'),
            'email' => config('auth.admin_email'),
            'password' => Hash::make(config('auth.admin_password')),
        ];
        DB::table('admins')->insert($param);
    }
}
