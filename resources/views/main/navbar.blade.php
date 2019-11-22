<ul class="uk-subnav uk-subnav-divider uk-divider uk-margin-remove-bottom" uk-margin>
        <li class="uk-active"><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
        <li><a href="#">info@motopartsarena.com</a></li>
        <li><a href="#">Phone : 08171902411</a></li>
</ul>
<hr class="uk-margin-remove uk-padding-remove">
<nav class="uk-navbar-container w3-light uk-dark" uk-navbar>

    <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="#"><img src="/images/logo/logo-light.png" uk-img></a>
    </div>

    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            <li class="uk-active"><a href="/"><span class="uk-button-text">Home</span></a></li>
            <li class="uk-active"><a href="/shop"><span class="uk-button-text">Shop</span></a></li>
            <li><a href="/contactus"><span class="uk-button-text">Contact us</span></a></li>
            @auth
            @php($user=Auth::user())
            <li><a href="/orders" class="uk-padding-bottom-remove"><span class="uk-button-text">Orders</span></a></li>
             @if(!is_null($user) && $user->type>1)
                <li><a href="/dashboard" class="uk-padding-bottom-remove"><span class="uk-button-text">Dashboard</span></a></li>
             @endif
            <li><a href="/logout" class="uk-padding-bottom-remove"><span class="uk-button-text">Logout</span></a></li>
            @else
            <li><a href="/login" class="uk-padding-bottom-remove"><span class="uk-button-text">Login | Sign up</span></a></li>
            @endauth
            <li><a href="/cart" class="uk-padding-bottom-remove"><span class="uk-icon" uk-icon="icon: cart"></span> <span class="badge uk-float-left">10</span></a></li>
        </ul>
    </div>

</nav>
<hr class="uk-margin-remove">
