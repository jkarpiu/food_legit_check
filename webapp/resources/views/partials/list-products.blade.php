<article class="list-products">
    @if ($products ?? '')
    @if (count($products) > 0)
    @foreach($products as $item)
    <section class="single-product-outer {{ $item -> category }}" data-aos="fade-up">
        <a href="/product/{{ $item -> id}}">
            <div class="img-box">
                <img src="{{ $item -> image}}" alt="">
            </div>
            <div class="single-product-inner">
                <h3>{{ $item -> name }}</h3>
                <h5>Kod kreskowy: {{ $item -> barcode}}</h5>
                <h4>Cena: {{ $item -> price}} zł</h4>
            </div>
        </a>
    </section>
    @endforeach
    @else
    <article class="empty-box">
        <h2>Brak produktów o podanej frazie.</h2>
        <h3>Spróbuj wyszukać coś innnego.</h3>
    </article>
    @endif
    @else
    <article class="empty-box">
        <h2>Wpisz frazę, aby znaleźć produkt, który cię interesuje.</h2>
    </article>
    @endif
</article>
