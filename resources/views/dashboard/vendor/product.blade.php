@extends('layouts.dashboard_vendor')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
                <section>
                        <div class="pop-up clearfix row">
                          <!--GALLERY-->
                          <div class="pics col-6 col-sm-6">
                            <span class="main-img">
                            <img class="product-image" style="max-height:500px;" src="{{url($product->display_image??'/images/products/placeholder.png')}}"></span>
                            <div class="additional-img">
                                <a href="{{url($product->display_image??'/images/products/placeholder.png')}}">
                                    <img src="{{url($product->display_image??'/images/products/placeholder.png')}}">
                                </a>
                                @foreach($product->images() as $other_image)
                                @php($img=url($other_image->filename??'/images/products/placeholder.png'))
                            <a href="JavaScript:removeProductImage({{$product->id}},{{$other_image->id}},'{{$img}}');">
                                    <img src="{{$img}}">
                                </a>
                                @endforeach
                                <a href="JavaScript:addProductImage({{$product->id}});">
                                    <img src="/images/products/placeholder.png">
                                </a>
                            </div>
                          </div>
                          <!-- PRODUCT INFORMATION -->
                          <div class="product-item col-6 col-sm-6">
                            <!--category-breadcrumb-->
                          @php($category=App\ProductCategory::where("id",$product->category_id)->first())
                          <span class="category">{{$category->name??'None'}}</span>
                            @if($product->available>$product->sold)
                                <!--stock-label-->
                                <span class="stock mx-1">{{$product->available-$product->sold}} In Stock </span>
                                <!--stock-label-->
                                <span class="stock mx-1">Sold {{$product->sold}} Items</span>
                            @else
                                <!--stock-label-->
                                <span class="stock">No Item in Stock please add</span>
                            @endif
                            <h1>{{$product->name}}</h1>
                            <!--PRICE-RATING-REVIEW-->
                            <div class="block-price-rating clearfix">
                              <!--price-->
                              <div class="block-price clearfix">
                                    @if(isset($addons->discount) && is_int($addons->discount) && $addons->discount>0)
                                    <div class="price-new clearfix">
                                        <span class="price-new-dollar">{{$currency}}{{$product->price-$addons->discount}}</span>
                                        <span class="price-new-cent"></span>
                                    </div>
                                    <div class="price-old clearfix">
                                      <span class="price-old-dollar">{{$currency}}{{$product->price}}</span>
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
                              <span class="rating">{!!App\Product::rating($product->id)!!}</span>
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
                            <p>{{$product->description}}</p>
                           </div>
                            <!--SELECT BLOCK-->
                           <div class="block-select clearfix">
                            <form>
                                <input type="hidden" name="action" value="add_quantity">
                              <div class="select-size">
                                <span>Quantity</span>
                                <select name="quantity" class="size" required="required">
                                    <option value="">choose quantity</option>
                                @for($i=1;$i < 101;$i++)
                                    <option>{{$i}}</option>
                                @endfor
                                </select>
                              </div>
                              <!--BUTTON-->
                              <button class="btn-product"><img src="">Add Item To Product</button>
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
                        <div class="row m-3">
                            <div class="col-12 col-md-6 mx-auto">
                                <h4 class="text-md-right bg-green p-1">list of product added Items</h4>
                                <table id="product_available" class="table table-stripe">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Quantity</th>
                                        <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($availables=App\ProductAvailable::where('product_id',$product->id)->get())
                                        @forelse($availables as $avail)
                                        <tr>
                                            <td>{{$avail->id}}</td>
                                            <td>{{$avail->quantity}}</td>
                                            <td>{{$avail->created_at}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"> no Quantity Added</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <h4 class="bg-yellow p-1"><span class="text-white">list of product sold Items</span></h4>
                                    <table id="product_sold" class="table table-stripe">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($solds=App\ProductSold::where('product_id',$product->id)->get())
                                            @forelse($solds as $sold)
                                            <tr>
                                                <td>{{$sold->id}}</td>
                                                <td>{{$sold->quantity}}</td>
                                                <td>{{$sold->created_at}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3"> not sold any Item</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </section>
          </div>
        </div>
   </div>
@endsection
@section('js')
<script>
    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    window.Toast=Toast;
    });
</script>
<script>
    $('#product_available').DataTable();
    $('#product_sold').DataTable();
