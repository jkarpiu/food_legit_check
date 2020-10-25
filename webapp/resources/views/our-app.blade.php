<?php
    $activeSite = 'our-app';
?>
@extends('layouts.master')
@section('content')
<article class="mobile-app">
    <section class="download-app">
        <h2 data-aos="fade-up">Pobierz naszą aplikację</h2>
        <div data-aos="fade-up" data-aos-delay="800">
            <img src="/img/mobile-logo.png" alt="">
        </div>
    </section>
    <section class="gallery">
        <h2 data-aos="fade-up">Zobacz naszą aplikację</h2>
        <div data-aos="fade-up" data-aos-delay="800">
            <img src="/img/mockup.png" alt="">
        </div>
    </section>
    <section class="rate-app">
        <h2 data-aos="fade-up">Oceń naszą aplikację</h2>
        <div class="rating">
            @csrf
            <input type="radio" name="start" id="star1" @auth @if (Auth::user() -> rate and Auth::user() -> rate -> rate_scale == 5) checked @endif @endauth><label for="star1" data-aos="fade-up" data-aos-delay="1900"></label>
            <input type="radio" name="start" id="star2" @auth @if (Auth::user() -> rate and Auth::user() -> rate -> rate_scale == 4) checked @endif @endauth><label for="star2" data-aos="fade-up" data-aos-delay="1600"></label>
            <input type="radio" name="start" id="star3" @auth @if (Auth::user() -> rate and Auth::user() -> rate -> rate_scale == 3) checked @endif @endauth><label for="star3" data-aos="fade-up" data-aos-delay="1300"></label>
            <input type="radio" name="start" id="star4" @auth @if (Auth::user() -> rate and Auth::user() -> rate -> rate_scale == 2) checked @endif @endauth><label for="star4" data-aos="fade-up" data-aos-delay="1000"></label>
            <input type="radio" name="start" id="star5" @auth @if (Auth::user() -> rate and Auth::user() -> rate -> rate_scale == 1) checked @endif @endauth><label for="star5" data-aos="fade-up" data-aos-delay="700"></label>
        </div>
        <form action="{{ route('rate') }}" method="POST" autocomplete="off">
            @csrf
            <input type="hidden" id="rate_scale" name="rate_scale" value='0'>
        <textarea data-aos="fade-in" data-aos-delay="2200" name="content" id="content" minlength="4" maxlength="255">@auth @if (Auth::user() -> rate){{Auth::user()->rate->content}}@endif @endauth</textarea>
            <div data-aos="fade-up" data-aos-delay="2400">
                <button id="rate_us" type="submit" class="off" disabled>Oceń</button>
            </div>
        </form>
    </section>
</article>
<script>
    const stars = document.querySelectorAll('input[type="radio"]');
    stars.forEach(star => {
        star.addEventListener('click', check);
    })
    function check() {
        document.getElementById('rate_us').disabled = false;
        document.getElementById('rate_us').classList.remove('off');
        let scale = 5;
        stars.forEach(star => {
            if (!star.checked) {
                scale -= 1;
            } else {
                document.getElementById('rate_scale').value = scale;
            }
        })
    }
</script>
@endsection
