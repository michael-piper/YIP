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
</style>
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
<h1>Shopping cart <span>[</span> <em><a href="" target="_blank">{{count($cart)}} </a></em> <span class="last-span is-open">]</span>

 <a href="JavaScript::void(0);" class="continue btn-clearcart red">Clear Cart</a>
 <a href="/shop" class="continue">Continue Shopping</a>


  </h1>
 
</div>
</header>
<div class="container">
<section id="cart">
@if(is_null($user))
<div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p>Please login to save item to your account.</p>
</div>
@endif
@empty($cart)
<h1>No products!</h1>
@endempty


@foreach($cart as $cart_id)
@php($bag=App\Cart::where(['id'=>$cart_id])->first())
@php($product=App\Product::where(['id'=>$bag->product_id])->first())
<article class="product" cart-id="{{$cart_id}}">
<header>
<a class="remove">
<img src="{{$product->display_image}}" alt="">
<h3>Remove product</h3>
</a>
</header>
<div class="content">
<h1>{{$product->name}}</h1>
{{$product->description}}
<div style="top: 43px" class="type small red remove"><a class="remove-x text-white">X</a></div>

</div>
<footer class="content">
<span class="qt-minus">-</span>
<span class="qt">{{$bag->quantity}}</span>
<span class="qt-plus">+</span>
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
<footer id="site-footer">
<div class="container clearfix">
<div class="left">
<h2 class="subtotal">Subtotal: {{$currency}}<span></span></h2>
<h3 class="tax">Taxes (5%): {{$currency}}<span></span></h3>
<h3 class="shipping">Shipping: {{$currency}}<span>5.00</span></h3>
</div>
<div class="right">
<h1 class="total">Total: {{$currency}}<span></span></h1>
<a class="btn btn-checkout">Checkout</a>
</div>
</div>
</footer>
<!-- This is the modal with the outside close button -->
<div id="modal-signin" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <h2 class="uk-modal-title">Please Login!</h2>
        <p>Please login to check items out of cart.</p>
		 <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <a class="uk-button uk-button-primary" href="/login?r=/cart">Login</a>
        </p>
    </div>
</div>

<div id="modal-choosecontact" uk-modal>
    <div class="uk-modal-dialog">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Contact Details</h2>
        </div>

        <div class="uk-modal-body" uk-overflow-auto>
		<ul uk-tab>
    		<li><a href="#">Contact</a></li>
			<li><a href="#">Add New</a></li>
		</ul>

		<ul class="uk-switcher uk-margin">
			<li>
			<ul class="uk-list uk-list-striped">
				<li>
				<div onclick="pickContact(this)" contact-id="2" class="uk-card-default uk-card-body contact-picker">
					<span>Name:</span> Michael Piper<br/>
					<span>Phone:</span> 2349031704764<br/>
					<span>Address:</span> Ogba lagos ...<br/>
					</div>
				</li>
				<li>
					<div onclick="pickContact(this)" contact-id="2" class="uk-card-default uk-card-body contact-picker">
					<span>Name:</span> Michael Piper<br/>
					<span>Phone:</span> 2349031704764<br/>
					<span>Address:</span> Ogba lagos ...<br/>
					</div>
				</li>
				<li><div onclick="pickContact(this)" contact-id="2" class="uk-card-default uk-card-body contact-picker">
					<span>Name:</span> Michael Piper<br/>
					<span>Phone:</span> 2349031704764<br/>
					<span>Address:</span> Ogba lagos ...<br/>
					</div>
				</li>
			</ul>
			</li>
			<li>
			 	<form action="" method="POST">
                                    @csrf
									 <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input uk-form-large" name="shipping_name" placeholder="Shipping Name" type="text">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input uk-form-large" name="shipping_email" placeholder="Email" type="email">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                                            <input class="uk-input uk-form-large" name="shipping_phone" placeholder="Phone" type="text">
                                        </div>
                                    </div>
									<div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <select name="shipping_state" class="uk-input uk-select uk-form-large">
                                                <option value="" default="" selected="">Select state</option>
                                                <option value="Abia">Abia</option>
                                                <option value="Adamawa">Adamawa</option>
                                                <option value="Akwa Ibom">Akwa Ibom</option>
                                                <option value="Anambra">Anambra</option>
                                                <option value="Bauchi">Bauchi</option>
                                                <option value="Bayelsa">Bayelsa</option>
                                                <option value="Benue">Benue</option>
                                                <option value="Borno">Borno</option>
                                                <option value="Cross River">Cross River</option>
                                                <option value="Delta">Delta</option>
                                                <option value="Ebonyi">Ebonyi</option>
                                                <option value="Edo">Edo</option>
                                                <option value="Ekiti">Ekiti</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="FCT">FCT</option>
                                                <option value="Gombe">Gombe</option>
                                                <option value="Imo">Imo</option>
                                                <option value="Jigawa">Jigawa</option>
                                                <option value="Kaduna">Kaduna</option>
                                                <option value="Kano">Kano</option>
                                                <option value="Katsina">Katsina</option>
                                                <option value="Kebbi">Kebbi</option>
                                                <option value="Kogi">Kogi</option>
                                                <option value="Kwara">Kwara</option>
                                                <option value="Lagos">Lagos</option>
                                                <option value="Nassarawa">Nassarawa</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Ogun">Ogun</option>
                                                <option value="Ondo">Ondo</option>
                                                <option value="Osun">Osun</option>
                                                <option value="Oyo">Oyo</option>
                                                <option value="Plateau">Plateau</option>
                                                <option value="Rivers">Rivers</option>
                                                <option value="Sokoto">Sokoto</option>
                                                <option value="Taraba">Taraba</option>
                                                <option value="Yobe">Yobe</option>
                                                <option value="Zamfara">Zamfara</option>
                                            </select>
                                        </div>
                                    </div>
									 <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: location"></span>
                                            <input class="uk-input uk-form-large" name="shipping_Address" placeholder="Address" type="text">
                                        </div>
                                    </div>

                         </form>
			</li>
		</ul>
   		</div>

        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" onclick="saveContactAddress()" type="button">Save</button>
        </div>

    </div>
