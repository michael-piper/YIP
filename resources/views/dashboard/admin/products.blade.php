@extends('layouts.dashboard_admin')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
                <div class="card">
        <div class="card-header">
          <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id='products-table' class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>vendor name</th>
              <th>name</th>
              <th>price</th>
              <th>condition</th>
              <th>commission</th>
              <th>available</th>
              <th>sold</th>
              <th>action</th>
            </tr>
            </thead>
            <tbody>






            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>vendor name</th>
                    <th>name</th>
                    <th>price</th>
                    <th>condition</th>
                    <th>commission</th>
                    <th>available</th>
                    <th>sold</th>
                    <th>action</th>
                </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- / content fluid -->
</div>
<!-- / -->
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
    window.Toast=Toast;
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


 $(function () {
     loadProduct();
});
  function loadProduct(){
    $.getJSON(API_URL+'v1/products').then(function(res){
    console.log(res.data);
    // if(res.error)return;
    $('#products-table tbody').html('');
    $("#products-table").DataTable();
    $("#products-table").DataTable().destroy();
    $('#products-table tbody').html('');
     for(var i in res.data){
        var html=`<tr title="${res.data[i].description}">
              <th>${res.data[i].id}</th>
              <th>${res.data[i].owner.display_name}</th>
              <th>${res.data[i].name}</th>
              <th>${res.data[i].price}</th>
              <th>${res.data[i].condition.name}</th>
              <th>${res.data[i].commission}</th>
              <th>${res.data[i].available}</th>
              <th>${res.data[i].sold}</th>
              <th>
                <button onclick="removeProduct(${res.data[i].id})" class="btn btn-danger btn-sm d-inline" title="delete"><span class="fas fa-trash"></span></button>

                <a href="/dashboard/edit_product/${res.data[i].id}" class="btn btn-info btn-sm" title="edit"><span class="fas fa-edit"></span></a>
                <a href="/dashboard/product/${res.data[i].id}" class="btn btn-success btn-sm" title="view"><span class="fas fa-eye"></span></a>
              </th>
            </tr>`;
        $('#products-table tbody').append(html);
    }
    $("#products-table").DataTable();
});
  }
    function removeProduct(productid){
        $.ajax({
            method: "DELETE",
            url:API_URL+'v1/products/'+productid
        })
        .done(function( res ) {
            if(res.error){
                Toast.fire({
                    type: 'error',
                    title: res.message
                })
            }else{
                Toast.fire({
                    type: 'success',
                    title: res.message
                })
                loadProduct();
            }
        }).fail(function(res){

        });
    }


</script>
@endsection
