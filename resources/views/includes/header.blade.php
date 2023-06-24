<nav class="navbar navbar-expand-md bg-light">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">{{ config('app.name') }}</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="navbar-nav me-auto mb-3 mb-md-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ active_link('home') }}" aria-current="page">
                        {{ __('Главная') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users') }}" class="nav-link {{ active_link('users*') }}" aria-current="page">
                        {{ __('Пользователи') }}
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-md-0">

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link {{ active_link('logout') }}" aria-current="page">
                        {{ __('Выход') }}
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
