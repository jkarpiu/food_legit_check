<?php
    $admin= True;
    $activeSite = 'account';
    $header = False;
    $delay = 1800;
?>
@extends('layouts.master')
@section('content')
<article class="user-options chpass">
    <h2 data-aos='fade-right' data-aos-delay="400">Zmiana hasła</h2>
    <form class="user-form" method="POST" action="{{ route('change.password') }}">
        @csrf
        <label data-aos='fade-right' data-aos-delay="800" for="password" @error('current_password') style="color:#a32a14!important" @enderror>Akutalne
            hasło:</label>
        <input data-aos='fade-right' data-aos-delay="800" id="password" type="password" name="current_password" autocomplete="current-password" required
            @error('current_password') class="error" @enderror>
        <label data-aos='fade-right' data-aos-delay="1200" for="password" @error('password') style="color:#a32a14!important" @enderror>Nowe hasło:</label>
        <input data-aos='fade-right' data-aos-delay="1200" id="new_password" type="password" name="password" autocomplete="current-password" required minlength="8" maxlength="32" @error('password') class="error" @enderror>
        <label data-aos='fade-right' data-aos-delay="1600" for="password" @error('new_confirm_password') style="color:#a32a14!important" @enderror>Potwierdzenie nowego hasła:</label>
        <input data-aos='fade-right' data-aos-delay="1600" id="new_confirm_password" type="password" name="new_confirm_password" autocomplete="current-password" required minlength="8" maxlength="32" @error('new_confirm_password') class="error" @enderror>
        <div data-aos='fade-up' data-aos-delay="1900">
            <button type="submit">
                Zmień hasło
            </button>
        </div>
    </form>
    @if ($errors->all())
    <ul>
        @foreach ($errors->all() as $error)
        <li data-aos='fade-right' data-aos-delay={{$delay + (400 * $loop->iteration)}}>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
</article>
@endsection
