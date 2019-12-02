<style>
    .alink-nav{
        color:black;
        text-decoration: none;
    }
    .alink-nav:hover{
        color:blue;
    }
    .uk-border{
        border:1px solid #555;
    }
</style>
<hr class="uk-margin-remove uk-padding-remove">
<nav class="uk-navbar-container w3-light uk-dark" uk-navbar>

    <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="#"><img src="/images/logo/logo-light.png" uk-img></a>
        <a href="#" class="alink-nav"> <i class="uk-icon fa fa-bars"></i></a>

        <div class="uk-navbar-item">

            <form method="GET" action="/shop">
                {{-- <div class="uk-search uk-search-default" > --}}
                <div class="uk-inline" style="width:40vw;">
                     <span class="uk-form-icon uk-form-icon-flip uk-border radius" style="width:inherit;max-width:70px">Filter &nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></span>
                    <input class="uk-input radius" name="q" value="{{$_GET['q']??''}}" type="search" placeholder="Search for products and Accessories">
                </div>
                <button class="btn  btn-primary radius"> <i class="fa fa-search"></i></button>
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
                    <div class="uk-card uk-card-body radius" uk-dropdown>
                            <ul class="uk-list uk-list-divider">
                                    <li><span class="uk-icon" uk-icon="icon: user"></span> <a class="alink-nav" href="/profile">View Account</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: file-text"></span> <a class="alink-nav" href="/logout">Orders</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: heart"></span> <a class="alink-nav" href="/logout">Save Items</a></li>
                                    @if(!is_null($user) && $user->type>1) <li><a href="/dashboard" class="uk-padding-bottom-remove"><span class="uk-button-text">Dashboard</span></a></li> @endif

                                    <li><span class="uk-icon" uk-icon="icon: sign-out"></span> <a class="alink-nav" href="/logout">Logout</a></li>
                                </ul>
                    </div>
            </li>
            @else
            <li>
                    <a href="#" class="uk-padding-bottom-remove"><span class="uk-button-text">Account</span><span class="uk-icon uk-margin-remove" uk-icon="icon: triangle-down"></span></a>
                    <div class="uk-card uk-card-body radius" uk-dropdown>
                            <ul class="uk-list uk-list-divider">
                                    <li><span class="uk-icon" uk-icon="icon: user"></span> <a class="alink-nav" href="/signup">Create Account</a></li>
                                    <li><span class="uk-icon" uk-icon="icon: sign-in"></span> <a class="alink-nav" href="/login">Login</a></li>
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
<section class=" uk-section uk-card-primary uk-position-absolute uk-card-body uk-card-hover">
        <form class="uk-form-stacked uk-child-width-1-3 uk-text-left" uk-grid>

                <div>
                    <label class="uk-form-label" for="form-stacked-text">Part Number</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" placeholder="Part number...">
                    </div>
                </div>

                <div >
                    <label class="uk-form-label" for="form-stacked-select">Make</label>
                    <div class="uk-form-controls">
                                <select name="make" class="uk-select make" data-placeholder="Select a year">

                                </select>
                    </div>
                </div>
                 <div >
                    <label class="uk-form-label" for="form-stacked-select">Model</label>
                    <div class="uk-form-controls">
                                <select name="model" class="uk-select model"  data-placeholder="Select a year">


                                </select>
                    </div>
                </div>
                <div>
                    <label class="uk-form-label" for="form-stacked-select">Year</label>
                    <div class="uk-form-controls">
                                <select name="year[]" class="uk-select year"  multiple="multiple"  data-placeholder="Select a year">
                                    @php($years=range(1990,date('Y')))
                                    @php(rsort($years))
                                    @foreach($years as $year)
                                        <option value="{{$year}}"> {!!$year!!}</option>
                                    @endforeach
                                </select>
                    </div>
                </div>
                <div class="uk-margin">
                    <div class="uk-form-label">OEM</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" name="radio1" value="YES"> Yes</label>
                        <br>
                        <label><input class="uk-radio" type="radio" name="radio1" value="NO"> No</label>
                    </div>
                </div>

            </form>
        </section>
