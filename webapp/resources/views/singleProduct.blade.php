<?php
    $activeSite = '';
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
    </div>
</article>
@endsection
