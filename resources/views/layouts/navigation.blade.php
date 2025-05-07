<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
{{--        <a class="navbar-brand" href="{{ route('circuits.index') }}">PLD-Manager</a>--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
{{--                    <a class="nav-link" href="{{ route('circuits.index') }}">Схемы</a>--}}
                </li>
                <li class="nav-item">
{{--                    <a class="nav-link" href="{{ route('circuits.create') }}">Создать схему</a>--}}
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Выйти</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
