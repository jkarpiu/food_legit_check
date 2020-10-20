<?php
    $admin= True;
    $activeSite = 'account';
    $header = False;
?>
@extends('layouts.master')
@section('content')
<article class="user-options chpass">
    <h2 data-aos='fade-right' data-aos-delay="400">Edycja użytkownika</h2>
    <form class="user-form" method="POST" action="{{ route('editUser') }}" enctype="multipart/form-data">
        @csrf
        <span class="image-box">
            <label data-aos='fade-right' data-aos-delay="800" for="image" @error('image') style="color: #a32a14" @enderror>Zdjęcie: </label>
            <input data-aos='fade-right' data-aos-delay="1000" type="file" name="image" id="image">
        </span>
        <label data-aos='fade-right' data-aos-delay="1200" for="name" @error('name') style="color:#a32a14!important" @enderror>Imie:</label>
        <input data-aos='fade-right' data-aos-delay="1400" id="name" type="text" name="name" autocomplete required minlength="2" maxlength="16" @error('name') class="error" @enderror value={{ Auth::user()->name }}>
        <label data-aos='fade-right' data-aos-delay="1600" for="email" @error('email') style="color:#a32a14!important" @enderror>Email:</label>
        <input data-aos='fade-right' data-aos-delay="1800" id="email" type="email" name="email" autocomplete required maxlength="25" @error('email') class="error" @enderror value={{ Auth::user()->email }}>
        <div data-aos='fade-up' data-aos-delay="2200">
            <button type="submit">
                Zedytuj
            </button>
        </div>
    </form>
</article>
@endsection
