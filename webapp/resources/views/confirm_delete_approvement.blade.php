<?php
    $admin= True;
    $activeSite = 'approve';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="user-options">
    <section class="user-container">
    <img data-aos='fade-right'
    src="{{ Auth::user()->avatar }}"
    alt="">
    <h2 data-aos="fade-right" data-aos-delay="600">Czy na pewno chcesz usunąć ten produkt?</h2>
    <section class="operations">
        <a href="{{ url()->current().'/confirmed' }}" class="delete" data-aos="fade-up" data-aos-delay="1000">Usuń produkt</a>
    </section>
    </section>
</article>
@endsection
