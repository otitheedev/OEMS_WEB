<!DOCTYPE html>
<html lang="en">
	
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Otithee Employee Information Desk</title>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">


  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- Favicons start-->
  <link rel="icon" type="image/x-icon" href="{{ url('assets/OG.png') }}"/>

</head>


<!-- body start -->
<body class="hold-transition sidebar-mini layout-fixed" >
    @include('AdminLTE/re_usable_admin/header')
    @include('AdminLTE/re_usable_admin/aside')
    
    <div class="content">
        @yield('content')
    </div>
    
    @include('AdminLTE/re_usable_admin/footer')

   <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">Otithee Group</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

<aside class="control-sidebar control-sidebar-dark"></aside></div>


<script src="{{asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{asset('dist/js/adminlte.js') }}"></script>
<script src="{{asset('dist/js/pages/dashboard.js') }}"></script>
</body>
<!-- body end -->
</html>
