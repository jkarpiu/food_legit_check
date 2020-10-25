<article class="catalog-products bss">
    <section class="products-label">
        <a href="{{ url('/catalog') }}" class="product-tag" class="product-tag" data-aos="fade-up" data-aos-delay="100">Wszystko</a>
        @foreach($labels as $label)
        @if (!$loop->first)
        <a href="{{ url('/catalog/'.$label->category) }}" class="product-tag" data-aos="fade-up" data-aos-delay="{{100 * $loop->iteration}}">{{ $label -> category }}</a>
        @endif
        @endforeach
    </section>
    <article class="list-products">
        @foreach($products as $item)
        @if ($item -> image != 'http://www.eskleplewiatan.pl/templates/szablon_pit/grafika/brak_zdjecia_srednie.gif' and $item -> image != 'https://dodomku.pl/gfx/loading_grey_spinner.gif')
        @csrf
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
        @endif
        @endforeach
    </article>
    <article class="pagination">
        @include('pagination', ['paginator' => $products])
    </article>
</article>