</script>
<script>
    function addProductImage(id){
        var action=function(data){
            $.ajax({
                method: "POST",
                url:API_URL+'v1/product/'+id+'/images',
                data : data,
                processData: false,
                contentType: false
            })
            .done(function( res ) {
                if(res.error){
                    Toast.fire({
                        type: 'error',
                        title: res.message
                    })
                }else{
                    Toast.fire({
                        type: 'success',
                        title: res.message
                    })
                    window.location.reload();
                }
            }).fail(function(res){
                Toast.fire({
                        type: 'error',
                        title: "Something went wrong"
                })
            });
        }
        $.confirm({
            title: 'Add Product Image!',
            content: '' +
            '<img src="" style="display:none" class="product_image img-preview">'+
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Choose Image</label>' +
            '<input type="file" onchange="readURL(this);" name="image" class="image form-control" required>' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var meta = new FormData(this.$content.find('form')[0]);
                        action(meta);
                    }
                },
                cancel: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
     function removeProductImage(product_id, id, filename){
        var action=function(){
            $.ajax({
                method: "DELETE",
                url:API_URL+'v1/product/'+product_id+'/images/'+id
            })
            .done(function( res ) {
                if(res.error){
                    Toast.fire({
                        type: 'error',
                        title: res.message
                    })
                }else{
                    Toast.fire({
                        type: 'success',
                        title: res.message
                    })
                    window.location.reload();
                }
            }).fail(function(res){

            });
        }
        $.confirm({
            title: 'Warning!',
            content:  'Are you sure you want to remove product image'+
            '<img src="'+filename+'" width="100%">'
           ,
            type:'orange',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action:action
                },
                cancel: function () {
                    //close
                }
            }
        });

    }
    function readURL(input) {
    $('.img-preview').attr('style',"display:none;");
    $('.img-preview-label').attr('style',"display:none;");
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      const name=input.files[0].name;
      const pixext=['png','jpeg','jpg','gif'];
      const vidext=['mkv','mp4','flv','webm','ogg'];
      const extension= name.substring(name.lastIndexOf('.')+1);
      // console.log(input.files[0],"name="+name,"extension="+extension);
      reader.onload = function (e) {
        $('.img-preview')
            .attr('src', e.target.result)
            .width(150)
            .attr('style',"display:initial;")
            .height(200);
      };

      if(pixext.find(function(e){return e===extension.toLowerCase()})){
        reader.readAsDataURL(input.files[0]);
      }

      else{

        $('.img-preview-label')
          .attr('style',"display:initial;color:red;")
          .text("File format not supported");
        $('.img-preview')
          .attr('style',"display:none;")
      }

    }else{
        $('.img-preview-label')
            .attr('style',"display:initial;")
            .text("Choose a file");
        $('.img-preview')
            .attr('style',"display:none;")
    }
  }
