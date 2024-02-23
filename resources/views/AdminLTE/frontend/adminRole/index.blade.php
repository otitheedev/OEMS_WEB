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
            <h1 class="m-0">AddRole</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">AddRole</a></li>
              <li class="breadcrumb-item active">Admin Role</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->





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

<div class="text-left p-2"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Create Admin Role </button></div>


<!-- Your DataTable HTML -->

<table id="example" class="display" style="max-width:100%; text-align:center;">
   <thead>
       <tr>
           <th>ID</th>
           <th>Role Name </th>
           <th>Created At</th>
           <th></th>
       </tr>
   </thead>
   <tbody>
   
   @foreach ($adminRole as $depart)
       <tr>
           <td>{{ $depart->id }}</td>
           <td><a href="{{ url('admin/addRole/addRole/' . $depart->id) }}">{{ $depart->name }}</a></td>
           <td>{{ $depart->created_at }}</td>
           <td>
             <a href="{{ url('admin/addRole/destroy/'. $depart->id) }}">Delete</a> .
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








<div class="container card">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Admin Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


      <div class="container">
        <form action="{{ url('admin/addRole/update') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

         
        </form>
    </div>


      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create Role</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>






<div class="container card">
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Admin Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        


      <div class="container">
        <h2>Create Role</h2>
        <form action="{{ url('admin/addRole/update') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>








  
@endsection




