@php($user=Auth::user())
@php($currency=App\Product::currency())
@extends('layouts.main')

@section("title","")

@section('style')
<style>
  body {
	background: #eee;
	margin: 0;
	padding: 0;
	overflow-x: hidden;
}

.clearfix {
  content: "";
  display: table;
  clear: both;
}

#site-header, #site-footer {
	background: #fff;
}

#site-header {
	margin: 0 0 30px 0;
}

#site-header h1 {
	font-size: 31px;
	font-weight: 300;
	padding: 40px 0;
	position: relative;
	margin: 0;
}

a {
	color: #000;
	text-decoration: none;

	-webkit-transition: color .2s linear;
	-moz-transition: color .2s linear;
	-ms-transition: color .2s linear;
	-o-transition: color .2s linear;
	transition: color .2s linear;
}

a:hover {
	color: #53b5aa;
}

#site-header h1 span {
	color: #53b5aa;
}

#site-header h1 span.last-span {
	background: #fff;
	padding-right: 150px;
	position: absolute;
	left: 217px;

	-webkit-transition: all .2s linear;
	-moz-transition: all .2s linear;
	-ms-transition: all .2s linear;
	-o-transition: all .2s linear;
	transition: all .2s linear;
}

#site-header h1:hover span.last-span, #site-header h1 span.is-open {
	left: 363px;
}

#site-header h1 em {
	font-size: 16px;
	font-style: normal;
	vertical-align: middle;
}

.container {
	font-family: 'Open Sans', sans-serif;
	margin: 0 auto;
	width: 980px;
}
#site-header a.continue:link, #site-header a.continue:visited {
  text-decoration: none;
  font-family: "Montserrat", sans-serif;
  letter-spacing: -.015em;
  font-size: .75em;
  padding: 1em;
  color: #fff;
  background: #82ca9c;
  font-weight: bold;
  border-radius: 50px;
  float: right;
  text-align: right;
  font-size:12px;
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  -ms-transition: all 0.25s linear;
  -o-transition: all 0.25s linear;
  transition: all 0.25s linear;
}
#site-header a.continue:after {
  content: "\276f";
  padding: .5em;
  position: relative;
  right: 0;
  -webkit-transition: all 0.15s linear;
  -moz-transition: all 0.15s linear;
  -ms-transition: all 0.15s linear;
  -o-transition: all 0.15s linear;
  transition: all 0.15s linear;
}
#site-header a.continue:hover, #site-header a.continue:focus, #site-header a.continue:active {
  background: #f69679;
}
#site-header a.continue:hover:after, #site-header a.continue:focus:after, #site-header a.continue:active:after {
  right: -10px;
}
#cart {
	width: 100%;
}

#cart h1 {
	font-weight: 300;
}

#cart a {
	color: #53b5aa;
	text-decoration: none;

	-webkit-transition: color .2s linear;
	-moz-transition: color .2s linear;
	-ms-transition: color .2s linear;
	-o-transition: color .2s linear;
	transition: color .2s linear;
}

#cart a:hover {
	color: #000;
}

.product.removed {
	margin-left: 980px !important;
	opacity: 0;
}

.product {
	border: 1px solid #eee;
	margin: 20px 0;
	width: 100%;
	height: 195px;
	position: relative;

	-webkit-transition: margin .2s linear, opacity .2s linear;
	-moz-transition: margin .2s linear, opacity .2s linear;
	-ms-transition: margin .2s linear, opacity .2s linear;
	-o-transition: margin .2s linear, opacity .2s linear;
	transition: margin .2s linear, opacity .2s linear;
}

.product img {
	width: 100%;
	height: 100%;
}

.product header, .product .content {
	background-color: #fff;
	border: 1px solid #ccc;
	border-style: none none solid none;
	float: left;
}

.product header {
	background: #000;
	margin: 0 1% 20px 0;
	overflow: hidden;
	padding: 0;
	position: relative;
	width: 24%;
	height: 195px;
}

.product header:hover img {
	opacity: .7;
}

.product header:hover h3 {
	bottom: 73px;
}

.product header h3 {
	background: #53b5aa;
	color: #fff;
	font-size: 22px;
	font-weight: 300;
	line-height: 49px;
	margin: 0;
	padding: 0 30px;
	position: absolute;
	bottom: -50px;
	right: 0;
	left: 0;

	-webkit-transition: bottom .2s linear;
	-moz-transition: bottom .2s linear;
	-ms-transition: bottom .2s linear;
	-o-transition: bottom .2s linear;
	transition: bottom .2s linear;
}

.remove {
	cursor: pointer;
}

.product .content {
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 140px;
	padding: 0 20px;
	width: 75%;
}

.product h1 {
	color: #53b5aa;
	font-size: 25px;
	font-weight: 300;
	margin: 17px 0 20px 0;
}

