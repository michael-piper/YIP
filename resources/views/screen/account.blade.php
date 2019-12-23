@php($user=Auth::user())
@isset($user)
@php($userdetails=App\UserDetail::where(['user_id'=>$user->id])->first())
@else
@php($userdetails=(object)[])
@endisset
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
        <div class="uk-section uk-section-muted w-100 uk-flex uk-flex-middle uk-animation-fade ">
            <div class="uk-width-1-1">
                <div class="uk-container">
                    <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                        <div class="uk-width-1-1@m">
                            <div class="uk-margin uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large radius-large">

                                    <div style="width:100%;" class="uk-margin uk-card uk-card-body uk-border radius-large">

                                        <div class="uk-child-width-1-5@m uk-grid-small uk-grid-match" uk-grid>
                                            <div>
                                                <span class="uk-icon w3-text-yellow" uk-icon="icon: user ;ratio: 2.0"></span>
                                            </div>
                                            <div class="uk-width-2-5">
                                                <h3 class="uk-text-left">Account!</h3>
                                                <span>{{$user->display_name}}</span>
                                                <span>{{$user->phone}}</span>
                                                <span>{{$user->email}}</span>
                                            </div>
                                            <div class="uk-text-right">
                                                <a href="/edit_account" class="uk-text-right">edit</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="uk-child-width-1-2@m uk-grid uk-grid-match" uk-grid>
                                            <div class="uk-padding uk-margin-right-remove uk-padding-right-remove">
                                                <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large radius-large uk-grid-small" uk-grid>
                                                    <div class="uk-width-1-4">
                                                        <span class="uk-icon w3-text-green uk-border radius" style="border-color:green;" uk-icon="icon: list; ratio: 2.0"></span>
                                                    </div>
                                                    <div class="uk-width-3-4">
                                                        <a style="text-decoration:none;" href="/orders">
                                                            <h3>My Orders</h3>
                                                            <p>Track, return or buy things again</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="uk-padding" style="padding-right:-0px;">
                                                <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large radius-large uk-grid-small " uk-grid>
                                                    <div class="uk-width-1-4">
                                                        <span class="uk-icon w3-text-red" uk-icon="icon: heart; ratio: 2.0"></span>
                                                    </div>
                                                    <div class="uk-width-3-4">
                                                        <a style="text-decoration:none;" href="/orders">
                                                            <h3>Saved Items</h3>
                                                            <p>Hit, likes to save items for later</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
@endsection
