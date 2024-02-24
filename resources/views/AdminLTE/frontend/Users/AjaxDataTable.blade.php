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

<div class="row mt-2">
<div class="col-6">  <a href="{{ url('/admin/users/create') }}" class="btn-sm btn-primary p-2"> Create New Users</a></div>

   <div class="col-6">
        <label for="dateRange">Filter by Date Range:</label>
        <input type="date" id="startDate" name="startDate">
        <input type="date" id="endDate" name="endDate">
        <button id="applyFilter">Apply Filter</button>
    </div>
</div>
<hr>
    <table id="ajaxDataTable" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Photo</th>
                <th> Department </th>
                <th> Gender </th>
                <th> Designation </th>
                <th>Email</th>
                <th>Basic Salary</th>
                <th> </th>
                <!-- Add other columns as neededs -->
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function() {
            var dataTable = $('#ajaxDataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "http://127.0.0.1:8000/api/AjaxDataTable",
                    "type": "GET",
                    "dataSrc": "data",
                    "beforeSend": function(xhr) {
                // Include your custom headers here
                xhr.setRequestHeader('X-Username', 'needyamin@gmail.com');
                xhr.setRequestHeader('X-Key', 'needyamin@gmail.com');
            },
                },
                "columns": [
                    {"data": "id", "className":"text-center"},
                    {
               "data": name,
               "render": function(data, type, row) {
                // Assuming $users is accessible in this context
                return '<a href="{{ url("/employee/ID/") }}/' + row.phone_number + '" target="_blank">' + row.name + '</a>';
                 },"orderData": [0] 
                },

                {"data": "profile_pic",
                "render": function(data, type, row) {
                    // Assuming 'profile_pic' is the field in your response containing the profile picture filename
                    var imageUrl = data ? "{{ url('assets/users/') }}/" + data : "{{ url('assets/OG.png') }}";
                    return '<img src="' + imageUrl + '" width="60px">';
                 },
                     "orderData": [0] 
                },
                 
                 {"data": "department_name"},
                 {"data": "gender", "className":"text-center"},
                 {"data": "designation"},
                 {"data": "email"},
                 {"data": "normal_salary", "className":"text-center"},
                 
                 {
               
                    "data": null,
                    "render": function(data, type, row) {
                     console.log('Delete Link - Row ID:', row.id);
                    return '<a href="{{ url("/admin/users/destroy/") }}/' + row.id + '" class="btn-sm btn-danger">Delete</a> ' +
                    '<a href="{{ url("/admin/users/edit/") }}/' + row.id + '" class="btn-sm btn-primary">Edit</a>';
                     },
                     "orderData": [0] 
                    }
 
              ]
            });

            $('#applyFilter').on('click', function() {
             var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

              // Check if both startDate and endDate are not empty before making the Ajax call
              if (startDate !== '' && endDate !== '') {
              // Your Ajax call
                   dataTable.ajax.url("http://127.0.0.1:8000/api/AjaxDataTable?dateRange[]=" + startDate + "&dateRange[]=" + endDate).load();
            } else {
        alert('Please select both start date and end date.');
        }
        });


        });
    </script>



</div>
</section>

@endsection