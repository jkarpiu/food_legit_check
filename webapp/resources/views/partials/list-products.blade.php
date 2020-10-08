<article class="list-products">
    @foreach(range(0, 10) as $item)
    <section class="single-product-outer">
        <div class="img-box">
            <img src="/img/products/pizza.jpg" alt="">
        </div>
        <div class="single-product-inner">
            <h3>Pizza</h3>
            <h4>Otyłość</h4>
        </div>
    </section>
    @endforeach
</article>
