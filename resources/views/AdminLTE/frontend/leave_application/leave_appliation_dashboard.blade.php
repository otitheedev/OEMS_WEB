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
            <h1 class="m-0">All Leave Appliations</h1>
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Leave Appliations</li>
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

<div class="text-left p-2"> <a href="{{ url('/admin/application/create') }}" class="btn-sm btn-primary p-2"> Create New Application </a></div>
<hr>

<!-- Your DataTable HTML -->
<table id="example" class="table-responsive-lg display" style="max-width:100%; text-align:center;">
    <thead>
        <tr>
            <th>Employee </th>
            <th>Leave Type</th>
            <th>Leave Start</th>
            <th>Leave End</th>
            <th>Duration</th>
            <th>Leave_Status </th>
            <th>Created_At</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    
    @foreach ($application as $applicate)
    <tr>
        <td><a href="{{ url('/employee/ID/'.$applicate->user->phone_number ) }}">{{ $applicate->user->name }}</a></td>
        <td>{{ $applicate->application_type }}</td>
            
   <td>
   <span class="badge badge-info" style="font-size:16px;">{{ isset($applicate->application_start_date) ? $applicate->application_start_date->format('d M, Y l') : '--' }}
</span> 
  </td> 

 <td> 
   <span class="badge badge-info" style="font-size:16px;"> {{ isset($applicate->application_end_date) ? $applicate->application_end_date->format('d M, Y l') : '--' }}
 </span>
    @php
        // Convert start and end dates to Carbon instances
        $startDate = \Carbon\Carbon::parse($applicate->application_start_date);
        $endDate = \Carbon\Carbon::parse($applicate->application_end_date);

        // Calculate the difference in days
        $totalDays = $endDate->diffInDays($startDate) + 1; 
    @endphp
  </td>

          <td> <span class="badge badge-primary" style="font-size:16px;">{{ $totalDays }} Days</span></td>
          
        <td> 
          @if ($applicate->status == 0)
        <span class="badge-pill badge-warning text-white">Pending</span>

         @elseif ($applicate->status == 1)
        <span class="badge-pill badge-success">Approved</span>
        
         @elseif ($applicate->status == 2)
        <span class="badge-pill badge-danger">Rejected</span>

        @elseif ($applicate->status == 3)
        <span class="badge-pill badge-secondary">Contact HR Department</span>

        @elseif ($applicate->status == 'Delay Office')
        <span class="badge-pill badge-secondary">Delay Office</span>

        @else
        <span class="badge-pill badge-secondary">Unknown</span>
         @endif
          </td>

            <td>{{ $applicate->created_at->diffForHumans() }} <br> <span class="text-muted">{{ $applicate->created_at->format('d M, Y') }} </span> </td>
            <td>
             
              <a href="{{ url('admin/application/edit/'. $applicate->id) }}" class="btn-sm btn-info">Edit</a>
           </td>

           <td>
           <a href="{{ url('admin/application/destroy/'. $applicate->id) }}" class="btn-sm btn-danger">Delete</a>
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