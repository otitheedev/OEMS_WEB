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
            <h1 class="m-0">Attendances</h1>
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
<table class="table table-bordered" style="width:100%">
            <thead>
                  <tr>
                   <th>#</th>
                    <th>UserID</th>
                     <!-- <th>ID</th> -->
                      <th>Name</th>
                      <!-- <th>State</th> -->
                       <th>Timestamp</th>
                      <th>Type
                               <br>
                                0=checkin 
                                <br>
                                1=checkout
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php 
                            $sl=1;
                            @endphp
                  
<!-- attendance start-->
 @foreach($attendaces as $attendace) 
    <tr>
        <th>{{ $sl++ }}</th>
        @foreach($users as $user)   @if($user['userid'] == $attendace['id']) <td>{{ $user['userid'] }}</td> @endif @endforeach
        <!-- <td>{{ $attendace['id'] }}</td> -->
        @foreach($users as $user)   @if($user['userid'] == $attendace['id']) <td>{{ $user['name'] }}</td> @endif @endforeach
        <!-- <td>{{ $attendace['state'] }}</td> -->
        <td>{{ date('j F Y, g:i A', strtotime($attendace['timestamp'])) }}</td>
        <td>
        @if ($attendace['type'] == 0) Check-in @elseif ($attendace['type'] == 1) Check-out @else  Unknown Type  @endif
        </td>
    </tr>
 @endforeach
<!-- attendance end-->


                        </tbody>
                      </table>



      </div>
</section>

@endsection