<!DOCTYPE html>
<html lang="en">
	
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Otithee Employee Information Desk</title>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css') }}">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  
  <!-- Favicons start-->
  <link rel="icon" type="image/x-icon" href="{{ url('assets/OG.png') }}"/>

 </head>


<!-- body start -->
<body class="hold-transition sidebar-mini layout-fixed">
    @include('AdminLTE/re_usable_admin/header')
    @include('AdminLTE/re_usable_admin/aside')
    
    <div class="content">@yield('content')</div>
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

<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{asset('dist/js/adminlte.js') }}"></script>

</body>


<!-- body end -->
</html>
