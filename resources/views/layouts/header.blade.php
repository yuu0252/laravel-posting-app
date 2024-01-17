<header>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a href="{{ route('posts.index') }}" class="navbar-brand">投稿アプリ</a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>
