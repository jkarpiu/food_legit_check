<header class="{{$activeSite}} @if ($header ?? '' != False) admin @endif">
    <nav>
        <input type='checkbox' id="nav" class="hidden">
        <label for="nav" class="nav-btn">
            <i></i>
            <i></i>
            <i></i>
        </label>
        <div class="logo">
            <a href="/">FLC</a>
        </div>
        <div class="nav-wrapper">
            <ul>
                <li><a @if ($activeSite=='dashboard') class="active" @endif href="/dashboard">Panel</a>
                </li>
                <li>
                    @if (Auth::user()->role == 'Admin')
                    <a @if (stristr($activeSite, 'approve'))class="active" @endif href="/dashboard/approve">Produkty do zatwierdzenia</a>
                    @else
                    <a @if (stristr($activeSite, 'approve'))class="active" @endif href="/dashboard/approve">Oczekujące produkty</a>
                    @endif
                </li>
                <li><a @if ($activeSite=='account') class="active" @endif href="/dashboard/account">Ustawienia
                        konta</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">{{ __('Wyloguj') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    @if (strpos($activeSite, 'approve-list'))
    <section>
        @if (Auth::user()->role == 'Admin')
        <h2 class="header-title" data-aos="fade-up">Produkty do zatwierdzenia</h2>
        @else
        <h2 class="header-title" data-aos="fade-up">Oczekujące produkty na zatwierdzenie</h2>
        @endif
    </section>
    @endif
</header>
