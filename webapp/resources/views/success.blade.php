<?php
    $activeSite = 'add-product';
?>
@extends('layouts.master')
@section('content')
<article class="add-success">
    <h2 data-aos="fade-up">Sukces!</h2>
    <h3 data-aos="fade-up" data-aos-delay="800">Twój produkt został dodany i oczekuje na potwierdzenie przez administratora.</h3>
    <a href="{{ url('/add_product') }}" data-aos="fade-up" data-aos-delay="1200">Dodaj następny produkt</a>
</article>
@endsection
