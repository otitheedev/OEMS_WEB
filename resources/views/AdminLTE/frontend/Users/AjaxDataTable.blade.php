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
<div class="col-6">  <a href="{{ url('/admin/users/create') }}" class="btn-sm btn-primary p-2"> Add New Employer</a></div>


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
                <!-- Add other columns as neededss -->
            </tr>
        </thead>
    </table>


<script>
    var authUserEmail = "{{ Auth::user()->email }}";
    var authUserPhoneNumber = "{{ Auth::user()->phone_number }}";

   $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var dataTable = $('#ajaxDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('employee_profile_datatable') }}",
            "type": "GET", // POST, PUT ...
            "dataType": "json",
            "data": {
                "_token": csrfToken,
                "start": 0,
                "length": 10,
            },
        },
       
        "columns": [
            {"data": "id", "className":"text-center"},
            {"data": "name",
                "render": function(data, type, row) {
                    var escapedName = $('<div/>').text(row.name).html();
                    return '<a href="{{ url("/employee/ID/") }}/' + row.phone_number + '" target="_blank">' + escapedName + '</a>';
                },"orderData": [0] 
            },
            {"data": "profile_pic",
                "render": function(data, type, row) {
                    var imageUrl = data ? "{{ url('assets/users/') }}/" + encodeURIComponent(data) : "{{ url('assets/OG.png') }}";
                    return '<img src="' + imageUrl + '" width="60px">';
                },
                "orderData": [0] 
            },
            {"data": "department_name"},
            {"data": "gender", "className":"text-center"},
            {"data": "designation"},
            {"data": "email"},
            {"data": "totalAmount", "className":"text-center"},
            {
                "data": null,
                "render": function(data, type, row) {
                    var deleteButton = '';
                    if (authUserEmail == 'needyamin@gmail.com' && authUserPhoneNumber == '01878578504') {
                        deleteButton = '<a href="{{ url("/admin/users/destroy/") }}/' + row.id + '" class="btn-sm btn-danger">Delete</a> ';
                    }
                    var editButton = '<a href="{{ url("/admin/users/edit/") }}/' + row.id + '" class="btn-sm btn-primary">Edit</a>';
                    return deleteButton + editButton;
                },
                "orderData": [0]
            }
        ]
    });

    $('#applyFilter').on('click', function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();

        if (startDate !== '' && endDate !== '') {
            dataTable.ajax.url(`/api/AjaxDataTable?_token=${encodeURIComponent(csrfToken)}&dateRange[]=${encodeURIComponent(startDate)}&dateRange[]=${encodeURIComponent(endDate)}`).load();
        } else {
            alert('Please select both start date and end date.');
        }
    });
});

</script>



</div>
</section>

@endsection