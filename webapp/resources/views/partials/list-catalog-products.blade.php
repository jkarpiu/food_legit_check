<article class="catalog-products">
    <section class="products-label">
        <span data-filter="all" class="list active">Wszystko</span>
        <span data-filter="pasta" class="list">Makarony</span>
        <span data-filter="ice-cream" class="list">Lody</span>
        <span data-filter="cookies" class="list">Ciastka</span>
        <span data-filter="drinks" class="list">Napoje</span>
    </section>
    <article class="list-products">
        @foreach($products as $item)
        <section class="single-product-outer drinks">
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
</article>
</article>

