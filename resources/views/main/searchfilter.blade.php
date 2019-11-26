
<section class="uk-card uk-card-body uk-card-hover">
<form class="uk-form-stacked uk-text-left">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Part Number</label>
            <div class="uk-form-controls">
                <input class="uk-input" id="form-stacked-text" type="text" placeholder="Part number...">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-select">Make</label>
            <div class="uk-form-controls">
                        <select name="make" class="uk-select make" data-placeholder="Select a year">
                         
                        </select>
            </div>
        </div>
         <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-select">Model</label>
            <div class="uk-form-controls">
                        <select name="model" class="uk-select model"  data-placeholder="Select a year">
                   
                          
                        </select>
            </div>
        </div>
        <div class="uk-margin">
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
@section('js')
@parent
<script>
$.getJSON(API_URL+'v1/product/autofill/car_makes?norepeat=make').then(function(data){
    // console.log(data);
    $('.make').html('');
    for(var i in data){
        $('.make').append('<option value="'+data[i].make+'">'+data[i].make+'</option>')
    }
    var make='{{$body['make']??''}}';
    if(make!=''){
        $(".make option[value='"+make+"']").attr("selected", true);
        changeCarModel(make);
        $('.make').val(make);
    }
});
$.getJSON(API_URL+'v1/product/category?norepeat=name').then(function(data){
    // console.log(data);
    $('.category').html('');
    for(var i in data){
        $('.category').append('<option value="'+data[i].id+'">'+data[i].name+'</option>')
    }
    var category='{{$body['category']??''}}';
    if(category!=''){
        $(".category option[value='"+category+"']").attr("selected", true);
        changeSubCategory(category);
        $('.category').val(category);
    }
});
function changeCarModel(make){
    // var make=$('.make').val();
    $('.model').html('');
    if(make==''){
        $('.model').attr('disabled','disabled');
        return;
    }
    $.getJSON(API_URL+'v1/product/autofill/car_makes/make='+make+'?norepeat=model').then(function(data){
        $('.model').removeAttr('disabled');
        for(var i in data){
            $('.model').append('<option>'+data[i].model+'</option>')
        }
        var model='{{$body['model']??''}}';
        if(model!=''){
            $(".model option[value='"+model+"']").attr("selected", true);
            $('.model').val(model);
        }
    });
}
function changeSubCategory(sub){
    $('.subcategory').html('');
    if(sub==''){
        $('.subcategory').attr('disabled','disabled');
        return;
    }
    $.getJSON(API_URL+'v1/product/subcategory/category='+sub+'?norepeat=model').then(function(data){
        // console.log(data);
        $('.subcategory').removeAttr('disabled');
        for(var i in data){
            $('.subcategory').append('<option value="'+data[i].id+'">'+data[i].name+'</option>')
        }
        var subcategory='{{$body['subcategory']??''}}';
        if(subcategory!=''){
            $(".subcategory option[value='"+subcategory+"']").attr("selected", true);
            $('.subcategory').val(subcategory);
        }
    });
}
</script>
@endsection
