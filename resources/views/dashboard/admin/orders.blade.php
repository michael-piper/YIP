@extends('layouts.dashboard_admin')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
                <div class="card">
        <div class="card-header">
          <h3 class="card-title">Orders</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id='products-table' style="font-size: 9px;" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Product name</th>
              <th>Order status</th>
              <th>Payment status</th>
              <th>Price</th>
              <th>Quantitiy</th>
              <th>Total price</th>
              <th>Shipping fee</th>
              <th>Shipping name</th>
              <th>Shipping address</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>



            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Product name</th>
                    <th>Order status</th>
                    <th>Payment status</th>
                    <th>Price</th>
                    <th>Quantitiy</th>
                    <th>Total price</th>
                    <th>Shipping fee</th>
                    <th>Shipping name</th>

                    <th>Shipping address</th>
                    <th>Action</th>
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
              <th>
                    ${res.data[i].order_status ?res.data[i].order_status.name:'Not available'}
              </th>
              <th>
                    ${res.data[i].payment_status?res.data[i].payment_status.name:'Not available'}
              </th>
              <th>${res.data[i].price}</th>
              <th>${res.data[i].quantity}</th>
              <th>${res.data[i].total_price}</th>
              <th>${res.data[i].shipping_fee}</th>
              <th>${contact.shipping_name}</th>
              <th>${contact.shipping_state}, ${contact.shipping_address}</th>

              <th>
                    <button onclick="removeOrder(${res.data[i].id})" class="btn btn-danger btn-sm d-inline" title="move"><small><span class="fas fa-trash"></span></small></button>
                    <button onclick="orderStatus(${res.data[i].id})" class="btn btn-warning btn-sm d-inline" title="move"><small style="font-size:8px;"><span class="fas fa-bus"></span>order</small></button>
                    <button onclick="paymentStatus(${res.data[i].id})" class="btn btn-warning btn-sm d-inline" title="move"><small style="font-size:8px;"><span class="fas fa-bus"></span>payment</small></button>
              </th>
            </tr>`;
        $('#products-table tbody').append(html);
    }
    $("#products-table").DataTable();
});
  }
    function removeOrder(productid){
        var action = function () {
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
                console.log(res)
            });
        }
        $.confirm({
            title: 'Remove Order!',
            content: 'are you sure you want to remove order?',
            type:'orange',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action: action
                },
                cancel: function () {
                    //close
                }
            }
        });
    }

orderStatus=function($id){
    $.confirm({
        title: 'Change Order Status!',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Select Status</label>' +
        '<select  class="order-status form-control" required>' +
        '</select>'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var meta={};
                    meta.order_status=this.$content.find('.order-status').val();
                    $.ajax({
                            method: "PATCH",
                            url:API_URL+'v1/orders/'+$id,
                            data:meta
                        })
                    .then(function(res){
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
                    });
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            $.getJSON(API_URL+'v1/order-status/').then(function(res){
            var html='';
            for(var i in res.data){
                html+='<option value="'+res.data[i].id+'">'+res.data[i].name+'</option>';
            }
            jc.$content.find('.order-status').html(html);
            });

            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
  };


paymentStatus=function($id){
    $.confirm({
        title: 'Change Payment Status!',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Select Status</label>' +
        '<select  class="payment-status form-control" required>' +
        '</select>'+
        '</div>' +
        '</form>',
        buttons: {
            formSubmit: {
                text: 'Submit',
                btnClass: 'btn-blue',
                action: function () {
                    var meta={};
                    meta.payment_status=this.$content.find('.payment-status').val();
                    $.ajax({
                            method: "PATCH",
                            url:API_URL+'v1/orders/'+$id,
                            data:meta
                        })
                    .then(function(res){
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
                    });
                }
            },
            cancel: function () {
                //close
            },
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            $.getJSON(API_URL+'v1/payment-status/').then(function(res){
            var html='';
            for(var i in res.data){
                html+='<option value="'+res.data[i].id+'">'+res.data[i].name+'</option>';
            }
            jc.$content.find('.payment-status').html(html);
            });

            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    });
  };

</script>
@endsection
