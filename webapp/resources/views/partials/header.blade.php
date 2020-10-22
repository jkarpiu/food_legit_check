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
                <li><a @if ($activeSite=='catalog' or $activeSite=='single-product' ) class="active" @endif href="/catalog">Katalog produktów</a></li>
                <li><a @if ($activeSite=='our-app' ) class="active" @endif href="/our_app">Nasza aplikacja</a></li>
                @guest
                @if ($activeSite != 'register')
                <li><a @if ($activeSite=='login' ) class="active" @endif href="{{ route('login') }}">Logowanie</a></li>
                @else
                <li><a class="active" href="{{ route('register') }}">Rejestracja</a></li>
                @endif
                @else
                <li><a href="{{ route('dashboard') }}">Konto</a></li>
                @endguest
            </ul>
        </div>
    </nav>
    @if ($activeSite == 'home')
    <form action="{{ url('/search') }}" method="get">
        <input type="text" name="query" id="search" placeholder="Mleko" autocomplete="off" value="{{ $search ?? '' }}" autofocus>
    </form>
    @endif
    @if ($activeSite == 'login')
    <section class="login-section">
        <form class="login-box" method="POST" action="{{ route('login') }}" data-aos="fade-right">
            <h3>Logowanie</h3>
            @csrf
            <label for="email">{{ __('Adres email:') }}</label>
            <input id="email" type="email" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}"
                required autocomplete="email" autofocus>
            <label for="password" @error('email') style="color:#a32a14!important;" @enderror>{{ __('Hasło:') }}</label>
            <input id="password" type="password" @error('password') is-invalid @enderror name="password" required
                autocomplete="current-password" @error('email') class="error" @enderror>
            <span class="remember-span">
                <label for="remember">
                    {{ __('Zapamiętaj hasło')}}
                </label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            </span>
            <button type="submit">
                {{ __('Zaloguj')}}
            </button>
            @if (Route::has('password.request'))
            <a class="remember" href="{{ route('password.request') }}">
                {{ __('Przypomnij hasło')}}
            </a>
            @endif
            <a class="new_account" href="{{ route('register') }}">
                {{ __('Utwórz nowe konto')}}
            </a>
        </form>
        @if ($errors->all())
        <section class="errors-box" data-aos="fade-left" data-aos-delay="1000">
            <h3>Wykryto błędy</h3>
            <ul>
                @foreach($errors->all() as $error)
                <li> {{ $error }}</li>
                @endforeach
            </ul>
        </section>
        @endif
    </section>
    @endif
    @if ($activeSite == 'register')
    <section class="login-section register">
        <form class="login-box register" method="POST" action="{{ route('register') }}" data-aos="fade-right">
            <h3>Rejestracja</h3>
            @csrf
            <label for="name" @error('name') style="color:#a32a14!important;" @enderror>{{ __('Imie:') }}</label>
            <input id="name" type="text" @error('name') is-invalid @enderror name="name" value="{{ old('name') }}" required autocomplete="name" autofocus @error('name') class="error" @enderror>
            <label for="email"  @error('email') style="color:#a32a14!important;" @enderror>{{ __('Adres email:') }}</label>
            <input id="email" type="email" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus @error('email') class="error" @enderror>
            <label for="password" @error('password') style="color:#a32a14!important;" @enderror>{{ __('Hasło:') }}</label>
            <input id="password" type="password" @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" @error('password') class="error" @enderror>
            <label for="password-confirm" @error('password') style="color:#a32a14!important;"
                @enderror>{{ __('Potwierdzenie hasła:') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" required
                autocomplete="new-password" @error('password') class="error" @enderror>
            <button type="submit">
                {{ __('Utwórz') }}
            </button>
            <a class="already" href="{{ route('login') }}">
                {{ __('Masz już konto?') }}
            </a>
        </form>
                @if ($errors->all())
                <section class="errors-box" data-aos="fade-left">
                    <h3>Wykryto błędy</h3>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li> {{ $error }}</li>
                        @endforeach
                    </ul>
                </section>
                @endif
    </section>
    @endif
</header>
