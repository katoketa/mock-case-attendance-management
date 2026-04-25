<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>coachtech 勤怠管理アプリ</title>
</head>

<body>
    <header class="header">
        <div class="header-logo">
            <img src="{{ asset('image/COACHTECHヘッダーロゴ.png') }}" alt="coachtech" class="header-logo__img">
        </div>
        <nav>
            <ul class="header-nav__ul">
                @if (Auth::guard('web')->check())
                <li class="header-nav__li">
                    <a href="/attendance" class="header-nav__a">勤怠</a>
                </li>
                <li class="header-nav__li">
                    <a href="/attendance/list" class="header-nav__a">勤怠一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="/stamp_correction_request/list" class="header-nav__a">申請</a>
                </li>
                <li class="header-nav__li">
                    <a href="/logout" class="header-nav__a">ログアウト</a>
                </li>
                @elseif (Auth::guard('admin')->check())
                <li class="header-nav__li">
                    <a href="admin/attendance/list" class="header-nav__a">勤怠一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="admin/staff/list" class="header-nav__a">スタッフ一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="stamp_correction_request/list" class="header-nav__a">申請一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="/logout" class="header-nav__a">ログアウト</a>
                </li>
                @endif
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    @yield('script')
</body>

</html>