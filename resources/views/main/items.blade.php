@php($currency=App\Product::currency())

@isset($_GET['q'])
@php($products=App\Product::where(['active'=>1,['name','LIKE','%'.$_GET['q'].'%']]))
@php($array=explode(' ',$_GET['q']))
 @foreach($array as $q)
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['name','=',$q])
 @php($products=$products->orWhere($where))
 @endforeach
@else
@php($products=App\Product::where(['active'=>1]))
@endisset
@php($products=$products->paginate(16))
<section class="uk-text-center uk-padding-small">
        <div class="uk-grid-small uk-child-width-1-4@s uk-text-center" uk-grid>
                @forelse($products as $product)
                <div>
                        <li class="product">
                            @if($product->available == $product->sold)
                            <span class="soldout">Sold!</span>
                            @elseif($product->available > $product->sold+5)
                            <span class="onsale">Sale!</span>
                            @else
                            <span class="onsale yellow">Sale!</span>
                            @endif
                            <a href="/shop/product-{{$product->id}}/{{$product->name}}" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                            <img class="product-image" width="300" height="300" src="{{ $product->display_image ??'/images/product/placeholder.jpg'}}" sizes="(max-width: 300px) 100vw, 300px">
                            <h2 class="product-title">{{$product->name}}</h2>
                            <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                {!!App\Product::rating($product->id)!!}
                            </div>
                            <span class="price">
                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$currency}}</span>{{$product->priceWithCommission()}}</span>
                            </span>
                        </a><br/>
                        <a href="/add_to_cart/{{$product->id}}" data-quantity="1" class="uk-cart-button product_type_variable add_to_cart_button" aria-label="Select options for “YOO Halftone”" rel="nofollow">Add to cart</a>
                        </li>
                </div>
                @empty
                </div>
                     no items valid to your search
                </div>
                @endforelse
        </div>
        <section class="uk-padding uk-margin-top">
            <span class="uk-float-left">
                page {{$products->currentPage()?? 0}} of {{$products->lastPage()?? 0}}
            </span>
                <span class="uk-float-right">{{$products->links()}}<span>
        </section>
</section>