.product footer.content {
	height: 50px;
	margin: 6px 0 0 0;
	padding: 0;
}

.product footer .price {
	background: #fcfcfc;
	color: #000;
	float: right;
	font-size: 15px;
	font-weight: 300;
	line-height: 49px;
	margin: 0;
	padding: 0 30px;
}

.product footer .full-price {
	background: #53b5aa;
	color: #fff;
	float: right;
	font-size: 22px;
	font-weight: 300;
	line-height: 49px;
	margin: 0;
	padding: 0 30px;

	-webkit-transition: margin .15s linear;
	-moz-transition: margin .15s linear;
	-ms-transition: margin .15s linear;
	-o-transition: margin .15s linear;
	transition: margin .15s linear;
}
.payment-status,.order-status{
    font-size: 19px;
	line-height: 50px;
	width: inherit;
    min-width:60px;
    max-width:130px;
	text-align: left;
}
.payment-status{
display: block;
	float: left;
}
.order-status{
display: block;
	float: left;
}
.qt, .qt-plus, .qt-minus {
	display: block;
	float: left;
}

.qt {
	font-size: 19px;
	line-height: 50px;
	width: 70px;
	text-align: center;
}

.qt-plus, .qt-minus {
	background: #fcfcfc;
	border: none;
	font-size: 30px;
	font-weight: 300;
	height: 100%;
	padding: 0 20px;
	-webkit-transition: background .2s linear;
	-moz-transition: background .2s linear;
	-ms-transition: background .2s linear;
	-o-transition: background .2s linear;
	transition: background .2s linear;
}

.qt-plus:hover, .qt-minus:hover {
	background: #53b5aa;
	color: #fff;
	cursor: pointer;
}

.qt-plus {
	line-height: 50px;
}

.qt-minus {
	line-height: 47px;
}

#site-footer {
	margin: 30px 0 0 0;
}

#site-footer {
	padding: 40px;
}

#site-footer h1 {
	background: #fcfcfc;
	border: 1px solid #ccc;
	border-style: none none solid none;
	font-size: 24px;
	font-weight: 300;
	margin: 0 0 7px 0;
	padding: 14px 40px;
	text-align: center;
}

#site-footer h2 {
	font-size: 24px;
	font-weight: 300;
	margin: 10px 0 0 0;
}

#site-footer h3 {
	font-size: 19px;
	font-weight: 300;
	margin: 15px 0;
}

.left {
	float: left;
}

.right {
	float: right;
}

.btn-order {
	background: #53b5aa;
	border: 1px solid #999;
	border-style: none none solid none;
	cursor: pointer;
	display: block;
	color: #fff;
	font-size: 20px;
	font-weight: 300;
	padding: 16px 0;
	width: 290px;
	text-align: center;

	-webkit-transition: all .2s linear;
	-moz-transition: all .2s linear;
	-ms-transition: all .2s linear;
	-o-transition: all .2s linear;
	transition: all .2s linear;
}

.btn-order:hover {
	color: #fff;
	background: #429188;
}

.type {
	background: #fcfcfc;
	font-size: 13px;
	padding: 10px 16px;
	left: 100%;
}

.type, .color {
	border: 1px solid #ccc;
	border-style: none none solid none;
	position: absolute;
}

.color {
	width: 40px;
	height: 40px;
	right: -40px;
}

.red {
	background: #cb5a5e;
}

.yellow {
	background: #f1c40f;
}

.blue {
	background: #3598dc;
}

.minused {
	margin: 0 50px 0 0 !important;
}

.added {
	margin: 0 -50px 0 0 !important;
}
.text-white{
    color:#fff !important;
}
.text-black{
    color:#000;
}
    .pagination {
        margin-top: .5rem;
        margin-bottom: .5rem;
    }
    .pagination {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: .25rem;
    }
    dl, ol, ul {
        margin-top: 0;
        margin-bottom: 1rem;
    }
        .page-item:first-child .page-link {
        margin-left: 0;
        border-top-left-radius: .25rem;
        border-bottom-left-radius: .25rem;
    }

    .page-link:not(:disabled):not(.disabled) {
        cursor: pointer;
    }
    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('content')

<header id="site-header">
<div class="container">

@if($user)
@php($orders=App\Order::where(['user_id'=>$user->id])->orderBy('updated_at','DESC')->paginate(6))
<h1>Shopping Orders <span>[</span> <em><a href="" target="_blank">{{$orders->total()}} </a></em> <span class="last-span is-open">]</span>

@else
@php($orders=[])
<h1>Shopping Orders <span>[</span> <em><a href="" target="_blank">{{count($orders)}} </a></em> <span class="last-span is-open">]</span>

@endif
 <a href="/shop" class="continue">Continue Shopping</a>


  </h1>

</div>
</header>
<div class="container">
<section id="cart">
@empty($orders)
<h1>No products Ordered!</h1>
@endempty


