<?php
    $activeSite = 'add-product';
?>
@extends('layouts.master')
@section('content')
<article class="add-product-section">
    <form action="" autocomplete="off">
        <span class="first-part">
            <label for="name">Nazwa produktu: </label>
            <input type="text" name="name" maxlength="25">
            <label for="image">Zdjęcie: </label>
            <input type="file" name="image" id="image">
        </span>
        <span class="second-part">
        <label for="components">Składniki: </label>
        <textarea name="components" id="components"></textarea>
        <label for="effects">Efekty stosowania: </label>
        <textarea name="effects" id="effects"></textarea>
    </span>
        <input type="submit" value="Dodaj produkt">
    </form>
</article>
@endsection
