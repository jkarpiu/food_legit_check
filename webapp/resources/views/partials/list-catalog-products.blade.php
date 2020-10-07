<article class="catalog-products">
    <section class="products-label">
        <span data-filter="all" class="list active">Wszystko</span>
        <span data-filter="fast-food" class="list">Fast food'y</span>
        <span data-filter="ice-cream" class="list">Lody</span>
        <span data-filter="cookies" class="list">Ciastka</span>
        <span data-filter="drinks" class="list">Napoje</span>
    </section>
    <article class="list-products">
        @foreach(range(0, 5) as $item)
        <section class="single-product-outer drinks">
            <div class="img-box">
                <img src="/img/products/cola.jpg" alt="">
            </div>
            <div class="single-product-inner">
                <h3>Coca Cola</h3>
                <h4>Cukrzyca</h4>
            </div>
        </section>
        @endforeach
        @foreach(range(0, 5) as $item)
        <section class="single-product-outer fast-food">
            <div class="img-box">
                <img src="/img/products/pizza.jpg" alt="">
            </div>
            <div class="single-product-inner">
                <h3>Pizza</h3>
                <h4>Otyłość</h4>
            </div>
        </section>
        @endforeach
        @foreach(range(0, 5) as $item)
        <section class="single-product-outer cookies">
            <div class="img-box">
                <img src="/img/products/cookies.jpg" alt="">
            </div>
            <div class="single-product-inner">
                <h3>Ciastka</h3>
                <h4>Cukrzyca</h4>
            </div>
        </section>
        @endforeach
        @foreach(range(0, 5) as $item)
        <section class="single-product-outer ice-cream">
            <div class="img-box">
                <img src="/img/products/ice-cream.jpg" alt="">
            </div>
            <div class="single-product-inner">
                <h3>Lody</h3>
                <h4>Biegunka</h4>
            </div>
        </section>
        @endforeach
    </article>
</article>
