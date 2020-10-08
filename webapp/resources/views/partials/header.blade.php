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
                <li><a @if ($activeSite == 'add-product') class="active" @endif href="/add-product">Dodaj produkt</a></li>
                <li><a @if ($activeSite == 'catalog') class="active" @endif href="/catalog">Katalog produktów</a></li>
                <li><a @if ($activeSite == 'our-app') class="active" @endif href="/our-app">Nasza aplikacja</a></li>
            </ul>
        </div>
    </nav>
    @if ($activeSite == 'home')
        <input type="text" name="search" id="search" placeholder="Pizza" autocomplete="off">
        @endif
</header>
