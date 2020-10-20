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
    <section class="single-product-outer" data-aos="fade-up">
        <a href="{{ url('dashboard/approve/'.$item -> product_id) }}">
            <div class="img-box">
                <img src="{{ $item -> image ?? '/img/products/woimg.jpg'}}" alt="">
            </div>
            <div class="single-product-inner">
                <h3 class="toap">{{ $item -> name }}</h3>
                <h5>Kod kreskowy: {{ $item -> barcode ?? 'Brak'}}</h5>
                <h4>Cena: {{ $item -> price}} zł</h4>
                <h6>Czas dodania:
                    @if ($item -> created_at)
                    <span>{{$item -> created_at -> format('d M Y')}}&nbsp;{{$item -> created_at -> format('H:i:s')}}</span>
                    @endif</h6>
            </div>
        </a>
    </section>
    @endforeach
    @else
    <div class="emptyApprovements" data-aos='fade-up' data-aos-delay="400">
        <h3>Brak nowych produktów do zatwierdzenia.</h3>
        <h4>Jak tylko pojawi się nowy produkt to zostaniesz o tym poinformowany!</h4>
    </div>
    @endif
</article>

@endsection
