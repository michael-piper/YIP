@php($currency=App\Product::currency())
<section class="uk-card radius-large uk-padding-remove uk-margin-right uk-card-default">
    <div class="uk-card-body uk-padding-remove">
        <div class="uk-grid-small uk-flex-middle uk-padding-small" uk-grid>
            <h4 class="uk-margin-remove-bottom">Deals of the Day</h4>
        </div>
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
    <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@m">
        @forelse(App\Product::dealsOfTheDay() as $product)
        <li class="uk-padding-small">
        <a href="/shop/product-{{$product->id}}/{{$product->name}}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
        <div class="uk-card radius">
            <div class="uk-card-media-top">
                <img class="radius-top" style="width:100%;height:200px; min-height:200px;" src="{{ $product->display_image ?? '/images/product/placeholder.png'}}" alt="">
            </div>
            <div style="max-height:80px;" class="">
                <p style="font-size:13px;height:40px;max-height:40px" class="uk-text-left uk-padding-remove uk-margin-remove text-dark">
                    {{Str::limit($product->name,32, ' ')}}
                </p>
                <span class="price uk-padding-remove uk-margin-remove text-muted">
                    <span class="amount"><small><span class="currencySymbol">{{$currency}}</span>{{number_format($product->priceWithCommission(),'2','.',',')}}</small></span>
                </span>
            </div>
        </div>
        </a>
        </li>
        @empty
        <li>
        </div>
            No frequent buy items
        </div>
        </li>
        @endforelse
     </ul>
    <a class="uk-position-center-left uk-position-small uk-hidden-hover" style="color:red" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" style="color:red" href="#" uk-slidenav-next uk-slider-item="next"></a>
</div>
   </div>
</section>
