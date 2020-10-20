<?php
    $admin= True;
    $activeSite = 'approve';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="product-approve">
    <h2><span class="title-product">Zdjęcie:</span> <img src="{{ $product -> image ?? 'Brak' }}" alt=""></h2>
    <h2><span class="title-product">Id produktu:</span> {{ $product -> product_id }}</h2>
    <h2><span class="title-product">Kategoria:</span> {{ $product -> category }}</h2>
    <h2><span class="title-product">Nazwa:</span> {{ $product -> name ?? 'Brak' }}</h2>
    <h2><span class="title-product">Kod kreskowy:</span> {{ $product -> barcode  ?? 'Brak'}}</h2>
    <h2><span class="title-product">Składniki:</span> {{ $product -> components ?? 'Brak' }}</h2>
    <h2><span class="title-product">Skutki używania:</span> {{ $product -> effects ?? 'Brak' }}</h2>
    <h2><span class="title-product">Cena:</span> {{ $product -> price ?? 'Brak' }} zł</h2>
    <h2><span class="title-product">Czas dodania:</span> {{ $product -> created_at ?? 'Brak' }}</h2>
    <section class="operations">
        <a href="{{ url('/dashboard/approve/'.$product-> product_id.'/add') }}" class="approve">Zatwierdź</a>
        <a href="{{ url('/dashboard/approve/'.$product-> product_id.'/edit') }}" class="edit">Edytuj</a>
        <a href="{{ url('/dashboard/approve/'.$product -> product_id.'/delete') }}" class="delete">Usuń</a>
        <a href="{{ url('/dashboard/approve') }}" class="back">Wróć</a>
    </section>
</article>
@endsection
