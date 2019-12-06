@php($currency=App\Product::currency())
@php($product=App\Product::where(['active'=>1,'id'=>$product_id])->first())
@isset($product)
@php($addons=$product->addons())
<section>
<div class="uk-text-center uk-grid-small" uk-grid>

  <div class="uk-width-1-1@m">

  <div class="uk-margin-left uk-margin-right uk-card-default uk-card-body radius-small uk-margin-top">
     <!--GALLERY-->
          <div class="pics">
          <span class="main-img">
            <img class="product-image" style="max-height:500px;" src="{{url($product->display_image??'/images/products/placeholder.png')}}"></span>
            <div class="uk-position-relative uk-visible-toggle uk-light additional-img" tabindex="-1" uk-slider>

                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                    <li>

                        <a href="{{url($product->display_image??'/images/products/placeholder.png')}}">
                        <img src="{{url($product->display_image??'/images/products/placeholder.png')}}">
                        </a>
                    </li>
                    @foreach($product->images() as $other_image)
                    @php($img=$other_image->filename??'/images/products/placeholder.png')
                    <li  uk-lightbox>
                    <a href="{{url($img)}}">
                        <img src="{{url($img)}}">
                    </a>
                    </li>
                    @endforeach
                </ul>
                <a class="uk-position-center-left uk-overlay uk-overlay-primary uk-position-small uk-hidden-hover" style="color:red;" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-overlay uk-overlay-primary uk-position-small" style="color:red;" href="#" uk-slidenav-next uk-slider-item="next"></a>

            </div>
          </div>
          <!-- PRODUCT INFORMATION -->
          <div class="product-item">
            <!--category-breadcrumb-->
            @php($category=App\ProductCategory::where("id",$product->category_id)->first())
          <span class="category uk-text-left">{{$category->name??'None'}}</span>

            @if($product->available>$product->sold+5)
                <!--stock-label-->
                <span class="stock">In Stock</span>
            @elseif($product->available>$product->sold)
                <!--stock-label-->
                <span class="stock">{{$product->available - $product->sold}} Remain in Stock</span>
            @else
                <!--stock-label-->
                <span class="stock">Sold Out</span>
            @endif
            <h1 class="uk-text-left">{{$product->name}}</h1>
            <!--PRICE-RATING-REVIEW-->
            <div class="block-price-rating clearfix">
              <!--price-->
              <div class="block-price clearfix">
                    @if(isset($addons->discount) && is_int($addons->discount) && $addons->discount>0)
                    <div class="price-new clearfix">
                        <span class="price-new-dollar">{{$currency}}{{number_format($product->priceWithCommission(),'2','.',',')}}</span>
                        <span class="price-new-cent"></span>
                    </div>
                    <div class="price-old clearfix">
                      <span class="price-old-dollar">{{$currency}}{{number_format($product->priceWithCommission(false),'2','.',',')}}</span>
                      <span class="price-old-cent"></span>
                    </div>
                  @else
                    <div class="price-new clearfix">
                        <span class="price-new-dollar">{{$currency}}{{number_format($product->priceWithCommission(),'2','.',',')}}</span>
                        <span class="price-new-cent"></span>
                    </div>
                  @endif

              </div>
              <!--rating-->
              <div class="block-rating clearfix">
                <!--review-->
              <span class="review">@php($c_count=App\Comment::where(['product_id'=>$product->id])->count()) {{$c_count}} Review{{$c_count<=1?'':'s'}}</span>
              <span class="rating">{!!App\Product::rating($product_id)!!}</span>
              </div>
            </div>
            <!-- rating <ul class="rating">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul> -->
            <!--PRODUCT DESCRIPTION-->
            <div class="descr">
            <p class="uk-text-justify">{{$product->description}}</p>
           </div>
            <!--SELECT BLOCK-->
           <div class="block-select">
            <form>
              <div class="uk-grid-small uk-width-1-1" uk-grid>

                    <div class="uk-width-1-2">
                        <!--BUTTON-->
                        <a href="/add_to_cart/{{$product->id}}" class="btn-item uk-button" style="color:white;">Add to Cart</a>
                    </div>
                    <div class="uk-width-1-2">
                        <!--BUTTON-->
                        <button class="btn-item uk-button">Check Out</button>
                    </div>
                </div>
             </form>
            </div>
            <!--LINKS-->
           <div class="block-footer clearfix">
            <div class="block-links">
             <div class="send">
               <img src="http://www.free-icons-download.net/images/share-icon-20724.png">
               <span>Send to a friend</span>
              </div>
              <div class="wishlist">
                <img src="https://d30y9cdsu7xlg0.cloudfront.net/png/23243-200.png">
                <span>Save for later</span>
              </div>
            </div>
            <!--SOCIAL-->
            <div class="social">
                <a href="#"><img src="http://www.iconsdb.com/icons/download/black/facebook-7-256.gif"></a>
                <a href="#"><img src="http://www.iconsdb.com/icons/download/black/twitter-4-512.gif"></a>
                <a href="#"><img src="http://www.iconsdb.com/icons/download/black/google-plus-4-512.jpg"></a>
                <a href="#"><img src="http://www.nataliemorgan.co.nz/images/Pinterest.png"></a>
            </div>
            </div>
          </div>

 </div>
 </div>
 </div>
    </section>
    <div class="uk-margin-small-top">
        @includeIf("main.comments")
    </div>
@else

porduct not found
@endif
