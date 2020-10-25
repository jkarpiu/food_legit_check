<?php
    $admin= True;
    $activeSite = 'approve';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="add-product-section product">
    <h2 data-aos='fade-down' data-aos-delay="400">Edycja produktu</h2>
    <form action="{{ route('editApprovement') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$product -> product_id}}">
        <span class="first-part" data-aos="fade-up">
            <label for="name" @error('name') style="color: #a32a14" @enderror>Nazwa produktu: </label>
        <input type="text" name="name" maxlength="50" minlength="10" @error('name') class="error" placeholder="Podaj nazwę produktu" @enderror value="{{ $product -> name }}">
            <span class="barcode-box">
                <label for="barcode" @error('barcode') style="color: #a32a14" @enderror>Kod kreskowy: </label>
                <input type="text" name="barcode" maxlength="14" @error('barcode') class="error" placeholder="Podaj kod kreskowy" @enderror value={{ $product -> barcode }}>
            </span>
            <span class="image-box">
                <label for="image" @error('image') style="color: #a32a14" @enderror>Zdjęcie: </label>
                <input type="file" name="image" id="image">
            </span>
        </span>
        <span class="second-part" data-aos="fade-in" data-aos-delay="800">
            <label for="components">Składniki: </label>
            <textarea name="components" id="components">{{ $product -> components  }}</textarea>
            <label for="effects">Efekty spożycia: </label>
            <textarea name="effects" id="effects" maxlength="255">{{ $product -> effects  }}</textarea>
        </span>
        <span class="third-part" data-aos="fade-up" data-aos-delay="1200">
            <label for="category">Kategoria: </label>
            <select name="categories" id="categories">
                <option value="Alkohol" @if ($product -> category == 'Alkohol') selected @endif>Alkohol</option>
                <option value="Dania i konserwy" @if ($product -> category == 'Dania i konserwy') selected @endif>Dania i konserwy</option>
                <option value="Desery i wypieki" @if ($product -> category == 'Desery i wypieki') selected @endif>Desery i wypieki</option>
                <option value="Gotowe obiady" @if ($product -> category == 'Gotowe obiady') selected @endif>Gotowe obiady</option>
                <option value="Inne" @if ($product -> category == 'Inne') selected @endif>Inne</option>
                <option value="Mrożonki" @if ($product -> category == 'Mrożonki') selected @endif>Mrożonki</option>
                <option value="Napoje" @if ($product -> category == 'Napoje') selected @endif>Napoje</option>
                <option value="Owoce i warzywa" @if ($product -> category == 'Owoce i warzywa') selected @endif>Owoce i warzywa</option>
                <option value="Pieczywo" @if ($product -> category == 'Pieczywo') selected @endif>Pieczywo</option>
                <option value="Produkty świeże" @if ($product -> category == 'Produkty świeże') selected @endif>Produkty świeże</option>
                <option value="Produkty sypkie i makarony" @if ($product -> category == 'Produkty sypkie i makarony') selected @endif>Produkty sypkie i makarony</option>
                <option value="Przekąski" @if ($product -> category == 'Przekąski') selected @endif>Przekąski</option>
                <option value="Przetwory" @if ($product -> category == 'Przetwory') selected @endif>Przetwory</option>
                <option value="Przyprawy" @if ($product -> category == 'Przyprawy') selected @endif>Przyprawy</option>
                <option value="Płatki śniadaniowe" @if ($product -> category == 'Płatki śniadaniowe') selected @endif>Płatki śniadaniowe</option>
                <option value="Sosy, oleje, ocet" @if ($product -> category == 'Sosy, oleje, ocet') selected @endif>Sosy, oleje, ocet</option>
                <option value="Słodycze" @if ($product -> category == 'Słodycze') selected @endif>Słodycze</option>
                <option value="Wędliny" @if ($product -> category == 'Wędliny') selected @endif>Wędliny</option>
                <option value="Zdrowa żywność" @if ($product -> category == 'Zdrowa żywność') selected @endif>Zdrowa żywność</option>
                <option value="Żywność dla dzieci" @if ($product -> category == 'Źywność dla dzieci') selected @endif>Żywność dla dzieci</option>
            </select>
            <label for="price" @error('price') style="color: #a32a14" @enderror>Cena: </label>
            <input type="text" name="price" @error('price') class="error" placeholder="Podaj cenę" @enderror minlength="4" maxlength="9" value={{ $product -> price }}>
        </span>
        @csrf
        <div data-aos="fade-up" data-aos-delay="1600">
            <input type="submit" value="Zedytuj">
        </div>
    </form>
</article>
@endsection
