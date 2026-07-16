<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // メールアドレスが未入力の場合、バリデーションメッセージが表示される
        $data = [
            'password' => 'admin_pass',
        ];
        $response = $this->post(route('admin.execute'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);

        // パスワードが未入力の場合、バリデーションメッセージが表示される
        $data = [
            'email' =>'admin@email.com',
        ];
        $response = $this->post(route('admin.execute'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);

        // 登録内容と一致しない場合、バリデーションメッセージが表示される
        $data = [
            'email' => 'admin@email.com',
            'password' => 'admin_pass',
        ];
        $response = $this->post(route('admin.execute'), $data);
        $response->assertStatus(302);
        $response->assertSessionHas('login_failed_message', 'ログイン情報が登録されていません');
    }
}
