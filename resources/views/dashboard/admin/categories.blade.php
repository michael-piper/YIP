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

          <h3 class="card-title">Product Category</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id='products-table' class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>name</th>
              <th>In use</th>
              <th>action</th>
            </tr>
            </thead>
            <tbody>






            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>In use</th>
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
    $.getJSON(API_URL+'v1/categories/'+$id).then(function(res){
        console.log(res);
        screen(res.data);
    });
    var screen=function(data){
        $.confirm({
            title: 'Edit Sub Category!',
            content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group">' +
            '<label>Category Name</label>' +
            '<input class="name form-control" value="'+data.name+'" required>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>Category Description</label>' +
            '<textarea class="description form-control" required>'+data.description+'</textarea>' +
            '</div>' +
            '</form>',
            buttons: {
                formSubmit: {
                    text: 'Submit',
                    btnClass: 'btn-blue',
                    action: function () {
                        var meta={};
                        meta.name = this.$content.find('.name').val();
                        meta.description=this.$content.find('.description').val();
                        $.ajax({
                            method: "PUT",
                            url:API_URL+'v1/categories/'+data.id,
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
      title: 'Add Category!',
      content: '' +
      '<form action="" class="formName">' +
      '<div class="form-group">' +

      '<div class="form-group">' +
      '<label>Category Name</label>' +
      '<input  class="name form-control" required>' +
      '</div>' +
      '<div class="form-group">' +
      '<label>Category Description</label>' +
      '<textarea class="description form-control" required></textarea>' +
      '</div>' +
      '</form>',
      buttons: {
          formSubmit: {
              text: 'Submit',
              btnClass: 'btn-blue',
              action: function () {
                  var meta={};
                meta.name = this.$content.find('.name').val();
                meta.description=this.$content.find('.description').val();
                $.post(API_URL+'v1/categories',meta)
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
    $.getJSON(API_URL+'v1/categories').then(function(res){
    console.log(res.data);
    if(res.error)return;
    $('#products-table tbody').html('');
    $("#products-table").DataTable();
    $("#products-table").DataTable().destroy();
    $('#products-table tbody').html('');
     for(var i in res.data){
        var html=`<tr>
              <th>${res.data[i].id}</th>
              <th>${res.data[i].name}</th>
              <th>${res.data[i].active?'true':'false'}</th>
              <th>
                <button onclick="removeCategory(${res.data[i].id})" class="btn btn-danger btn-sm d-inline" title="move"><span class="fas fa-spin fa-times"></span></button>
                <button onclick="editCategory(${res.data[i].id})" class="btn btn-success btn-sm d-inline" title="move"><span class="fas fa-edit"></span></button>
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
                url:API_URL+'v1/categories/'+categoryid
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
            title: 'Remove Category!',
            content: 'Are you sure you want to remove category?',
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
