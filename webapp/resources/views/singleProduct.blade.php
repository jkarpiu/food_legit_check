<?php
    $activeSite = 'single-product';
?>
@extends('layouts.master')
@section('content')
<article class="single-product-site">
    <div class="left-part" data-aos="fade-up">
        <img src="{{ $product -> image}}" alt="">
    </div>
    <div class="right-part">
        <h1 data-aos="fade-up" data-aos-delay="800">{{$product -> name}}</h1>
        <hr data-aos="fade-up" data-aos-delay="1000">
        <h2 data-aos="fade-up" data-aos-delay="1200">Cena: {{$product -> price}} zł</h2>
        <h3 data-aos="fade-up" data-aos-delay="1600" class="barcode">Kod kreskowy: {{$product -> barcode}}</h3>
        @if ($product -> components != NULL)
        <h3  data-aos="fade-up" data-aos-delay="2000">Składniki: <span class="components">{{ $product -> components}}</span></h3>
        @endif
        @if ($product -> illness != NULL)
        <h3  data-aos="fade-up" data-aos-delay="2400">Znane efekty spożycia: <span class="components">{{ $product -> illness}}</span></h3>
        @endif
        @auth
            @if (Auth::user()->role == 'Administrator')
            <section class="operations">
                <a data-aos="fade-up" data-aos-delay="2200" href="{{ url('/product/'.$product-> id.'/report') }}" class="back">Zgłoś</a>
                <a  data-aos="fade-up" data-aos-delay="2400" href="{{ url('/product/'.$product-> id.'/edit') }}" class="edit">Edytuj</a>
                <a  data-aos="fade-up" data-aos-delay="2600" href="{{ url('/product/'.$product -> id.'/delete') }}" class="delete">Usuń</a>
            </section>
            @else
            <section class="operations">
                <a data-aos="fade-up" data-aos-delay="2500"href="{{ url('/product/'.$product-> id.'/report') }}" class="back">Zgłoś produkt</a>
            </section>
            @endif
        @else
        <section class="operations">
            <a data-aos="fade-up" data-aos-delay="2200" href="{{ url('/product/'.$product-> id.'/report') }}" class="back">Zgłoś produkt</a>
        </section>
        @endauth
    </div>
</article>
@endsection
