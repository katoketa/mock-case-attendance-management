<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @stack('css')
    <title>coachtech 勤怠管理アプリ</title>
</head>

<body class="body">
    <header class="header">
        @if (Auth::guard('admin')->check())
        <a href="{{ route('admin.index') }}" class="header-logo">
            <img src="{{ asset('image/COACHTECHヘッダーロゴ.png') }}" alt="coachtech" class="header-logo__img">
        </a>
        @else
        <a href="{{ route('attendance.create') }}" class="header-logo">
            <img src="{{ asset('image/COACHTECHヘッダーロゴ.png') }}" alt="coachtech" class="header-logo__img">
        </a>
        @endif
        <nav>
            <ul class="header-nav__ul">
                @if (Auth::guard('web')->check())
                <li class="header-nav__li">
                    <a href="{{ route('attendance.create') }}" class="header-nav__link">勤怠</a>
                </li>
                <li class="header-nav__li">
                    <a href="{{ route('attendance.index') }}" class="header-nav__link">勤怠一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="{{ route('revision_attendance.index') }}" class="header-nav__link">申請</a>
                </li>
                <li class="header-nav__li">
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="header-nav__link">ログアウト</button>
                    </form>
                </li>
                @elseif (Auth::guard('admin')->check())
                <li class="header-nav__li">
                    <a href="{{ route('admin.attendance.index') }}" class="header-nav__link">勤怠一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="{{ route('admin.staff.index') }}" class="header-nav__link">スタッフ一覧</a>
                </li>
                <li class="header-nav__li">
                    <a href="{{ route('revision_attendance.index') }}" class="header-nav__link">申請一覧</a>
                </li>
                <li class="header-nav__li">
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="header-nav__link">ログアウト</button>
                    </form>
                </li>
                @endif
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    @stack('scripts')
</body>

</html>