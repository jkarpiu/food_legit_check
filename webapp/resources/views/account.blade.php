<?php
    $admin= True;
    $activeSite = 'account';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="user-options">
    <img data-aos='fade-right'
        src="https://ocdn.eu/pulscms-transforms/1/ILLk9kqTURBXy9iMzI2YTkzMzZjOTI3NjhkNTFjY2EyNGFiYTUyMzgxZi5qcGVnkpUDACDNBADNAkCVAs0B4ADCw4KhMAWhMQE"
        alt="">
    <h2><span class="title">Imie: </span>{{ Auth::user()->name}}</h2>
    <h2><span class="title">Rola: </span>{{ Auth::user()->role}}</h2>
    <h2><span class="title">Adres email: </span>{{ Auth::user()->email}}</h2>
    <h3>Konto stworzone
        {{ Auth::user()->created_at -> format('d.m.Y').' o godzinie '.Auth::user()->created_at -> format('H:i:s')}}</h3>
    <section class="operations">
        <a href="{{ url('/dashboard/account/edit') }}" class="edit">Edytuj konto</a>
        <a href="{{ url('/dashboard/account/password/change') }}" class="back">Zmień hasło</a>
        <a href="{{ url('/dashboard/account/delete/'.Auth::user()->id) }}" class="delete">Usuń konto</a>
    </section>
</article>
@endsection
