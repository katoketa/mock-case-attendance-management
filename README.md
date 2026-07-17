# coachtech 勤怠管理アプリ
## 環境構築
### Dockerビルド
- `git@github.com:katoketa/mock-case-attendance-management.git`
- `cd mock-case-attendance-management`
- `docker-compose up --d --build`
### Laravel環境構築
- `docker-compose exec php bash`
- `composer install`
- `cp .env.example .env` , 環境変数を適宜変更
- `php artisan key:generate`
- `php artisan migrate --seed`
## 開発環境
- ユーザー登録：http://localhost/register
- 一般ユーザーログイン：http://localhost/login
- 一般ユーザーホーム画面：http://localhost/attendance
- 管理者ログイン：http://localhost/admin/login
- 管理者ホーム画面：http://localhost/admin/attendance/list
- phpMyAdmin：http://localhost:8080/
## 管理者ログインパスワード
- email：example@email.com
- password：admin_login_password
## 使用技術(実行環境)
- Laravel 12.56.0
- PHP 8.4.20
- MySQL 8.0.26
- nginx 1.21.1
## ER図
<img width="1522" height="762" alt="Image" src="https://github.com/user-attachments/assets/0f0a6b18-565a-4e8d-b72f-4b6a10e60477" />

## テスト実行
### テスト用データベースの準備
- mock-case-attendance-managementディレクトリ直下に戻る
- `docker-compose exec mysql bash`
- `mysql -u root -p` , docker-compose.ymlファイルに設定されているパスワードを入力
- `CREATE DATABASE demo_test;`
### テスト用.envファイルの作成
- mock-case-attendance-managementディレクトリ直下に戻る
- `docker-compose exec php bash`
- `cp .env .env.testing`
- .env.testingファイルのAPP_ENVとAPP_KEYを以下のように変更する
```
APP_ENV=test
APP_KEY=
```
- .env.testingにデータベースの接続情報を加える
```
DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root
```
- `php artisan key:generate --env=testing`
- `php artisan config:clear`
- `php artisan migrate --env=testing`
### phpunitの編集
- phpunit.xmlを開き、DB_CONNECTIONとDB_DATABASEを以下のように変更する
```
<server name="DB_CONNECTION" value="mysql_test"/>
<server name="DB_DATABASE" value="demo_test"/>
```
### 実行
- `php artisan test`
## 仕様について
- 勤怠一覧において勤怠が存在しないレコードの詳細ボタンを押した場合には、勤怠一覧画面にリダイレクトし、その日の勤怠が存在しない旨のメッセージが表示される。
- 勤怠の修正申請は、同じ勤怠に対して何度でも可能。
- 管理者用画面の日単位勤怠一覧で、その日の勤怠情報がないユーザーのユーザー情報は表示されない。