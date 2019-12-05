<style>
    .alink-nav{
        color:black;
        text-decoration: none;
    }
    .alink-nav:hover{
        color:blue;
        text-decoration: none;
    }
    .uk-border{
        border:1px solid #555;
    }
</style>
<hr class="uk-margin-remove uk-padding-remove">
<nav class="uk-navbar-container w3-light uk-dark" uk-navbar>

    <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="#"><img src="/images/logo/logo-light.png" uk-img></a>
        <a href="javascript:void(0);" onclick="$('#categorydata').toggle();$('#subcategory-holder').hide();" class="alink-nav"> <i class="uk-icon fa fa-bars"></i></a>

        <div class="uk-navbar-item">

            <form method="GET" action="/shop">
                {{-- <div class="uk-search uk-search-default" > --}}
                <div class="uk-inline" style="width:40vw;">
                     <a onclick="$('#searchfilter').toggle();" href="javascript:void(0);" class="uk-form-icon uk-form-icon-flip uk-border radius" style="width:inherit;max-width:70px;">Filter &nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
                    <input formtarget="dosearch" class="uk-input radius" name="q" value="{{$_GET['q']??''}}" type="search" placeholder="Search for products and Accessories">
                </div>
                <button class="btn  btn-primary radius"> <i class="fa fa-search"></i></button>
                <div class="uk-width-1-1 uk-position-absolute" id="searchfilter" style="left:0;display:none;z-index: 999999999;margin-top:23px;">
                        <section style="" class="uk-width-1-1 uk-section uk-card-default uk-card-body">
                                <div class="uk-form-stacked uk-child-width-1-5@m uk-child-width-1-2@s uk-text-left" uk-grid>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Vehicle</label>
                                            <div class="uk-form-controls">
                                                <select name="make" value="{{$_GET['make']??''}}" class="uk-select make radius-large" onchange="changeCarModel(this.value);" data-placeholder="Select a year">

                                                </select>
                                            </div>
                                        </div>
                                         <div>
                                            <label class="uk-form-label" for="form-stacked-select">Model</label>
                                            <div class="uk-form-controls">
                                            <select value="{{$_GET['model']??''}}" name="model" class="uk-select model radius-large"  data-placeholder="Select a year">

                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-select">Year</label>
                                            <div class="uk-form-controls">
                                                <select name="year"  class="uk-select year radius-large" data-placeholder="Select a year">
                                                        <option  value=""> All</option>
                                                    @php($years=range(1990,date('Y')))
                                                    @php(rsort($years))
                                                    @foreach($years as $year)
                                                        <option  @if(isset($_GET['year']) && $year == $_GET['year']) {{'selected="selected"'}}@endif value="{{$year}}"> {!!$year!!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-text">Part</label>
                                                <div class="uk-form-controls">
                                                        <select name="category" class="uk-select year radius-large" data-placeholder="Select a year">
                                                                <option  value=""> All</option>

                                                                @foreach(App\ProductCategory::all() as $category)
                                                                    <option @if(isset($_GET['category']) && $category->id == $_GET['category'] || isset($_GET['category']) && $category->name == $_GET['category']) {{'selected="selected"'}}@endif value="{{$category->id}}"> {!!$category->name!!}</option>
                                                                @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-text">Part Number</label>
                                            <div class="uk-form-controls">
                                                <input value="{{$_GET['partnumber']??''}}" class="uk-input radius-large" name="partnumber" id="form-stacked-text" type="text" placeholder="Part number...">
                                            </div>
                                        </div>

                                </div>

                                </section>
                        </div>
            </form>

        </div>
    </div>
    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            <li class="uk-active"><a  href="/"><span class="uk-button-text">Home</span></a></li>
            @auth
            @php($user=Auth::user())
            <li>
                    <a href="#" class="uk-padding-bottom-remove"><span class="uk-button-text">Account</span><span class="uk-icon uk-margin-remove" uk-icon="icon: triangle-down"></span></a>
                    <div class="uk-card uk-card-body radius-large" uk-dropdown>
                            <ul class="uk-list uk-list-divider">
                                    <li><span class="uk-icon" uk-icon="icon: user"></span> <a class="alink-nav uk-button-text" href="/profile">View Account</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: file-text"></span> <a class="alink-nav uk-button-text" href="/logout">Orders</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: heart"></span> <a class="alink-nav uk-button-text" href="/logout">Save Items</a></li>
                                    @if(!is_null($user) && $user->type>1) <li><span class="fa fa-dashboard" ></span> <a href="/dashboard" class="uk-padding-bottom-remove"><span class="uk-button-text">Dashboard</span></a></li> @endif

                                    <li><span class="uk-icon" uk-icon="icon: sign-out"></span> <a class="alink-nav uk-button-text" href="/logout">Logout</a></li>
                                </ul>
                    </div>
            </li>
            @else
            <li>
                    <a href="#" class="uk-padding-bottom-remove"><span class="uk-button-text">Account</span><span class="uk-icon uk-margin-remove" uk-icon="icon: triangle-down"></span></a>
                    <div class="uk-card uk-card-body radius-large" uk-dropdown>
                            <ul class="uk-list uk-list-divider">
                                    <li><span class="uk-icon" uk-icon="icon: user"></span> <a class="alink-nav uk-button-text" href="/signup">Create Account</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: sign-in"></span> <a class="alink-nav uk-button-text" href="/login">Login</a></li>
                                </ul>
                    </div>
            </li>
            @endauth

            <li><a href="/contactus"><span class="uk-button-text">Contact us</span></a></li>

            @auth
            @php($user_cart=App\Cart::where(['user_id'=>$user->id])->select('id')->get())
            @php($cart=[])
            @foreach($user_cart as $cart_data)
            @php($cart[]=$cart_data->id)
            @endforeach
            @else
            @php($cart=session('cart')??[])
            @endauth
            <li><a href="/cart" class="uk-padding-bottom-remove"><span class="uk-button-text"><font size="5"><i class="fa fa-cart-plus" aria-hidden="true"></i></font> Cart<span class="badge badge-primary uk-position-absolute" style="left:9px;">{{count($cart)}}</span></span></a></li>
        </ul>
    </div>

</nav>
<hr class="uk-margin-remove">
<div class="uk-width-1-1 uk-position-absolute wow bounceInLeft" id="categorydata" style="left:20px;display:none;z-index: 999999999;margin-top:1px;">
        <div class="row">
            <div class="col-5 col-sm-5 col-md-4 col-lg-3 p-0" id="category-holder" >
                <div class="uk-card-default uk-card-body radius-large" style="height:340px;">
                    <span onclick="$('#mksds').scroll($('#mksds').height()-12)"></span>
                    <ul id="mksds" class="uk-list uk-list-divider" style="overflow:hidden;">
                        @foreach(App\ProductCategory::all() as $category)
                            <li class="change_sub" cat-id="{{$category->id}}"><small style="font-size:10px;">{{ $category->name}} <span class="uk-icon float-right" uk-icon="icon: chevron-right"></span></small></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-5 col-sm-5 col-md-4 col-lg-3 p-0 pl-1" id="subcategory-holder" style="display:none;">
                <div class="uk-card-default uk-card-body radius-large" style="height:340px;">
                    <ul id="ksdks" class="uk-list uk-list-divider" style="overflow:hidden;">

                    </ul>
                </div>
            </div>
        </div>
</div>
@push('scripts')
    <script>
        function changeSubCategory(sub){
            var capture=$('#subcategory-holder ul');
            capture.html('');
            $.getJSON(API_URL+'v1/product/subcategory/category='+sub+'?norepeat=model').then(function(data){
                // console.log(data);
                var html='';
                for(var i in data){
                    html+=('<li id="subcat-'+data[i].id+'"><small><a href="/shop?category='+sub+'&subcategory='+data[i].id+'">'+data[i].name+'</a></small></li>')
                }
                if(html=='')html='<li><small>empty list</small></li>';
                capture.html(html);
                $('#subcategory-holder').show();
            });
        }
        $(function(){
          //while document is ready

            $( ".change_sub" ).on("click mouseenter", function() {
                $this=$(this);

                changeSubCategory($this.attr('cat-id'));
            });
            $('#category-holder').on('mouseleave',function(){
                // $(this).toggle();
            });
            $('#categorydata').on('mouseleave',function(){
                $(this).hide();
                // $(this).removeClass('wow').addClass('animated').addClass('bounceOutLeft')
            });
            $('#subcategory-holder').on('mouseleave',function(){
                $(this).hide();
            });
        });
        $.getJSON(API_URL+'v1/product/autofill/car_makes?norepeat=make').then(function(data){
            // console.log(data);
            $('.make').html('<option  value=""> All</option>');
            for(var i in data){
                $('.make').append('<option value="'+data[i].make+'">'+data[i].make+'</option>')
            }
            var make=$('.make').attr('value');
            if(make!=''){
                $(".make option[value='"+make+"']").attr("selected", true);
                changeCarModel(make);
                $('.make').val(make);
            }
        });
        function changeCarModel(make){
            $('.model').html('<option  value=""> All</option>');
            if(make==''){
                $('.model').attr('disabled','disabled');
                return;
            }
            $.getJSON(API_URL+'v1/product/autofill/car_makes/make='+make+'?norepeat=model').then(function(data){
                $('.model').removeAttr('disabled');
                for(var i in data){
                    $('.model').append('<option>'+data[i].model+'</option>')
                }
                var model=$('.model').attr('value');
                if(model!=''){
                    $(".model option[value='"+model+"']").attr("selected", true);

                    $('.model').val(model);
                }
            });
        }
    </script>
@endpush
