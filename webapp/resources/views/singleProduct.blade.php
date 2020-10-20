<?php
    $activeSite = 'single-product';
?>
@extends('layouts.master')
@section('content')
<article class="single-product-site">
    <div class="left-part">
        <img src="{{ $product -> image}}" alt="">
    </div>
    <div class="right-part">
        <h1>{{$product -> name}}</h1>
        <hr>
        <h2>Cena: {{$product -> price}} zł</h2>
        <h3 class="barcode">Kod kreskowy: {{$product -> barcode}}</h3>
        @if ($product -> components != NULL)
        <h3>Składniki: <span class="components">{{ $product -> components}}</span></h3>
        @endif
        @auth
            @if (Auth::user()->role == 'Admin')
            <section class="operations">
                <a href="{{ url('/product/'.$product-> id.'/edit') }}" class="edit">Edytuj</a>
                <a href="{{ url('/product/'.$product -> id.'/delete') }}" class="delete">Usuń</a>
            </section>
            @endif
        @endauth
    </div>
</article>
@endsection
