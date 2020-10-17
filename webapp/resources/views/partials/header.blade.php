<header class="{{$activeSite}}">
    <nav>
        <input type='checkbox' id="nav" class="hidden">
        <label for="nav" class="nav-btn">
            <i></i>
            <i></i>
            <i></i>
        </label>
        <div class="logo">
            <a href="/#">FLC</a>
        </div>
        <div class="nav-wrapper">
            <ul>
                <li><a @if ($activeSite=='add-product' ) class="active" @endif href="/add_product">Dodaj produkt</a>
                </li>
                <li><a @if ($activeSite=='catalog' ) class="active" @endif href="/catalog">Katalog produktów</a></li>
                <li><a @if ($activeSite=='our-app' ) class="active" @endif href="/our_app">Nasza aplikacja</a></li>
            </ul>
        </div>
    </nav>
    @if ($activeSite == 'home')
    <form action="{{ url('/search') }}" method="get">
    <input type="text" name="query" id="search" placeholder="Mleko" autocomplete="off" value="{{ $search ?? '' }}" autofocus>
    </form>
    @endif
    @if ($activeSite == 'approve')
    <section>
        <h2 class="header-title">Produkty do zatwierdzenia</h2>
    </section>
    @endif
</header>
