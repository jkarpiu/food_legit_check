<?php
    $activeSite = 'single-product';
?>
@extends('layouts.master')
@section('content')
<article class="report-product">
    <h2 data-aos="fade-up">Zgłaszanie produktu</h2>
    <form action="{{ route('report') }}" method="POST" autocomplete="off">
        @csrf
    <input type="hidden" name="product_id" value="{{$product_id}}">
        <textarea data-aos="fade-in" data-aos-delay="800" name="content" id="content"></textarea>
        <div data-aos="fade-up" data-aos-delay="1200">
            <button type="submit">Zgłoś produkt</button>
        </div>
    </form>
</article>
@endsection
