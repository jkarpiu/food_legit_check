<?php
    $admin= True;
    $activeSite = 'approve';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="product-approve">
    <h2><span class="title-product" data-aos="fade-right">Zdjęcie:</span> <img src="{{ $product -> image ?? 'Brak' }}"
            alt="" data-aos="fade-left"></h2>
    <h2 data-aos="fade-right" data-aos-delay="600"><span class="title-product">Id produktu:</span>
        {{ $product -> product_id }}</h2>
    <h2 data-aos="fade-right" data-aos-delay="800"><span class="title-product">Kategoria:</span>
        {{ $product -> category }}</h2>
    <h2 data-aos="fade-right" data-aos-delay="1000"><span class="title-product">Nazwa:</span>
        {{ $product -> name ?? 'Brak' }}</h2>
    <h2 data-aos="fade-right" data-aos-delay="1200"><span class="title-product">Kod kreskowy:</span>
        {{ $product -> barcode  ?? 'Brak'}}</h2>
    <h2 data-aos="fade-right" data-aos-delay="1400"><span class="title-product">Składniki:</span>
        {{ $product -> components ?? 'Brak' }}</h2>
    <h2 data-aos="fade-right" data-aos-delay="1600"><span class="title-product">Skutki używania:</span>
        {{ $product -> effects ?? 'Brak' }}</h2>
    <h2 data-aos="fade-right" data-aos-delay="1800"><span class="title-product">Cena:</span>
        {{ $product -> price ?? 'Brak' }} zł</h2>
    <h2 data-aos="fade-right" data-aos-delay="2000"><span class="title-product">Czas dodania:</span>
        {{ $product -> created_at ?? 'Brak' }}</h2>
    @if (Auth::user() -> role == 'Administrator')
    <h2 data-aos="fade-right" data-aos-delay="2100"><span class="title-product">Dodane przez:</span> {{ $product -> user -> email }}</h2>
    @endif
    <h2 data-aos="fade-right" data-aos-delay="2200"><span class="title-product">Zatwierdzone:</span> @if ($product ->
        is_approved == 0) <span style="color:red;">NIE</span>@else <span style="color: green;">TAK</span>@endif</h2>
    <section class="operations">
        @if (Auth::user()->role == 'Administrator')
            @if ($product -> is_approved == 0)
                <a href="{{ url('/dashboard/approve/'.$product-> product_id.'/add') }}" class="approve" data-aos="fade-up"
                    data-aos-delay="2200">Zatwierdź</a>
            @else
                <a href="{{ url('/dashboard/approve/'.$product-> product_id.'/undo') }}" class="undo" data-aos="fade-up"
                    data-aos-delay="2200">Cofnij</a>
            @endif
        @endif
            <a href="{{ url('/dashboard/approve/'.$product-> product_id.'/edit') }}" class="edit" data-aos="fade-up"
                data-aos-delay="2400">Edytuj</a>
            <a href="{{ url('/dashboard/approve/'.$product -> product_id.'/delete') }}" class="delete" data-aos="fade-up"
                data-aos-delay="2600">Usuń</a>
            <a href="{{ url('/dashboard/approve') }}" class="back" data-aos="fade-up" data-aos-delay="2800">Wróć</a>
    </section>
</article>
@endsection
