@php($currency=App\Product::currency())
<section class="uk-text-left uk-padding-small">
 <div class="uk-card radius uk-card-default uk-width-1-1@m">
    <div class="uk-card-header uk-padding-small" style="padding-top:10px;padding-bottom:10px;">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
            <h3 class="uk-card-title uk-margin-remove-bottom">Featured Products</h3>
        </div>
    </div>
    <div class="uk-card-body uk-padding-remove" style="background:url(/images/sliders/2.jpg); background-size:cover;" >
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m">
        @forelse(App\Product::frequentBuy() as $product)
        <li class="uk-padding-small">
        <a href="/shop/product-{{$product->id}}/{{$product->name}}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
        <div class="uk-card uk-card-default uk-card-hover">
            <div class="uk-card-media-top">
                <img style="width:100%;height:200px; min-height:200px;" src="{{ $product->display_image ?? '/images/product/placeholder.png'}}" alt="">
            </div>
            <div style="max-height:80px;" class="uk-card-footer uk-hover">
            <p class="uk-text-truncate uk-padding-remove uk-margin-remove">{{$product->name}}</p>
            <span class="price uk-padding-remove uk-margin-remove">
                <span class="amount"><span class="currencySymbol">{{$currency}}</span>{{$product->price}}</span>
            </span>
            </div>
        </div>
        </a>
        </li>
        @empty
        <li>
        </div>
            no frequent buy items
        </div>
        </li>
        @endforelse
     </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" style="color:red" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" style="color:red" href="#" uk-slidenav-next uk-slider-item="next"></a>

</div>
   </div>
   
</div>
</section>
