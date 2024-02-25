@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">


    
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Activity Logs</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Logs</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 


 <!-- Main content -->
 <section class="container-fluid">

 @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="container-fluid card p-2">


<!-- Your DataTable HTML -->
<table id="example" class="table-esponsive" style="max-width:100%">
    <thead>
        <tr>
            <th>Sr.</th>
            <th>User_ID</th>
            <th>Description</th>
            <th>Ip Address</th>
            <th>URL</th>
            <th>Browser_Agent</th>
        </tr>
    </thead>
    <tbody>
    
     @foreach ($logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_name }}</td>
            <td>{{ $log->description }}</td>
            <td>{{ $log->ip_address }}</td>
            <td>{{ $log->url }}</td>
            <td>{{ $log->browser_agent }}</td>
        </tr>
     @endforeach

    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            searching: true, 
        });
    });
</script>

      </div>
</section>

@endsection