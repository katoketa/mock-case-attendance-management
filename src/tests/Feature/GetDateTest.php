<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\User;

class GetDateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // 現在の日時情報がUIと同じ形式で出力されている
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('attendance.create'));
        $response->assertStatus(200);
        $nowDate = Carbon::now()->isoFormat('Y年M月D日(dd)');
        $nowTime = Carbon::now()->format('H:i');
        $response->assertSee($nowDate);
        $response->assertSee($nowTime);
    }
}
