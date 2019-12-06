@php($currency=App\Product::currency())
@php($products=App\Product::query())
@isset($_GET['q'])
 @if(strlen($_GET['q'])>4)
  @php($where=[])
  @php($where[]=['active','=',1])
  @php($where[]=['name','LIKE',"%{$_GET['q']}%"])
  @php($products=$products->where($where))
 @endif
 @php($array=explode(' ',$_GET['q']))
 @if(count($array)>5)
  @foreach($array as $q)
    @if(strlen($q)>4)
     @php($where=[])
     @php($where[]=['active','=',1])
     @php($where[]=['name','LIKE',"%$q%"])
     @php($products=$products->orWhere($where))
    @endif
  @endforeach
 @endif
@endisset
@if(isset($_GET['category']) && $_GET['category']!='')
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['category_id','=',$_GET['category']])
 @php($products=$products->where($where))
@endif
@if(isset($_GET['subcategory']) && $_GET['subcategory']!='')
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['sub_category_id','=',$_GET['subcategory']])
 @php($products=$products->where($where))
@endif
@if(isset($_GET['make']) && $_GET['make']!='')
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['make','=',$_GET['make']])
 @php($products=$products->where($where))
@endif
@if(isset($_GET['model']) && $_GET['model']!='')
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['model','=',$_GET['model']])
 @php($products=$products->where($where))
@endif
@if(isset($_GET['year']))
 @php($where=[])
 @php($where[]=['active','=',1])
 @php($where[]=['year','LIKE','%'.$_GET['year'].'%'])
 @php($products=$products->where($where))
@endif
@php($products=$products->paginate(16))
<section class="uk-text-center uk-padding-small">
        <div class="uk-grid-small uk-child-width-1-5@s uk-text-center" uk-grid>
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
                            <img class="product-image" width="300" height="300" src="{{ url($product->display_image ??'/images/product/placeholder.jpg')}}" sizes="(max-width: 300px) 100vw, 300px">
                            <h2 class="product-title">{{$product->name}}</h2>
                            <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                {!!App\Product::rating($product->id)!!}
                            </div>
                            <span class="price">
                                <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{$currency}}</span>{{number_format($product->priceWithCommission(),'2','.',',')}}</span>
                            </span>
                        </a><br/>
                        <a href="/add_to_cart/{{$product->id}}" data-quantity="1" class="uk-cart-button product_type_variable add_to_cart_button" aria-label="Select options for “YOO Halftone”" rel="nofollow">Add to cart</a>
                        </li>
                </div>
                @empty
                </div>
                     No items valid to your search
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

