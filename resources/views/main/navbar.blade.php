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
        border:1px solid #999;
    }
    .link-active{
        background: #f7f7f7;
    }
</style>
<hr class="uk-margin-remove uk-padding-remove">
<nav class="uk-navbar-container w3-light uk-dark" uk-navbar>

    <div class="uk-navbar-left uk-margin-small-left">
        <a class="uk-navbar-item uk-logo" href="/"><img src="/images/logo/logo-light.png" uk-img></a>
        <a href="javascript:void(0);" onclick="$('#categorydata').toggle();$('#subcategory-holder').hide();" class="alink-nav"> <i class="uk-icon fa fa-bars"></i></a>

        <div class="uk-navbar-item">

            <form method="GET" action="/shop">
                {{-- <div class="uk-search uk-search-default" > --}}
                <div class="uk-inline" style="width:40vw;">
                     <button id="opensearchfilter" type="button" class="uk-form-icon uk-form-icon-flip uk-border radius" style="width:inherit;max-width:70px;"><span style="vertical-align: middle;line-height: 1px;">Filter &nbsp;&nbsp;&nbsp;</span><i class="fa fa-caret-down"></i></button>
                    <input formtarget="dosearch" class="uk-input radius" name="q" value="{{$_GET['q']??''}}" type="search" placeholder="Search for Products and Accessories">
                </div>
                <button class="btn  btn-primary radius"> <i class="fa fa-search"></i></button>
                <div class="uk-width-1-1 uk-position-absolute" id="searchfilter" style="left:0;display:none;z-index: 999999999;margin-top:23px;">
                        <section style="" class="uk-width-1-1 uk-section uk-card-default uk-card-body">
                                <div class="uk-form-stacked uk-child-width-1-6@m uk-child-width-1-3@s uk-text-left" uk-grid>
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
                                            <label class="uk-form-label" for="form-stacked-text">Condition</label>
                                            <div class="uk-form-controls">
                                                <select name="condition" class="uk-select condition radius-large" data-placeholder="Select a condition">
                                                        <option  value="">All</option>

                                                        @foreach(App\ProductStatus::all() as $condition)
                                                            <option @if(isset($_GET['condition']) && $condition->id == $_GET['condition'] || isset($_GET['condition']) && $condition->name == $_GET['condition']) {{'selected="selected"'}}@endif value="{{$condition->id}}"> {!!$condition->name!!}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">&nbsp;</label>
                                    <div class="uk-form-controls">
                                        <input type="submit" value="Search" class="uk-button uk-button-primary radius-medium">
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
                                    <li><span class="uk-icon" uk-icon="icon: file-text"></span> <a class="alink-nav uk-button-text" href="/orders">Orders</a></li>
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
                            <ul class="uk-list">
                                    <li><span class="uk-icon" uk-icon="icon: user"></span> <a class="alink-nav uk-button-text" href="/signup">Create Account</a></li>
                                    <li class="uk-heading-line text-center"><span>OR</span> </li>
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
<div class="uk-width-1-1 uk-position-absolute wow bounceInLeft" id="categorydata" style="left:80px;display:none;z-index: 999999999;margin-top:1px;">
        <div class="row">
            <div class="col-5 col-sm-5 col-md-4 col-lg-3 p-0" id="category-holder" >
                <div class="uk-card-default uk-card-body radius-medium p-1" overflow="true" style="height:340px;">
                    <h5 class="px-3 pt-2"><b> Shop by Category</b></h5>
                    <ul id="mksds" class="uk-list">
                        @php($categories=App\ProductCategory::all())
                        @foreach( $categories as $category)
                            <li class="change_sub py-2" cat-id="{{$category->id}}">&nbsp;<small style="font-size:16px;">{{ $category->name}} <span class="uk-icon float-right" uk-icon="icon: chevron-right"></span></small></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-5 col-sm-5 col-md-4 col-lg-3 p-0 pl-1" id="subcategory-holder" style="display:none;">
                <div class="uk-card-default uk-card-body radius-medium p-1" overflow="true" style="height:340px;">
                    <h5 class="px-3 pt-2"><b> </b></h5>
                    <ul id="ksdks" class="uk-list">

                    </ul>
                </div>
            </div>
        </div>
</div>
@push('scripts')
    <script>
        $('#opensearchfilter').on('click',function(){
            $('#searchfilter').toggle();
        });
        $('[overflow]').on('mouseenter',function(){
            $(this).css('overflow','scroll');
        });
        $('[overflow]').on('mouseleave',function(){
            $(this).css('overflow','hidden');
        });
        $('[overflow]').css('overflow','hidden');
        function changeSubCategory(sub){
            var capture=$('#subcategory-holder ul');
            capture.html('');
            $.getJSON(API_URL+'v1/product/subcategory/category='+sub+'?norepeat=model').then(function(data){
                // console.log(data);
                var html='';
                data=data.sort(function(a, b){return a.name-b.name}) || [];
                for(var i in data){
                    html+=('<li id="subcat-'+data[i].id+'" class="py-2 sub_cat" style="font-size:16px;">&nbsp;<a href="/shop?category='+sub+'&subcategory='+data[i].id+'">'+data[i].name+'</a></li>')
                }
                if(html=='')html='<li class="py-2 sub_cat" style="font-size:16px;">&nbsp; empty list</li>';
                capture.html(html);
                $('#subcategory-holder').show();
                $( ".sub_cat" ).on("click mouseenter", function() {
                    $this=$(this);
                    $('.sub_cat').removeClass('link-active');
                    $this.addClass('link-active');
                });
            });
        }
        $(function(){
          //while document is ready

            $( ".change_sub" ).on("click mouseenter", function() {
                $this=$(this);
                $('.change_sub').removeClass('link-active');
                $this.addClass('link-active');
                $('#subcategory-holder h5 b').text($this.find('small').text());
                changeSubCategory($this.attr('cat-id'));
            });

            $('#category-holder').on('mouseleave',function(){

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
            data=data.sort() || [];
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
                data=data.sort() || [];
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
