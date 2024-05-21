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
            <h1 class="m-0">Today Attendances</h1>
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
<table id="example" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <!-- <th>Role</th> -->
            <th>Name</th>
            <!-- <th>State</th> -->
            <th>Timestamp</th>
            <th>Type</th>
            <th>Application</th>
        </tr>
    </thead>
    <tbody>
        @php
        $sl=1;
        @endphp
        <!-- attendance start-->
        @foreach($attendances as $attendance)
            @php
                $checkInTime = strtotime($attendance['timestamp']);
                $checkInHour = date('H', $checkInTime);
            @endphp
            <tr @if ($attendance['needs_color']) style="background-color: #ffcccc;" @endif>
                <th>{{ $sl++ }}</th>
                <!-- <td>{{ optional($attendance->user)->role }}</td> -->
                <td>{{ optional($attendance->user)->name ?? "none" }}</td>
                <!-- <td>{{ $attendance['state'] }}</td> -->
                <td>{{ date('j F Y, g:i A', $checkInTime) }}</td>
                <td>
                    @if ($attendance['type'] == 0) Check-in @elseif ($attendance['type'] == 1) Check-out @else Unknown Type @endif
                </td>
          @if ($attendance['needs_color'])
          <td>
            <a href="{{ url('/admin/application/delay_office') }}">Late Application</a>
          </td>
          @else 
          <td> Faster! </td>
          @endif
            </tr>
        @endforeach
        <!-- attendance end-->
    </tbody>
</table>





      </div>
</section>

@endsection