@foreach($orders as $order)
@php($product=App\Product::where(['id'=>$order->product_id])->first())
@php($order_status=App\OrderStatus::where(['id'=>$order->order_status])->first())
@php($payment_status=App\PaymentStatus::where(['id'=>$order->payment_status])->first())
<article class="product" cart-id="{{$order->id}}">
<header>
<a   href="/shop/product-{{$product->id}}/{{$product->name}}"class="remove">
<img src="{{$product->display_image}}" alt="">
<h3>view Product</h3>
</a>
</header>
<div class="content">
<h1 class="uk-h3 uk-margin-remove">{{$product->name}}</h1>
@if($order->payment_status == 0)
<div style="top:35px;margin-left:-15px;width:auto;" class="type small red">
    <a href="JavaScript:retryPayment('{{$order->id}}');" class="text-white">Retry Payment</a>
</div>
@elseif($order->payment_status == 1)
<div style="top:35px;margin-left:-15px;width:auto;" class="type small yellow">
    <a href="JavaScript:verifyPayment('{{$order->tracking_id}}','{{$order->id}}');" class="text-white">Confirm Payment</a>
</div>
@endif
<table class="uk-table uk-margin-remove uk-table-small uk-table-striped">
<thead>
<tr>
<th>ORDERID</th>
<th>TRACKINGID</th>
<th>ORDER</th>
<th>PAYMENT</th>
</tr>
</thead>
<tbody>
<tr>

<td>order-{{$order->id}}</td>
<td>{{$order->tracking_id}}</td>
<td>{{$order_status->name ?? 'Awaiting'}}</td>
<td>{{$payment_status->name ??'Not Paid'}}</td>

</tr>
</tbody>
</table>
<p>
</div>
<footer class="content">

<span class="qt">qt:{{$order->quantity}}</span>
<span class="order-status">Shipping fee:</span>
<span class="payment-status">{{$currency}}{{$order->shipping_fee }}</span>
<h2 class="full-price">
{{$currency}}{{$order->total_price+ $order->shipping_fee}}
<h2 class="price">
{{$currency}}{{$order->price}}
</h2>
</footer>
</article>
@endforeach

</section>
@auth
<section class="uk-padding uk-margin-top">
    <span class="uk-float-left">
        page {{$orders->currentPage()?? 0}} of {{$orders->lastPage()?? 0}}
    </span>
        <span class="uk-float-right">{{$orders->links()}}<span>
</section>
@endauth
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.6/loadingoverlay.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-Csrf-Token': $('meta[name="csrf-token"]').attr('content')||""
    }
});
function retryPayment($id){
    $.LoadingOverlay("show");
    $.post('/cart/checkout?from=ajax',{id:$id}).done(function($response){
        $.LoadingOverlay("hide");
		if($response.data){
            shipping=$response.data.shipping;
			shipping.tracking_id=$response.data.tracking_id;
			shipping.total_price=$response.data.total_price;
			payWithPaystack(shipping);
		}
	}).fail(function(){
        $.LoadingOverlay("hide");
    });
}
function verifyPayment(reference,$id){
    $.LoadingOverlay("show");
    $.get('/verify-payment?from=ajax&reference='+reference).done(function($response){
        $.LoadingOverlay("hide");
        if($response.error){
            retryPayment($id);
            return console.log($response);
        }
        window.location.reload();

    }).fail(function(){
        $.LoadingOverlay("hide");
    });
}
</script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
  function shippingMetadata(shipping){
      var data=[];
      for(var n in shipping){
          var display_name=n.replace(/[\_]/gi,' ');
          var variable_name=n.replace(/[\s\.\-\+\=\!\*\&\%\$\#\@\~\`]/gi,'_').toLowerCase();
          data.push({ display_name: display_name, variable_name: variable_name, value: shipping[n] });
      }
      return data;
  }
      function payWithPaystack(shipping){
          var handler = PaystackPop.setup({
              key: "pk_test_907a3707c9dd8db6c4ee95572a363aa501e7f1f6",
              email: "{{ $user->email ?? 'Unidentified user' }}",
              amount: shipping.total_price +"00",
              ref: shipping.tracking_id,
              currency: "NGN",
              metadata: {
                  custom_fields:  shippingMetadata(shipping)
              },
              callback: function(response){
                  $.alert('Payment was successfull. transaction ref is ' + response.reference);
                  $.get('/verify-payment?from=ajax&reference='+response.reference).done(function($response){
                      if($response.error){
                          return console.log($response);
                      }
                      window.location.reload();
                  });
              },
              onClose: function(){

                  $.get('/verify-payment?from=ajax&reference='+shipping.tracking_id).done(function($response){
                      if($response.error){
                        return console.log($response);
                        $.alert($response.message);
                      }
                      window.location.reload();
                  });
              }
          });
          handler.openIframe();
      }
  </script>
@endsection
