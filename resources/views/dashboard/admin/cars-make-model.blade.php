@extends('layouts.dashboard_admin')
@section('main_content')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
                <div class="card">
        <div class="card-header">
                <button onclick="addCategory();" class="btn btn-primary btn-sm float-right">Add</button>

          <h3 class="card-title">Cars Make And Model</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id='products-table' class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Make</th>
              <th>Model</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>






            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Make</th>
                    <th>Model</th>
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
    editCategory=function($id){
    $.getJSON(API_URL+'v1/cars-make-model/'+$id).then(function(res){
        console.log(res);
        if(res.data){
            res.data.id=$id;
            screen(res.data);
        }
    });
    var screen=function(data){
        $.confirm({
            title: 'Edit Make & Model!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Make</label>' +
            '<input class="make form-control" value="'+data.make+'" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>Model</label>' +
            '<input class="model form-control" value="'+data.model+'" required>' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var meta={};
                        meta.make = this.$content.find('.make').val();
                        meta.model=this.$content.find('.model').val();
                        $.ajax({
                            method: "PUT",
                            url:API_URL+'v1/cars-make-model/'+data.id,
                            data:meta
                        })
                        .done(function(res){
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
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }
  };
addCategory=function(){
    $.confirm({
      title: 'Add Make and Model!',
      content: '' +
      '<form action="" class="formName">' +
      '<div class="form-group">' +

      '<div class="form-group">' +
      '<label>Make</label>' +
      '<input  class="make form-control" required>' +
      '</div>' +
      '<div class="form-group">' +
      '<label>Model</label>' +
      '<input  class="model form-control" required>' +
      '</div>' +
      '</form>',
      buttons: {
          formSubmit: {
              text: 'Submit',
              btnClass: 'btn-blue',
              action: function () {
                  var meta={};
                meta.make = this.$content.find('.make').val();
                meta.model=this.$content.find('.model').val();
                $.post(API_URL+'v1/cars-make-model',meta)
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
          this.$content.find('form').on('submit', function (e) {
              // if the user submits the form by pressing enter in the field.
              e.preventDefault();
              jc.$$formSubmit.trigger('click'); // reference the button and click it
          });
      }
  });
  };
 $(function () {
     loadOrder();
});
  function loadOrder(){
    $.getJSON(API_URL+'v1/cars-make-model').then(function(res){
    if(res.data.error)return;
    $('#products-table tbody').html('');
    $("#products-table").DataTable();
    $("#products-table").DataTable().destroy();
    $('#products-table tbody').html('');
     for(var i in res.data){
        var html=`<tr>
              <th>${i}</th>
              <th>${res.data[i].make}</th>
              <th>${res.data[i].model}</th>
              <th>
                <button onclick="removeCategory(${i})" class="btn btn-danger btn-sm d-inline" title="move"><span class="fas fa-spin fa-times"></span></button>
                <button onclick="editCategory(${i})" class="btn btn-success btn-sm d-inline" title="move"><span class="fas fa-edit"></span></button>
              </th>
            </tr>`;
        $('#products-table tbody').append(html);
    }
    $("#products-table").DataTable();
});
  }
    function removeCategory(categoryid){
        var action=function(){
            $.ajax({
                method: "DELETE",
                url:API_URL+'v1/cars-make-model/'+categoryid
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
        $.confirm({
            title: 'Remove Make & Model!',
            content: 'Are you sure you want to remove make & model?',
            type:'orange',
            buttons: {
                formSubmit: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    action:action
                },
                cancel: function () {
                    //close
                }
            }
        });

    }


</script>
@endsection
