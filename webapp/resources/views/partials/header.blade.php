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
        <input type="text" name="query" id="search" placeholder="Mleko" autocomplete="off" value="{{ $search ?? '' }}"
            autofocus>
    </form>
    @endif
    @if ($activeSite == 'login')
    <section class="login-section">
        <form class="login-box" method="POST" action="{{ route('login') }}">
            <h3>Logowanie</h3>
            @csrf
            <label for="email">{{ __('Adres email:') }}</label>
            <input id="email" type="email" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}"
                required autocomplete="email" autofocus>
            <label for="password" @error('email') style="color:red!important;" @enderror>{{ __('Hasło:') }}</label>
            <input id="password" type="password" @error('password') is-invalid @enderror name="password" required autocomplete="current-password" @error('email') class="error" @enderror>
            <label for="remember">
                {{ __('Zapamiętaj hasło') }}
            </label>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <button type="submit" class="btn btn-primary">
                {{ __('Zaloguj') }}
            </button>
            {{-- @if (Route::has('password.request'))
            <a class="remember" href="{{ route('password.request') }}">
                {{ __('Przypomnij hasło') }}
            </a>
            @endif --}}
            </div>
            </div>
        </form>
    </section>
    @endif
</header>
