<style>
    body {
        padding-top: 70px;
    }

    @media screen and (min-width: 768px) {
        body {
            padding-top: 100px;
        }
    }
</style>

<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand mb-0 h1">#ЗаводНомерЧетыре</span>

        <button
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar"
            class="navbar-toggler"
            aria-controls="navbar"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="{{route('lists.index')}}" class="nav-link">
                        Главная
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="{{route('lists.create')}}" class="nav-link">
                        Создать
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{route('user.logout')}}" class="d-flex text-decoration-none text-light">Выйти</a>
    </div>
</nav>

