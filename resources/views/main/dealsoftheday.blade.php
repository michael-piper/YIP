@php($currency=App\Product::currency())
<section class="uk-text-left uk-padding-small">
 <div class="uk-card radius-large uk-card-default uk-width-1-1@m">

    <div class="uk-card-body uk-padding-remove">
            <div class="uk-grid-small uk-flex-middle uk-padding-small" uk-grid>
                    <h4 class="uk-margin-remove-bottom">Deals of the day</h4>
                </div>
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-6@m">
        @forelse(App\Product::frequentBuy() as $product)
        <li class="uk-padding-small">
        <a href="/shop/product-{{$product->id}}/{{$product->name}}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
        <div class="uk-card radius">
            <div class="uk-card-media-top">
                <img class="radius-top" style="width:100%;height:200px; min-height:200px;" src="{{ $product->display_image ?? '/images/product/placeholder.png'}}" alt="">
            </div>
            <div style="max-height:80px;" class="uk-card-footer uk-hover">
            <p class="uk-text-truncate uk-padding-remove uk-margin-remove text-dark"><small>{{$product->name}}</small></p>
            <span class="price uk-padding-remove uk-margin-remove text-muted">
                <span class="amount"><span class="currencySymbol">{{$currency}}</span>{{$product->priceWithCommission()}}</span>
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
