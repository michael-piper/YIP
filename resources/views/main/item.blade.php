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
            <div class="additional-img" uk-lightbox>

              <a href="{{url($product->display_image??'/images/products/placeholder.png')}}">
              <img src="{{url($product->display_image??'/images/products/placeholder.png')}}">
              </a>
              @foreach($product->images() as $other_image)
              @php($img=$other_image->filename??'/images/products/placeholder.png')
               <a href="{{url($img)}}">
                <img src="{{url($img)}}">
              </a>
              @endforeach
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
                        <span class="price-new-dollar">{{$currency}}{{$product->priceWithCommission()}}</span>
                        <span class="price-new-cent"></span>
                    </div>
                    <div class="price-old clearfix">
                      <span class="price-old-dollar">{{$currency}}{{$product->priceWithCommission(false)}}</span>
                      <span class="price-old-cent"></span>
                    </div>
                  @else
                    <div class="price-new clearfix">
                        <span class="price-new-dollar">{{$currency}}{{$product->price}}</span>
                        <span class="price-new-cent"></span>
                    </div>
                  @endif

              </div>
              <!--rating-->
              <div class="block-rating clearfix">
                <!--review-->
                <span class="review">40 Reviews</span>
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
@else

porduct not found
@endif
