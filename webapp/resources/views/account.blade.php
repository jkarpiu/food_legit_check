<?php
    $admin= True;
    $activeSite = 'account';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="user-options">
    <section class="user-container">
        <img data-aos='fade-right'
            src="{{ Auth::user()->avatar }}"
            alt="">
        <h2 data-aos="fade-right" data-aos-delay="600"><span class="title">Imie: </span>{{ Auth::user()->name}}</h2>
        <h2 data-aos="fade-right" data-aos-delay="1000"><span class="title">Rola: </span>{{ Auth::user()->role}}</h2>
        <h2 data-aos="fade-right" data-aos-delay="1400"><span class="title">Adres email: </span>{{ Auth::user()->email}}
        </h2>
        <h3 data-aos="fade-right" data-aos-delay="1800">Konto stworzone
            {{ Auth::user()->created_at -> format('d.m.Y').' o godzinie '.Auth::user()->created_at -> format('H:i:s')}}
        </h3>
        <section class="operations">
            <a href="{{ url('/dashboard/account/edit') }}" class="edit" data-aos="fade-up" data-aos-delay="2200">Edytuj
                konto</a>
            <a href="{{ url('/dashboard/account/change-password') }}" class="back" data-aos="fade-up"
                data-aos-delay="2500">Zmień hasło</a>
            <a href="{{ url('/dashboard/account/delete') }}" class="delete" data-aos="fade-up"
                data-aos-delay="2800">Usuń konto</a>
        </section>
    </section>
</article>
@endsection
