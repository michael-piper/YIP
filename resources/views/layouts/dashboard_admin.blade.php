<!DOCTYPE html>
@php($user=Auth::user())
@php($user=!is_null($user)?$user:(object)[])
@php($userdetails= !is_null($user)?App\UserDetail::where('user_id',$user->id)->first():(object)[])
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf_token" content="{{csrf_token()}}">
  <meta name="X-Api-Token" content="{{$user->api_token}}">
  <title>{{$user->display_name }} | Motoparts Arena | Dashboard 3</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  {{-- select 2 css --}}
  <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
   <!-- DataTables -->
  <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/plugins/adminlte-v3/css/adminlte.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand text-sm navbar-light navbar-white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
            <a href="/shop" class="nav-link">Shop</a>
          </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/logout" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="plugins/adminlte-v3/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="plugins/adminlte-v3/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="plugins/adminlte-v3/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="/plugins/adminlte-v3/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{$user->display_name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @empty($user->display_image)
                <img src="{{config('app.avatar')}}" class="img-circle elevation-2" alt="User Image">
            @else
            <img src="{{$user->display_image}}" class="img-circle elevation-2" alt="User Image">
            @endempty

        </div>
        <div class="info">
          <a href="#" class="d-block">{{$userdetails->addons()->contact_person}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/dashboard/notification" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Notification
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/dashboard/add_product" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dashboard/products" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Products</p>
                </a>
              </li>

            </ul>
          </li>


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Orders
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">62</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="/dashboard/orders" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Orders</p>
                      </a>
                    </li>
                    <li class="nav-item">
                            <a href="/dashboard/reschedule_orders" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Reschedule Orders</p>
                            </a>
                    </li>
                    <li class="nav-item">
                      <a href="/dashboard/failed_order" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Failed Orders</p>
                      </a>
                    </li>
            </ul>
            </li>
            <li class="nav-item">
                <a href="/dashboard/cars-make-model" class="nav-link">
                    <i class="nav-icon fas fa-car"></i>
                    <p class="text">Cars make & model</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/categories" class="nav-link">
                  <i class="nav-icon far fa-file"></i>
                  <p class="text">Category</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="/dashboard/sub_categories" class="nav-link">
                    <i class="nav-icon far fa-file"></i>
                    <p class="text">Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/product_status" class="nav-link">
                    <i class="nav-icon far fa-file"></i>
                    <p class="text">Product Status</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/payment_status" class="nav-link">
                    <i class="nav-icon far fa-file"></i>
                    <p class="text">Payment Status</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/order_status" class="nav-link">
                    <i class="nav-icon far fa-file"></i>
                    <p class="text">Order Status</p>
                </a>
            </li>
          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="/dashboard/getting_started" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Documentation</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('main_content')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.1-pre
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js" type="text/javascript"></script>
<script>
    window.API_URL=location.protocol+'//'+location.host+'/api/';
    $.ajaxSetup({
    headers: {
        'X-Csrf-Token': $("meta[name='csrf-token']").attr('content')||"",
        'X-Api-Token' : $("meta[name='X-Api-Token']").attr("content")||''
    }
});
</script>
@yield('js_before')
<!-- Bootstrap -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE -->
<script src="/plugins/adminlte-v3/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
<!-- SweetAlert2 -->
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="/plugins/select2/js/select2.full.min.js"></script>
<!-- dashboard functions-->
<script src="/plugins/adminlte-v3/js/pages/dashboard3.js"></script>
<!-- Page script -->
@yield('js')
@stack('scripts')
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
    })
</script>

</body>
</html>
