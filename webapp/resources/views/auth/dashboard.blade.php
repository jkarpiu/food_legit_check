<?php
    $activeSite = 'dashboard';
    $admin = True;
?>
@extends('layouts.master')
@section('content')
<article class="activity-center @if (count($products) > 0)founded @endif">
    <section class="user-section">
        <img data-aos='fade-right' src="{{ Auth::user()->avatar}}" alt="">
        <h2 data-aos='fade-right' data-aos-delay='400'>Cześć, {{ Auth::user()->name }}!</h2>
        <h3 data-aos='fade-right' data-aos-delay='800'>Poniżej znajduje się twój osobisty notatnik.</h3>
        <form action="{{ route('saveNote') }}" method="POST">
            @csrf
            <textarea name="notes" data-aos='fade-right' data-aos-delay="1200"
                maxlength="150">{{ Auth::user()->note }}</textarea>
            <div class="button" data-aos='fade-right' data-aos-delay='1600'>
                <input type="submit" value="Zapisz">
            </div>
        </form>
    </section>
    <section class="@if (count($products) == 0)null-products @else new-products-to-approve @endif">
        @if (Auth::user()->role == 'Admin')
        <h2 data-aos='fade-up'>Ostatnio dodane produkty do zatwierdzenia:</h2>
        @else
        <h2 data-aos='fade-up'>Ostatnie dodane przez ciebie produkty do zatwierdzenia:</h2>
        @endif
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
                        <h4>Zatwierdzone: @if ($item -> isApproved == 0) <span style="color:red;">NIE</span>@else <span style="color: green;">TAK</span>@endif</h4>
                    </div>
                </a>
            </section>
            @endforeach
        </section>
        {{-- <span class="other-count">+5 więcej</span> --}}
        @if (count(Auth::user()->approvements) > 3)
        <div data-aos='fade-up' data-aos-delay="1600">
            <a href="{{url('/dashboard/approve')}}" class="showAll">Zobacz wszystkie</a>
        </div>
        @endif
        @else
        <div class="emptyApprovements">
            @if (Auth::user()->role == 'Admin')
            <div data-aos='fade-up' data-aos-delay="400">
            <h3>Brak nowych produktów do zatwierdzenia.</h3>
            <h4>Jak tylko pojawi się nowy produkt to zostaniesz o tym poinformowany!</h4>
            </div>
            @else
            <div data-aos='fade-up' data-aos-delay="400">
            <h3>Brak czekujących produktów na zatwierdzenie.</h3>
            <h4>Jak tylko dodasz nowy produkt pojawi on się tutaj!</h4>
            </div>
            <div data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('add-product') }}">Dodaj nowy produkt</a>
            </div>
            @endif
        </div>
        @endif
    </section>
</article>
@endsection
