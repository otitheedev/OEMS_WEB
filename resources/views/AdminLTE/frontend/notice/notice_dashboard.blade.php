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
            <h1 class="m-0">All Notices</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Notices</li>
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




<div class="container-fluid card p-2">

<div class="text-left p-2"> <a href="{{ url('/admin/notice/create') }}" class="btn-sm btn-primary p-2"> Add New Notices </a></div>
<hr>

<!-- Your DataTable HTML -->
<table id="example" class="display" style="max-width:100%">
    <thead>
        <tr>
            <th>Notice Type </th>
            <th>Notice Details</th>
            <th>Created_at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    
    @foreach ($application as $applicate)
    <tr>
        <td>{{ $applicate->application_type }}</td>
         <td> <span class="badge-pill badge-primary">Days</span></td>
        <td>{{ $applicate->created_at->diffForHumans() }}</td>
            <td>
              <a href="{{ url('admin/notice/destroy/'. $applicate->id) }}" class="btn-sm btn-danger">Delete</a> .
              <a href="{{ url('admin/notice/edit/'. $applicate->id) }}" class="btn-sm btn-info">Edit</a>
           </td>
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