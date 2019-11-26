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
	width: 70px;
    max-width:100px;
	text-align: center;
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

.btn {
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

.btn:hover {
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
</style>
@endsection

@section('js')

@endsection

@section('content')

@if($user)
@php($user_cart=App\Cart::where(['user_id'=>$user->id])->select('id')->get())
@php($cart=[])
@foreach($user_cart as $cart_data)
@php($cart[]=$cart_data->id)
@endforeach
@else
@php($cart=session('cart')??[])
@endif
<header id="site-header">
<div class="container">
<h1>Shopping Orders <span>[</span> <em><a href="" target="_blank">{{count($cart)}} </a></em> <span class="last-span is-open">]</span>
 <a href="/shop" class="continue">Continue Shopping</a>


  </h1>
 
</div>
</header>
<div class="container">
<section id="cart">
@empty($cart)
<h1>No products Ordered!</h1>
@endempty


@foreach($cart as $cart_id)
@php($bag=App\Cart::where(['id'=>$cart_id])->first())
@php($product=App\Product::where(['id'=>$bag->product_id])->first())
<article class="product" cart-id="{{$cart_id}}">
<header>
<a class="remove">
<img src="{{$product->display_image}}" alt="">
<h3>view Product</h3>
</a>
</header>
<div class="content">
<h1 class="uk-h3 uk-margin-remove">{{$product->name}}</h1>
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

<td>220321232-232-323</td>
<td>trk-220321232-232-323</td>
<td>Awaiting</td>
<td>Paid</td>

</tr>
</tbody>
</table>
<p>
</div>
<footer class="content">
<span class="qt">qt:{{$bag->quantity}}</span>
<span class="payment-status">Payment:</span>
<span class="order-status">Paid</span>
<h2 class="full-price">
{{$currency}}{{($product->price - $product->addons()->discount) * $bag->quantity}}
<h2 class="price">
{{$currency}}{{$product->price - $product->addons()->discount}}
</h2>
</footer>
</article>
@endforeach
</section>
</div>
@endsection
