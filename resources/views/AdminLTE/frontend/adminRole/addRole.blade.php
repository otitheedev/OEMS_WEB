@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Role</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Role</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

 <!-- Main content -->
 <section class="content">


 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



      <div class="container card p-2">

@php
    $urlSegments = collect(explode('/', url()->current()));
    $lastSegment = $urlSegments->last();
@endphp

        <h2>User Role</h2>
        <form action="{{ url('admin/addRole/addRole/update') }}" method="post">
            @csrf

            <input type="hidden" name="role_id" value="{{ $lastSegment }}" class="form-control">

            <div class="form-group">
                <label for="name">Users:</label>
                <select class="form-group" name="role_users_id">
                @foreach ($users as $userspart)
                    <option value="{{ $userspart->id }}"> {{ $userspart->name }}</option> 
                    @endforeach
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>

    

     </div>
</section>

@endsection