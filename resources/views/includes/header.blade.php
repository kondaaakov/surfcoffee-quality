<nav class="navbar navbar-expand-lg bg-light shadow-sm">
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
                    <a href="{{ route('spots') }}" class="nav-link {{ active_link('spots') }}" aria-current="page">
                        {{ __('Споты') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users') }}" class="nav-link {{ active_link('users*') }}" aria-current="page">
                        {{ __('Пользователи') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('guests') }}" class="nav-link {{ active_link('guests*') }}" aria-current="page">
                        {{ __('Секретные гости') }}
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ active_link(['categories*', 'templates*', 'polls*']) }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Опросы
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('polls') }}" class="nav-link {{ active_link('polls*') }}" aria-current="page">
                                {{ __('Опросы') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories') }}" class="nav-link {{ active_link('categories*') }}" aria-current="page">
                                {{ __('Категории') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('templates') }}" class="nav-link {{ active_link('templates*') }}" aria-current="page">
                                {{ __('Шаблоны') }}
                            </a>
                        </li>
                    </ul>
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
