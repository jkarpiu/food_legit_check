<?php
    $admin= True;
    $activeSite = 'approve approve-list';
    $header = True;
?>
@extends('layouts.master')
@section('content')
<article class="products-to-approve list-products bss">
    @if (count($products) > 0)
    @foreach ($products as $item)
    @csrf
    <section class="single-product-outer" data-aos="fade-up" data-aos-delay="800">
        <a href="{{ url('dashboard/approve/'.$item -> product_id) }}">
            <div class="img-box">
                <img src="{{ $item -> image ?? '/img/products/woimg.jpg'}}" alt="">
            </div>
            <div class="single-product-inner">
                <h3 class="toap">{{ $item -> name }}</h3>
                <h4>Zatwierdzone: @if ($item -> is_approved == 0) <span style="color:red;">NIE</span>@else <span style="color: green;">TAK</span>@endif</h4>
            </div>
        </a>
    </section>
    @endforeach
    @else
    <div class="emptyApprovements" data-aos='fade-up' data-aos-delay="400">
        @if (Auth::user()->role == 'Administrator')
        <div data-aos='fade-up' data-aos-delay="800">
        <h3>Brak nowych produktów do zatwierdzenia.</h3>
        <h4>Jak tylko pojawi się nowy produkt to zostaniesz o tym poinformowany!</h4>
        </div>
        @else
        <div data-aos='fade-up' data-aos-delay="800">
        <h3>Brak czekujących produktów na zatwierdzenie.</h3>
        <h4>Jak tylko dodasz nowy produkt pojawi on się tutaj!</h4>
        </div>
        <div data-aos="fade-up" data-aos-delay="1200">
            <a href="{{ route('add-product') }}">Dodaj nowy produkt</a>
        </div>
        @endif
    </div>
    @endif
</article>

@endsection
