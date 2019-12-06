@extends('layouts.main')

@section("title","")

@section('style')
<style>

.clearfix {
  content:"";
  display: table;
}

.pop-up {
  width: 900px;
  height: auto;
  margin-left: auto;
  margin-right: auto;
  margin-top: 80px;
  position: relative;
  background: #fff;
  padding: 30px;
  border-radius: 2px;
}
/*GALLERY*/
.pics {
  float: left;
  width: 460px;
  margin-right: 0px;
}
.pics span {
  display: block;
}
.main-img img{
  display: block;
  border: .5px solid #ddd;
  border-radius: 2px;
  padding: 60px 30px;
  width: 410px;
  height: 410px;
  margin-bottom: 10px;
  cursor: pointer;
}
.additional-img img {
  float: left; /*display: inline-block has  automatic margin right and bottom :( */
  width: 90px;
  height: 90px;
  padding: 10px 5px;
  border: .5px solid #ddd;
  border-radius: 2px;
  margin-right: 5px;
  cursor: pointer;
}
.additional-img img:nth-child(4) {
  margin-right: 0;
}
.main-img img:hover,
.additional-img img:hover {
  box-shadow: 0 0 6px #ddd;
}
/*PRODUCT INFORMATION*/
.product-item {
  float: right;
  width: 430px;
}
span.category {
  display: block;
  font-weight: 700;
  color: #888;
  font-size: 12px;
  line-height: 14px;
  font-style: italic;
}
.product-item .category:hover {
  color: #999;
  cursor: pointer;
}
.product-item h1 {
  width: 300px;
  font-size: 21px;
  line-height: 24px;
  margin-top: 5px;
  color: #333;
  text-transform: uppercase;
  letter-spacing: .3px;
}
/*STOCK LABEL*/
span.stock {
  display: block;
  float: right;
  position: relative;
  top: 4px;
  line-height: 11px;
  padding: 6px 12px 5px 12px;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
  color: #fff;
  background: #18d11f;
  border-radius: 14px;
  letter-spacing: .3px;
}
/*PRICE & RATING*/
.block-price-rating {
  width: 100%;
  margin-top: 10px;
}
.block-price {
  float: left;
  width: auto;
  margin-right: 20px;
}
.price-new {
  float: left;
  font-weight: bold;
  margin-right: 10px;
}
.price-new-dollar {
  float: left;
  display: block;
  font-size: 24px;
  margin-right: 5px;
  color: #333;
}
.price-new-cent {
  font-size: 14px;
}
.price-old {
  text-decoration: line-through;
  color: #444;
  font-size: 14px;
  position: relative;
  top: 6px;
}
/*rating*/
.block-rating {
  float: right;
  position: relative;
  top: 2px;
}
span.rating img {
  display: block;
  float: left;
  width: 110px;
  margin-left: 10px;
}
span.rating img:hover {
  cursor: pointer;
}
/*review*/
span.review {
  display: block;
  float: left;
  position: relative;
  top: 6px;
  font-weight: 700;
  color: #888;
  font-size: 12px;
  font-style: italic;
}
span.review:hover {
  color: #999;
  cursor: pointer;
}
/*PRODUCT DESCRIPTION*/
.descr {
  font-size: 14px;
  line-height: 18px;
  color: #444;
  letter-spacing: .3px;
  margin-top: 10px;
  width: 430px;
  height: 71px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: no-wrap;
}
/*SELECT BLOCK*/
.block-select {
  margin-top: 15px;
}
.select-color,
.select-size {
  float: left;
  font-size: 14px;
  font-weight: 700;
  color: #888;
}
.select-color span,
.select-size span {
  display: block;
  margin-bottom: 5px;
}
select.color {
  width: 320px;
  margin-right: 10px;
}
select.size {
  width: 100px;
}
select.color, select.size {
  padding: 8px 10px;
  border: .5px solid #ddd;
  border-radius: 2px;
  text-transform: uppercase;
  font-weight: 700;
  opacity: .7;
  letter-spacing: .3px;
}
/*BUTTON*/
.btn-item {
  margin: 10px auto;
  text-align: center;
  font-size: 14px;
  font-weight: 700;
  color: #fff;
  letter-spacing: .3px;
  text-transform: uppercase;
  padding: 15px 0;
  width: 100%;
  border-radius: 2px;
  cursor: pointer;
  background: #fd7064;
}
.btn-item:hover {
  background: #fc796f;
}
/*LINKS*/
.block-footer {
  width: 100%;
  margin-top: 10px;
}
.block-links {
  float: left;
  cursor: pointer;
}
.block-links img {
  width: 20px;
  opacity: .3;
  vertical-align: middle;
  margin-right: 5px;
}
.block-links span {
  font-size: 11px;
  color: #888;
  font-weight: 700;
  letter-spacing: .3px;
  text-transform: uppercase;
  font-style: italic;
}
.block-links span:hover {
  color: #999;
}
.wishlist {
  margin-top: 5px;
} */
/*SOCIAL*/
.social {
  float: right;
  position: relative;
  top: 5px;
}
.social img {
  width: 36px;
  opacity: .3;
  cursor: pointer;
  margin-right: 3px;
  display: inline;
}
.social img:nth-child(4) {
  margin-right: 0;
}
.social img:hover {
  opacity: .2;
}

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
<div class="uk-grid-small" uk-grid>

    <div class="uk-width-1-1@m">
      @include( "main.item")
    </div>
    <div class="uk-text-center uk-width-1-1@m">
      @includeIf("main.topsellingitems")
    </div>

</div>
@endsection
