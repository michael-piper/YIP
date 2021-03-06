<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>
<script>
    jQuery.fn.scrollTo = function(elem, speed) {
        $(this).animate({
            scrollTop:  $(this).scrollTop() - $(this).offset().top + $(elem).offset().top
        }, speed == undefined ? 1000 : speed);
        return this;
    };
</script>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,300,600,700,800'>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.2/dist/css/uikit.min.css" />
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">
<!-- UIkit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.2.0/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.2.0/js/uikit-icons.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js" type="text/javascript"></script>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" >

<style>
body{
    color:#000000;
    background-color:#f5f5f5;
    font-family: "Roboto";
}
.radius-large{
    border-radius:25px;

}
.radius-medium{
    border-radius:20px;
}
.radius{
    border-radius:5px;
}
.radius-small{
    border-radius:3px;
}
.radius-top{
    border-top-left-radius:5px;
    border-top-right-radius:5px;
}
.radius-bottom{
    border-bottom-left-radius:5px;
    border-bottom-right-radius:5px;
}
.radius-top-small{
    border-top-left-radius:3px;
    border-top-right-radius:3px;
}
.radius-bottom-small{
    border-bottom-left-radius:3px;
    border-bottom-right-radius:3px;
}
.w3-light{
color:#000;
background-color:#fff !important;
}
.w3-dark{
color:#fff;
background-color:#000 !important;
}
.w3-red{
    color:#fff;
    background-color:#cf4444;
}
.w3-text-red{
   color:#cf4444;
   background-color:transparent;
}
.w3-text-yellow{
   color:yellow;
   background-color:transparent;
}
.w3-text-green{
   color:green;
   background-color:transparent;
}
.w3-theme-gradient {
color: #000 !important;
background:-webkit-linear-gradient(top,#64B5F6 25%,#42A5F5 75%)}
.w3-theme-gradient {
color: #000 !important;
background:-moz-linear-gradient(top,#64B5F6 25%,#42A5F5 75%)}
.w3-theme-gradient {
color: #000 !important;
background:-o-linear-gradient(top,#64B5F6 25%,#42A5F5 75%)}
.w3-theme-gradient {
color: #000 !important;
background:-ms-linear-gradient(top,#64B5F6 25%,#42A5F5 75%)}
.w3-theme-gradient {
color: #000 !important;
background: linear-gradient(top,#64B5F6 25%,#42A5F5 75%)}
.border-bottom{
    border-top:0 !important; border-left:0; border-right:0;
    border-bottom: #333 14px;
}
.border-bottom:hover, .border-bottom:active , .border-bottom:focus{
    border-bottom-color: blue !important;
}
</style>
