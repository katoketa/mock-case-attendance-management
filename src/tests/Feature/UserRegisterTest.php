<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // 名前が未入力の場合、バリデーションメッセージが表示される
        $data = [
            'email' => 'user1@gmail.com',
            'password' => 'user1user1',
            'password_confirmation' => 'user1user1',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);

        // メールアドレスが未入力の場合、バリデーションメッセージが表示される
        $data = [
            'name' => 'user1',
            'password' => 'user1user1',
            'password_confirmation' => 'user1user1',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);

        // パスワードが8文字未満の場合、バリデーションメッセージが表示される
        $data = [
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'user1',
            'password_confirmation' => 'user1',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);

        // パスワードが一致しない場合、バリデーションメッセージが表示される
        $data = [
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'user1user1',
            'password_confirmation' => 'user1user2',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);

        // パスワードが未入力の場合、バリデーションメッセージが表示される
        $data = [
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password_confirmation' => 'user1user1',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);

        // フォームに内容が入力されていた場合、データが正常に保存される
        $data = [
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => 'user1user1',
            'password_confirmation' => 'user1user1',
        ];
        $response = $this->post('/register', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['name' => 'user1', 'email' => 'user1@gmail.com']);
    }
}