</script>
@endsection
@section('style')
<style>
.clearfix {
  content:"";
  display: table;
}
/* .shop-bg {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
  background: #222;
  opacity: .8;
} */
.pop-up {
  width: 900px;
  height: auto;
  margin-left: auto;
  margin-right: auto;
  margin-top: 80px;
  position: relative;
  background: #fff;
  padding: 30px;
  border-radius: 2px;
}
/*GALLERY*/
.pics {
  float: left;
  width: 460px;
  margin-right: 0px;
}
.pics span {
  display: block;
}
.main-img img{
  display: block;
  border: .5px solid #ddd;
  border-radius: 2px;
  padding: 60px 30px;
  width: 390px;
  margin-bottom: 10px;
  cursor: pointer;
}
.additional-img img {
  float: left; /*display: inline-block has  automatic margin right and bottom :( */
  width: 90px;
  height: 90px;
  padding: 10px 5px;
  border: .5px solid #ddd;
  border-radius: 2px;
  margin-right: 5px;
  cursor: pointer;
}
.additional-img img:nth-child(4) {
  margin-right: 0;
}
.main-img img:hover,
.additional-img img:hover {
  box-shadow: 0 0 6px #ddd;
}
/*PRODUCT INFORMATION*/
.product-item {
  float: right;
  width: 430px;
}
span.category {
  display: block;
  font-weight: 700;
  color: #888;
  font-size: 12px;
  line-height: 14px;
  font-style: italic;
}
.product-item .category:hover {
  color: #999;
  cursor: pointer;
}
.product-item h1 {
  width: 300px;
  font-size: 21px;
  line-height: 24px;
  margin-top: 5px;
  color: #333;
  text-transform: uppercase;
  letter-spacing: .3px;
}
/*STOCK LABEL*/
span.stock {
  display: block;
  float: right;
  position: relative;
  top: 4px;
  line-height: 11px;
  padding: 6px 12px 5px 12px;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
  color: #fff;
  background: #18d11f;
  border-radius: 14px;
  letter-spacing: .3px;
}
/*PRICE & RATING*/
.block-price-rating {
  width: 100%;
  margin-top: 10px;
}
.block-price {
  float: left;
  width: auto;
  margin-right: 20px;
}
.price-new {
  float: left;
  font-weight: bold;
  margin-right: 10px;
}
.price-new-dollar {
  float: left;
  display: block;
  font-size: 24px;
  margin-right: 5px;
  color: #333;
}
.price-new-cent {
  font-size: 14px;
}
.price-old {
  text-decoration: line-through;
  color: #444;
  font-size: 14px;
  position: relative;
  top: 6px;
}
/*rating*/
.block-rating {
  float: right;
  position: relative;
  top: 2px;
}
span.rating img {
  display: block;
  float: left;
  width: 110px;
  margin-left: 10px;
}
span.rating img:hover {
  cursor: pointer;
}
/*review*/
span.review {
  display: block;
  float: left;
  position: relative;
  top: 6px;
  font-weight: 700;
  color: #888;
  font-size: 12px;
  font-style: italic;
}
span.review:hover {
  color: #999;
  cursor: pointer;
}
/*PRODUCT DESCRIPTION*/
.descr {
  font-size: 14px;
  line-height: 18px;
  color: #444;
  letter-spacing: .3px;
  margin-top: 10px;
  width: 430px;
  height: 71px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: no-wrap;
}
/*SELECT BLOCK*/
.block-select {
  margin-top: 15px;
}
.select-color,
.select-size {
  float: left;
  font-size: 14px;
  font-weight: 700;
  color: #888;
}
.select-color span,
.select-size span {
  display: block;
  margin-bottom: 5px;
}
select.color {
  width: 320px;
  margin-right: 10px;
}
select.size {
  width: 100px;
}
select.color, select.size {
  padding: 8px 10px;
  border: .5px solid #ddd;
  border-radius: 2px;
  text-transform: uppercase;
  font-weight: 700;
  opacity: .7;
  letter-spacing: .3px;
}
/*BUTTON*/
.btn-product {
  margin: 10px auto;
  text-align: center;
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  letter-spacing: .3px;
  text-transform: uppercase;
  padding: 15px 0;
  width: 100%;
  border-radius: 2px;
  cursor: pointer;
  background: #fd7064;
}
.btn-product:hover {
  background: #fc796f;
}
/*LINKS*/
.block-footer {
  width: 100%;
  margin-top: 10px;
}
.block-links {
  float: left;
  cursor: pointer;
}
.block-links img {
  width: 20px;
  opacity: .3;
  vertical-align: middle;
  margin-right: 5px;
}
.block-links span {
  font-size: 11px;
  color: #888;
  font-weight: 700;
  letter-spacing: .3px;
  text-transform: uppercase;
  font-style: italic;
}
.block-links span:hover {
  color: #999;
}
.wishlist {
  margin-top: 5px;
}
/*SOCIAL*/
.social {
  float: right;
  position: relative;
  top: 5px;
}
.social img {
  width: 36px;
  opacity: .3;
  cursor: pointer;
  margin-right: 3px;
  display: inline;
}
.social img:nth-child(4) {
  margin-right: 0;
}
.social img:hover {
  opacity: .2;
}

   ul.products li.product a img {
    width: 100%;
    height: auto;
    display: block;
    margin: 0 0 1em;
    box-shadow: none;
}
    .fa-star.empty{
        color:white;
        text-shadow: 1px 1px 1px #000000;
    }
    .fa-star.fill{
        color:gold;
        text-shadow: 1px 1px 1px #000000;
    }
    .uk-cart-button {
    font-size: 13px;
    margin: 0;
    left: auto;
    cursor: pointer;
    position: relative;
    overflow: visible;
    text-decoration: none;
    white-space: nowrap;
    display: inline-block;
    border: none;
    box-sizing: border-box;
    padding: 0 25px;
    line-height: 40px!important;
    background-color: #fff;
    color: #5b5b5b;
    transition: .1s ease-in-out;
    /* transition-property: color,background-color,background-position,border-color,box-shadow; */
    font-family: Roboto;
    font-weight: 400;
    text-transform: uppercase;
    border-radius: 2px;
    background-origin: border-box;
    box-shadow: 0 3px 12px rgba(0,0,0,.07);
}
.uk-cart-button.soldout{
    color:#fff;
    background: #cf3334;
}
.product-title{
    padding: .5em 0 0 0;
    margin: 20px 0 0 0;
    font-size: 1em;
    line-height: 1.4em;
}
.product{
    float: left;
    margin: 0 3.8% 2.992em 0;
    padding: 0;
    position: relative;
    margin-left: 0;
    }

.star-rating{
    display: block;
    float: none;
    margin: .5em auto .5em;
}
.onsale{
    right: auto;
    left: 6px;
}
span.onsale{
    min-height: 32px;
    min-width: 32px;
    padding: 4px;
    position: absolute;
    text-align: center;
    line-height: 32px;
    margin: 0;
    z-index: 5;
    top: 0;
    left: 0;
    -webkit-border-radius: 500px;
    border-radius: 500px;
    color: #fff;
    background: #00a0de;
    font-size: 13px;
    font-weight: 400;
    margin: -16px;
}
.soldout{
    right: auto;
    left: 6px;
}
span.soldout{
    min-height: 32px;
    min-width: 32px;
    padding: 4px;
    position: absolute;
    text-align: center;
    line-height: 32px;
    margin: 0;
    z-index: 5;
    top: 0;
    left: 0;
    -webkit-border-radius: 500px;
    border-radius: 500px;
    color:#fff;
    background: #cf4444;
    font-size: 13px;
    font-weight: 400;
    margin: -16px;
}

</style>
@endsection
