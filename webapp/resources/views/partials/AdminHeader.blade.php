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
                <li><a @if (stristr($activeSite, 'approve'))class="active" @endif href="/dashboard/approve">Produkty do zatwierdzenia</a>
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
        <h2 class="header-title">Produkty do zatwierdzenia</h2>
    </section>
    @endif
</header>
