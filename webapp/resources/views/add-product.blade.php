<?php
    $activeSite = 'add-product';
?>
@extends('layouts.master')
@section('content')
<article class="add-product-section">
    <form action="{{ route('uploadfile') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        <span class="first-part">
            <label for="name" @error('name') style="color: #a32a14" @enderror>Nazwa produktu: </label>
        <input type="text" name="name" maxlength="50" minlength="10" @error('name') class="error" placeholder="Podaj nazwę produktu" @enderror value="{{ old('name') }}">
            <span class="barcode-box">
                <label for="barcode" @error('barcode') style="color: #a32a14" @enderror>Kod kreskowy: </label>
                <input type="text" name="barcode" maxlength="14" @error('barcode') class="error" placeholder="Podaj kod kreskowy" @enderror value={{ old('barcode') }}>
            </span>
            <span class="image-box">
                <label for="image" @error('image') style="color: #a32a14" @enderror>Zdjęcie: </label>
                <input type="file" name="image" id="image">
            </span>
        </span>
        <span class="second-part">
            <label for="components">Składniki: </label>
            <textarea name="components" id="components">{{ old('components') }}</textarea>
            <label for="effects">Efekty stosowania: </label>
            <textarea name="effects" id="effects" maxlength="255">{{ old('effects') }}</textarea>
        </span>
        <span class="third-part">
            <label for="price" @error('price') style="color: #a32a14" @enderror>Cena: </label>
            <input type="text" name="price" @error('price') class="error" placeholder="Podaj cenę" @enderror minlength="4" maxlength="9" value={{ old('price') }}>
        </span>
        @csrf
        <input type="submit" value="Dodaj produkt">
    </form>
</article>
@endsection
