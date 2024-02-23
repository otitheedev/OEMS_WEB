@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Home')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')


<div class="container mt-5">
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

    

  @endsection
