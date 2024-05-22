@extends('AdminLTE.re_usable_admin.datatable_layouts')
@section('title', 'Attendance')
@section('content')
@include('AdminLTE/re_usable_admin/dataTable_jQuery')



<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Today Attendancess</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attendances</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
 

 <!-- Main content -->
 <section class="container-fluid card p-2">
<style>tr,th,td{text-align:center;} </style>
 <table id="attendanceTable" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Timestamp</th>
                    <th>Type</th>
                    <th>Application</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>




<script>
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('machine.my_attendance_datatable', ['uid' => auth()->user()->attendance_uid]) }}",
            "type": "GET",
            "dataSrc": ""
        },
        "columns": [
            { "data": null, "sortable": false, "render": function (data, type, row, meta) {
                return meta.row + 1;
            }},
            { "data": "user.name", "defaultContent": "none" },
            { "data": "timestamp", "render": function (data, type, row) {
                return new Date(data).toLocaleString();
            }},
            { "data": "type", "render": function (data, type, row) {
                if (data == 0) return "Check-in";
                else if (data == 1) return "Check-out";
                else return "Unknown Type";
            }},
            { "data": "needs_color", "render": function (data, type, row) {
                if (data) return '<a href="{{ url('/admin/application/delay_office') }}">Late Application</a>';
                else return 'Faster!';
            }}
        ],
        "rowCallback": function(row, data, index) {
            if (data.needs_color) {
                $(row).css('background-color', '#ffcccc');
            }
        }
    });
});
</script>



      </div>
</section>

@endsection