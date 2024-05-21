@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">

     <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h1 class="m-0">Employees</h1>
              </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employees</li>
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
<div class="text-left p-2"><a href="{{ url('/admin/users/create') }}" class="btn btn-primary p-2"> Create New Users</a></div>

<!-- Your DataTable HTML -->
<table id="example" class="table-esponsive" style="max-width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Photo</th>
            <th>Department</th>
            <th>Gender</th>
            <th>Designation</th>
            <th>Join Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    
     @foreach ($user as $users)
        <tr>
            <td><a href="{{ url('/employee/ID/' . $users->phone_number) }}">{{ $users->name }}</a></td>
            <td><img src="{{ asset('assets/users/' . $users->profile_pic) }}" width="80px"></td>
            <td>{{ $users->department_name }}</td>
            <td>{{ $users->Gender }}</td>
            <td>{{ $users->designation }}</td>
            <td>{{ $users->otithee_joining_date }}</td>
            <td>
              <a href="{{ url('/admin/users/destroy/'. $users->id) }}">Delete</a> .
              <a href="{{ url('/admin/users/edit/'. $users->id) }}">Edit</a>
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