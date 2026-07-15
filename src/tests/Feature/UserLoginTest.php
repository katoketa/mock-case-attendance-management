<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
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
            'password' => 'user1user1',
        ];
        $response = $this->post('/login', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);

        // パスワードが未入力の場合、バリデーションメッセージが表示される
        $data = [
            'email' => 'user1@gmail.com',
        ];
        $response = $this->post('/login', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);

        // 登録内容と一致しない場合、バリデーションメッセージが表示される
        $data = [
            'email' => 'user1@gmail.com',
            'password' => 'user1user2',
        ];
        $response = $this->post('/login', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }
}
