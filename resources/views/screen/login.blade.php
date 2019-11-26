@extends('layouts.main')

@section("title","")

@section('style')
<style>
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

@section('js')

@endsection

@section('content')
<section>
        <div class="uk-section uk-section-muted uk-flex uk-flex-middle uk-animation-fade">
            <div class="uk-width-1-1">
                <div class="uk-container">

                    <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                        <div class="uk-width-1-1@m">
                            <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                                @if (isset($error))
                                    @alert(['error'=>$error])
                                    @endalert
                                @elseif(isset($success))
                                    @alert(['success'=>$success])
                                    @endalert
                                @elseif(isset($warning))
                                    @alert(['warning'=>$warning])
                                    @endalert
                                @endif
                                <h3 class="uk-card-title uk-text-center">Welcome back!</h3>
                                <form action="@isset($_GET['r']){{'/login?r='.$_GET['r']}} @else {{'/login '}}@endisset" method="POST">
                                    @csrf
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                            <input class="uk-input uk-form-large" name="email" placeholder="Email" type="text">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="uk-inline uk-width-1-1">
                                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                            <input class="uk-input uk-form-large" name="password" placeholder="Passsword" type="password">
                                        </div>
                                    </div>
                                    <div class="uk-margin">
                                        <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Login</button>
                                    </div>
                                    <div class="uk-form-row uk-text-small">
                                        <label class="uk-float-left"><input name="rememberme" type="checkbox"> Remember Me</label>
                                        <label class="uk-float-right"><a class="uk-float-right uk-link uk-link-muted" href="/forgetpassword">Forgot Password?</a></label>
                                    </div>
                                    <br/>
                                    <div class="uk-text-small uk-text-center">
                                        Not registered?<a href="/signup">Create an account</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
@endsection
