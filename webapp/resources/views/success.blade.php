<?php
    $activeSite = 'add-product';
?>
@extends('layouts.master')
@section('content')
<article class="add-success">
    <h2>Sukces!</h2>
    <h3>Twój produkt został dodany i oczekuje na potwierdzenie przez administratora.</h3>
    <a href="{{ url('/add_product') }}">Dodaj następny produkt</a>
</article>
@endsection
