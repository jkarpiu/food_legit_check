<article class="catalog-products">
    <section class="products-label">
        <a href="{{ url('/catalog') }}" class="list">Wszystko</a>
        @foreach($labels as $label)
        @if (!$loop->first)
        <a href="{{ url('/catalog/'.$label->category) }}" class="list">{{ $label -> category }}</a>
        @endif
        @endforeach
    </section>
    <article class="list-products">
        @foreach($products as $item)
        {{ csrf_field() }}
        <section class="single-product-outer" data-aos="fade-up">
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
    <article class="ShowMore">
        <a href="" class="load_more" data-aos="fade-in">Pokaż więcej</a>
    </article>
</article>
