<?php
    $activeSite = 'our-app';
?>
@extends('layouts.master')
@section('content')
<article class="add-success rate-page">
    <div data-aos="fade-up">
        <img src="/img/mobile-logo.png" alt="">
    </div>
    <h2 data-aos="fade-up" data-aos-delay="800" class="rate">Sukces!</h2>
    <h3 data-aos="fade-up" data-aos-delay="1200">Dziękujemy za twoją opinię.</h3>
    <div>
        <a href="{{ url(url()->previous()) }}" data-aos="fade-up" data-aos-delay="1600">Wróć</a>
    </div>
</article>
@endsection
