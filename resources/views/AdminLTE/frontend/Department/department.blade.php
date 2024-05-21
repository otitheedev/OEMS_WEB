@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page headers) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Department</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Department</li>
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

<div class="text-left p-2"> <a href="{{ url('/admin/department/create') }}" class="btn-sm btn-primary p-2"> Create New Department </a></div>
<hr>

<!-- Your DataTable HTML -->
<table id="example" class="table-responsive-lg  display" style="max-width:100%">
    <thead>
        <tr>
            <th>department_name</th>
            <th>department_photo </th>
            <th>department_information</th>
            <th>Chairman</th>
            <th>General Manager</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    
    @foreach ($department as $depart)
        <tr>
            <td>{{ $depart->department_name }}</td>
            <td><img src="{{ asset('assets/department/' . $depart->department_photo) }}" width="60px"></td>
            <td>{{ implode(' ', array_slice(str_word_count(strip_tags($depart->department_information), 1), 0, 50)) }}... </td>
            <td>{{ $depart->department_director }}</td>
            <td>{{ $depart->department_gm }}</td>
            <td>
              <a href="{{ url('/admin/department/destroy/'. $depart->id) }}" class="btn-sm btn-danger">Delete</a> 
              <a href="{{ url('admin/department/edit/'. $depart->id) }}" class="btn-sm btn-info">Edit</a>
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