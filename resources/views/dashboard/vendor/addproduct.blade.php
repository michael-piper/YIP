@extends('layouts.dashboard_vendor')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
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
            <form method="POST" enctype="multipart/form-data">
                @csrf
                 <!-- -->
                <div class="card card-default">

                    <div class="card-header">
                        <h3 class="card-title">Add a new Product</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                          </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-12 col-sm-6">
                                    <style>
                                        .product_image{
                                            width:inherit;
                                            height:200px;
                                            min-width:400px !important;
                                            max-width: 100%;
                                            max-height: 400px;
                                        }
                                    </style>
                                    <img src="" class="product_image img-preview">
                                    <span class="img-preview-label" style="color:green;">choose display image</span>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-picture"></i></span>
                                            </div>
                                            <input type="file" onchange="readURL(this);" name="image" class="form-control">
                                    </div>
                                    <h5>Product price and quantity</h5>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">#</span>
                                        </div>
                                        <input type="text" name="name" class="form-control" placeholder="Product name" value="{{$body['name'] ?? ''}}">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" onclick="var num=parseInt($('#p_quantity').val()); num=num||0;$('#p_quantity').val(num+1)"><i class="fas fa-plus"></i></span>
                                        </div>
                                        <input type="number" name="quantity" id="p_quantity" class="form-control" placeholder="Product Quantity" value="{{$body['quantity'] ?? ''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="var num=parseInt($('#p_quantity').val()); num=num||1;$('#p_quantity').val(num-1)"><i class="fas fa-minus"></i></span>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">{{App\Product::currency()}}</span>
                                        </div>
                                        <input type="text" name="price" class="form-control" placeholder="Product Price" value="{{$body['price'] ?? ''}}">
                                        <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                    <span class="text-success float-right mt-4 pb-1">do product runs on discount?</span>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>
                                        <input type="number" name="discount" class="form-control" placeholder="Product Price Discount" value="{{$body['discount'] ?? ''}}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">

                                    <h5>Maker Details</h5>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-car"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                                <select name="make" class="form-control select2 make" data-placeholder="Select a make" onchange="changeCarModel(this.value);">

                                                </select>
                                            </div>
                                    </div>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-car"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                                <select name="model" class="form-control select2 model" disabled="disabled" data-placeholder="Select a model">

                                                </select>
                                            </div>
                                    </div>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-car"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                            <select name="year[]" class="form-control select2 year"  multiple="multiple"  data-placeholder="Select a year">
                                                @php($years=range(1990,date('Y')))
                                                @php(rsort($years))
                                                @foreach($years as $year)
                                                    <option value="{{$year}}"> {!!$year!!}</option>

                                                @endforeach
                                            </select>
                                            </div>
                                    </div>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dolly"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                                <select name="category" onchange="changeSubCategory(this.value);" class="form-control select2 category load" data-placeholder="Select a category">

                                                </select>
                                            </div>
                                    </div>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dolly"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                                <select name="subcategory" class="form-control select2 subcategory load" disabled data-placeholder="Select a sub category">

                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <h5>Product Details</h5>
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                            <div class="form-control border-0 p-0 m-0">
                                                <select name="condition" class="form-control select2 condition load" data-placeholder="choose product condition">
                                                    <option value="2">New</option>
                                                    <option value="1">Used</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <textarea class="form-control" name="description" placeholder="Product description " minlength="70">{{$body['description'] ?? ''}}</textarea>
                                    </div>
                                </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer  text-right">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="reset" class="btn btn-warning text-light">Clear</button>
                    </div>
                </div>
              </form>
            </div>
        </div>
   </div>
@endsection

@section('js')
<script>
    $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
    @if (isset($error))
    Toast.fire({
        type: 'error',
        title: '{{$error}}'
    })
    @elseif(isset($success))
    Toast.fire({
        type: 'success',
        title: '{{$success}}'
    })
    @elseif(isset($warning))
    Toast.fire({
        type: 'warning',
        title: '{{$warning}}'
    })
    @endif

    });
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
$.getJSON(API_URL+'v1/product/status?norepeat=name').then(function(data){
    // console.log(data);
    $('.condition').html('');
    for(var i in data){
        $('.condition').append('<option value="'+data[i].id+'">'+data[i].name+'</option>')
    }
    var condition='{{$body['condition']??''}}';
    if(condition!=''){
        $(".condition option[value='"+condition+"']").attr("selected", true);
        changeSubCategory(condition);
        $('.condition').val(condition);
    }
});
var years=@json($body['year']??[]);
for (var i in years)
 $(".year option[value='"+years[i]+"']").attr("selected", true);

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
	// functions
function readURL(input) {
    $('.img-preview').attr('style',"display:none;");
    $('.img-preview-label').attr('style',"display:none;");
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      const name=input.files[0].name;
      const pixext=['png','jpeg','jpg','gif'];
      const vidext=['mkv','mp4','flv','webm','ogg'];
      const extension= name.substring(name.lastIndexOf('.')+1);
      // console.log(input.files[0],"name="+name,"extension="+extension);
      reader.onload = function (e) {
        $('.img-preview')
            .attr('src', e.target.result)
            .width(150)
            .attr('style',"display:initial;")
            .height(200);
      };

      if(pixext.find(function(e){return e===extension.toLowerCase()})){
        reader.readAsDataURL(input.files[0]);
      }

      else{

        $('.img-preview-label')
          .attr('style',"display:initial;color:red;")
          .text("file format not supported");
        $('.img-preview')
          .attr('style',"display:none;")
      }

    }else{
        $('.img-preview-label')
            .attr('style',"display:initial;")
            .text("Choose a file");
        $('.img-preview')
            .attr('style',"display:none;")
    }
  }
</script>
@endsection
