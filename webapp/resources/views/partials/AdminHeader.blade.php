<header class="{{$activeSite}} @if ($header ?? '' != False) admin @endif">
    <nav>
        <input type='checkbox' id="nav" class="hidden">
        <label for="nav" class="nav-btn">
            <i></i>
            <i></i>
            <i></i>
        </label>
        <div class="logo">
            <a href="/dashboard">Dashboard</a>
        </div>
        <div class="nav-wrapper">
            <ul>
                <li><a @if ($activeSite=='approve' ) class="active" @endif href="/dashboard/approve">Produkty do zatwierdzenia</a>
                </li>
                <li><a @if ($activeSite=='account' ) class="active" @endif href="/dashboard/account">Ustawienia konta</a></li>
                <li><a href="/logout">Wyloguj</a></li>
            </ul>
        </div>
    </nav>
    @if ($activeSite == 'approve-list')
    <section>
        <h2 class="header-title">Produkty do zatwierdzenia</h2>
    </section>
    @endif
    @if ($activeSite == 'account')
    <section>
        <h2 class="header-title">Ustawienia konta</h2>
    </section>
    @endif
</header>
