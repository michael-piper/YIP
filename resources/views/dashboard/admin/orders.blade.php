@extends('layouts.dashboard_admin')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
                <div class="card">
        <div class="card-header">
          <h3 class="card-title">DataTable For Orders</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id='products-table' class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>product name</th>
              <th>price</th>
              <th>quantitiy</th>
              <th>total price</th>
              <th>shipping fee</th>
              <th>shipping name</th>
              <th>shipping state</th>
              <th>shipping address</th>
              <th>action</th>
            </tr>
            </thead>
            <tbody>






            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>product name</th>
                    <th>price</th>
                    <th>quantitiy</th>
                    <th>total price</th>
                    <th>shipping fee</th>
                    <th>shipping name</th>
                    <th>shipping state</th>
                    <th>shipping address</th>
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
     loadOrder();
});
  function loadOrder(){
    $.getJSON(API_URL+'v1/orders').then(function(res){
    console.log(res.data);
    if(res.error)return;
    $('#products-table tbody').html('');
    $("#products-table").DataTable();
    $("#products-table").DataTable().destroy();
    $('#products-table tbody').html('');
     for(var i in res.data){
        var contact=JSON.parse(res.data[i].contact);
        var html=`<tr>
              <th>${res.data[i].id}</th>
              <th>${res.data[i].product.name}</th>
              <th>${res.data[i].price}</th>
              <th>${res.data[i].quantity}</th>
              <th>${res.data[i].total_price}</th>
              <th>${res.data[i].shipping_fee}</th>
              <th>${contact.shipping_name}</th>
              <th>${contact.shipping_state}</th>
              <th>${contact.shipping_address}</th>

              <th>
                <button onclick="orderStatus(${res.data[i].id})" class="btn btn-danger btn-sm d-inline" title="move"><span class="fas fa-spin fa-bus"></span></button>
              </th>
            </tr>`;
        $('#products-table tbody').append(html);
    }
    $("#products-table").DataTable();
});
  }
    function removeOrder(productid){
        $.ajax({
            method: "DELETE",
            url:API_URL+'v1/orders/'+productid
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
                loadOrder();
            }
        }).fail(function(res){

        });
    }


</script>
@endsection
