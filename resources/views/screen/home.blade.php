@extends('layouts.main')

@section("title","")

@section('style')
<style>
 ul.products li.product a img {
    width: 100%;
    height: auto;

    /* margin: 0 0 1em; */
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
    /* float: left; */
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
.product-image{
    width: 100%;
    max-height: 200px !important;
    height: 200px !important;
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
    left: 10px;
    -webkit-border-radius: 500px;
    border-radius: 500px;
    color: #fff;
    background: #00a0de;
    font-size: 13px;
    font-weight: 400;
    margin: -16px;
}
.onsale.yellow{
    color: #fff;
    background: #ebeb34;
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
    left: 10px;
    -webkit-border-radius: 500px;
    border-radius: 500px;
    color:#fff;
    background: #cf4444;
    font-size: 13px;
    font-weight: 400;
    margin: -16px;
}
</style>
<style>
    .bd-example .pagination {
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

@section('js')
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="f4594748-710e-483a-bc2e-f3a9c02254a6";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
@endsection

@section('content')

@includeIf("main.heros")
<style>
.map{
    background:
    url();
    background-size:cover;
}
</style>
<div class="uk-text-center uk-grid-small uk-margin-left uk-margin-right" uk-grid>

    <div class="uk-width-1-1@m" style="margin-top:-50px;">
        @includeIf("main.topsellingitems")
    </div>

    <div class="uk-width-1-1@m">
        @includeIf("main.newinstock")
    </div>
    <div class="uk-width-1-1@m">
        @includeIf("main.dealsoftheday")
    </div>
    <div class="uk-width-1-1@m">
        @includeIf("main.dealsoftheday")
    </div>
</div>
@endsection
