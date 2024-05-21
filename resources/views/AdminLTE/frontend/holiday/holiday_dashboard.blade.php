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
            <h1 class="m-0">All Holiday Events</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Holiday Events</li>
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

@auth
@if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))     
<div class="text-left p-2"> <a href="{{ url('/admin/holiday/create') }}" class="btn-sm btn-primary p-2"> Add New Holiday </a></div>
@endif
@endauth

<hr>

<!-- Your DataTable HTML -->
<table id="example" class="table-responsive-lg display" style="max-width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Holiday Type </th>
            <th>Holiday Details</th>
            <th>Holiday Start</th>
            <th>Holiday End</th>
            <th>Created_at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('holiday_homeindexAjax') }}", 
            columns: [
                { data: 'custom_id', name: 'custom_id' },
                { data: 'custom_holiday_type', name: 'custom_holiday_type' },
                { data: 'custom_holiday_message', name: 'custom_holiday_message' },
                { data: 'custom_start_date', name: 'custom_start_date' },
                { data: 'custom_end_date', name: 'custom_end_date' },
                { data: 'custom_created_at', name: 'custom_created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>





      </div>
</section>

@endsection