</div>
@endsection


@section('js')
<script id="rendered-js">
      var check = true;
function pickContact($this){
	$('.contact-picker').attr('style','');
	$($this).attr('style','background:green;color:white;')
}
function changeVal(el) {
  var qt = parseFloat(el.parent().children(".qt").html());
  var price = parseFloat(el.parent().children(".price").html().replace(/[{{$currency}}]/gi,''));
  var eq = Math.round(price * qt * 100) / 100;

  el.parent().children(".full-price").html("{{$currency}}"+eq);

  changeTotal();
}

function changeTotal() {

  var price = 0;

  $(".full-price").each(function (index) {
    price += parseFloat($(".full-price").eq(index).html().replace(/[{{$currency}}]/gi,''));
  });

  price = Math.round(price * 100) / 100;
  var tax = Math.round(price * 0.05 * 100) / 100;
  var shipping = parseFloat($(".shipping span").html());
  var fullPrice = Math.round((price + tax + shipping) * 100) / 100;

  if (price == 0) {
    fullPrice = 0;
  }

  $(".subtotal span").html(price);
  $(".tax span").html(tax);
  $(".total span").html(fullPrice);
}


$(document).ready(function () {
changeTotal();
  $(".remove").click(function () {
    var el = $(this);
    el.parent().parent().addClass("removed");
    window.setTimeout(
    function () {
      el.parent().parent().slideUp('fast', function () {
		var cart_id=el.parent().parent().attr('cart-id');
		$.get('/remove_from_cart/'+cart_id);
        el.parent().parent().remove();
        if ($(".product").length == 0) {

            $("#cart").html("<h1>No products!</h1>");

        }
        changeTotal();
      });
    }, 200);
  });
  $(".remove-x").click(function () {
    var el = $(this);
    el.parent().parent().parent().addClass("removed");
    window.setTimeout(
    function () {
      el.parent().parent().parent().slideUp('fast', function () {
		var cart_id=el.parent().parent().parent().attr('cart-id');
		$.get('/remove_from_cart/'+cart_id);
        el.parent().parent().parent().remove();
        if ($(".product").length == 0) {

            $("#cart").html("<h1>No products!</h1>");

        }
        changeTotal();
      });
    }, 200);
  });

  $(".qt-plus").click(function () {
    $(this).parent().children(".qt").html(parseInt($(this).parent().children(".qt").html()) + 1);

    $(this).parent().children(".full-price").addClass("added");

    var el = $(this);
	var cart_id=el.parent().parent().attr('cart-id');
	$.get('/add_to_cart/'+cart_id+'/1');
    window.setTimeout(function () {el.parent().children(".full-price").removeClass("added");changeVal(el);}, 150);
  });

  $(".qt-minus").click(function () {

    child = $(this).parent().children(".qt");

    if (parseInt(child.html()) > 1) {
      child.html(parseInt(child.html()) - 1);
    }

    $(this).parent().children(".full-price").addClass("minused");

    var el = $(this);
	var cart_id=el.parent().parent().attr('cart-id');
	$.get('/remove_from_cart/'+cart_id+'/1');
    window.setTimeout(function () {el.parent().children(".full-price").removeClass("minused");changeVal(el);}, 150);
  });

  window.setTimeout(function () {$(".is-open").removeClass("is-open");}, 1200);

  $(".btn-checkout").click(function () {
	  @if(is_null($user))
	  return UIkit.modal('#modal-signin').show();
	  @endif
   if($(".total span").text()>0){
		UIkit.modal('#modal-choosecontact').show();
		
   }else{
	   $.alert('please login');
   }
    
  });
   $(".btn-clearcart").click(function () {
    check = true;
    $(".remove").click();
  });
});
     function saveContactAddress(){
		 	payWithPaystack();
	 }

    </script>
<script src="https://js.paystack.co/v1/inline.js"></script>
	<script>
		function payWithPaystack(){
			var handler = PaystackPop.setup({
				key: "pk_test_907a3707c9dd8db6c4ee95572a363aa501e7f1f6",
				email: "{{ $user->email ?? 'Unidentified user' }}",
				amount: $(".total span").text()+"00",
				ref: Date.now(),
				currency: "NGN",
				metadata: {
					custom_fields: [
					{ display_name: "Full Names", variable_name: "full_names", value: "{{ $user->display_name ?? 'Unidentified user' }}" },
					{ display_name: "Email Address", variable_name: "email_address", value: "{{ $user->email ?? 'Unidentified user' }}" },
					{ display_name: "Phone Number", variable_name: "phone_number", value: "{{ $user->phone ?? 'Unidentified user' }}" },			
					]
				},
				callback: function(response){
					$.alert('Payment was successfull. transaction ref is ' + response.reference);
					$.get('/verify-payment/'+response.reference).done(function($response){
						console.log($response);
					});
					$(".remove").click();
				},
				onClose: function(){
					$.alert('Transaction Cancelled');
					
				}
			});
			handler.openIframe();
		}
	</script>
@endsection
