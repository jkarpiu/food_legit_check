<?php
    $activeSite = 'dashboard';
    $admin = True;
?>
@extends('layouts.master')
@section('content')
<article class="activity-center @if (count($products) > 0)founded @endif">
    <section class="user-section">
        <img data-aos='fade-right' src="https://ocdn.eu/pulscms-transforms/1/ILLk9kqTURBXy9iMzI2YTkzMzZjOTI3NjhkNTFjY2EyNGFiYTUyMzgxZi5qcGVnkpUDACDNBADNAkCVAs0B4ADCw4KhMAWhMQE"
            alt="">
        <h2 data-aos='fade-right' data-aos-delay='400'>Cześć, {{ Auth::user()->name }}!</h2>
        <h3 data-aos='fade-right' data-aos-delay='800'>Poniżej znajduje się twój osobisty notatnik.</h3>
        <form action="{{ route('saveNote') }}" method="POST">
            @csrf
            <textarea name="notes" data-aos='fade-right' data-aos-delay="1200" maxlength="150"> {{ Auth::user()->note }} </textarea>
            <div class="button" data-aos='fade-right' data-aos-delay='1600'>
                <input type="submit" value="Zapisz">
            </div>
        </form>
    </section>
    <section class="@if (count($products) == 0)null-products @else new-products-to-approve @endif">
        <h2 data-aos='fade-up'>Ostatnio dodane produkty do zatwierdzenia:</h2>
        @if (count($products) > 0)
        <section class="approvement-list">
            @foreach ($products as $item)
            @csrf
            <section class="single-product-outer" data-aos="fade-up" data-aos-delay="{{400 * $loop->iteration}}">
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
                            <span>{{$item -> created_at -> format('d M Y')}}&nbsp;{{$item -> created_at -> format('H:m:s')}}</span>
                            @endif
                            </span></h6>
                    </div>
                </a>
            </section>
            @endforeach
        </section>
        <div data-aos='fade-up' data-aos-delay="1600">
            <a href="{{url('/dashboard/approve')}}" class="showAll">Zobacz wszystkie</a>
        </div>
        @else
        <div class="emptyApprovements" data-aos='fade-up' data-aos-delay="400">
            <h3>Brak nowych produktów do zatwierdzenia.</h3>
            <h4>Jak tylko pojawi się nowy produkt to zostaniesz o tym poinformowany!</h4>
        </div>
        @endif
    </section>
</article>
@endsection
