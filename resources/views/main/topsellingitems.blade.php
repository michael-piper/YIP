@php($currency=App\Product::currency())
<section class="uk-text-left uk-padding-small" >
 <div class="uk-card radius-large uk-card-default uk-width-1-1@m" >
    <div class="uk-card-body uk-padding-remove">
        <div class="uk-grid-small uk-flex-middle uk-padding-small" uk-grid>
                <h4 class="uk-margin-remove-bottom">Top selling items</h4>
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

    {{-- <div>
                @if($product->available == $product->sold)
                <span class="soldout">Sold!</span>
                @elseif($product->available > $product->sold+5)
                <span class="onsale">Sale!</span>
                @else
                <span class="onsale yellow">Sale!</span>
                @endif
                <a href="/shop/product-{{$product->id}}/{{$product->name}}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <img class="product-image" width="300" height="300" src="{{ $product->display_image ?? '/images/product/placeholder.jpg'}}" sizes="(max-width: 300px) 100vw, 300px">
                <h2 class="product-title">{{$product->name}}</h2>
                <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                    {!!App\Product::rating($product->id)!!}
                </div>
                <span class="price">
                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$currency}}</span>{{$product->price}}</span>
                </span>
            </a><br/>
            <a href="/add_to_cart/{{$product->id}}" data-quantity="1" class="uk-cart-button product_type_variable add_to_cart_button" aria-label="Select options for “YOO Halftone”" rel="nofollow">Add to cart</a>
            </div> --}}
