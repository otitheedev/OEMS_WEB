<!-- extends('AdminLTE.re_usable_admin.layouts')
section('title', 'Home')
section('content') -->

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
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

<!-- salary alert start-->
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="text-white">&times;</span>
    </button>
    Hi, {{ auth()->user()->name }}!<br>
    Based on your current {{ $attendances }} days attendance, you will receive {{ $totalAmount }} BDT this month. 
    ( Calculation start from {{ \Carbon\Carbon::today()->startOfMonth()->format('M d, Y') }} to {{ \Carbon\Carbon::today()->format('M d, Y') }} )
</div>
<!-- salary alert end-->

     @if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))    
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><i class="fas fa-user-friends"></i> {{ \App\Models\reg_user::count() }}	</h3>

                <p><i class="fas fa-user-friends"></i> Total Employee</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('admin/users') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><i class="fas fa-landmark	"></i> {{ \App\Models\department::count() }}</h3>
                <p>All Department</p>
              </div>
              <div class="icon">
                <i class="ion ion-home"></i>
              </div>
              <a href="{{ url('admin/department') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><i class="fas fa-file-alt"></i> {{ \App\Models\LeaveApplication::count() }}</h3>

                <p>Total Leave Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/application') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
     


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><i class="fas fa-bullhorn"></i> {{ \App\Models\notice::count() }}</h3>

                <p>All Notice</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ url('admin/notice') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        @endif

      <div class="row">

      


  @php
  $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth();
  $lastDayOfMonth = \Carbon\Carbon::now()->endOfMonth();
    
  $leaveCount = \App\Models\LeaveApplication::where('status', 1)
        ->where('user_id',auth()->user()->id)
        ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->count();

  $delayOfficeCount = \App\Models\Models\Attendance::where('userid', auth()->user()->attendance_uid)
    ->where('type', 0) // Check-in records
    ->whereBetween(\DB::raw('HOUR(timestamp)'), [10, 12]) // Check-in hour between 10 and 12 (inclusive)
    ->whereBetween('timestamp', [$firstDayOfMonth, $lastDayOfMonth]) // Within the specified time range
    ->count();
    
  @endphp 


        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><i class="fas fa-money-bill-wave"></i> {{ auth()->user()->normal_salary }}</h3>

                <p>Your Basic Salary</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('admin/users') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><i class="fas fa-calendar-alt"></i>  {{ $attendances }}</h3>

                <p>Your Total Attendance this month</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('my_attendance_mysql/' . auth()->user()->attendance_uid) }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><i class="fas fa-file"></i> {{ $leaveCount }}</h3>

                <p>Total Approved Leave this month</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('admin/application') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><i class="fas fa-calendar-alt"></i>  {{ $delayOfficeCount }}</h3>

                <p>Total late this month</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('my_attendance_mysql/' . auth()->user()->attendance_uid) }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


    </div>


    </section>



   <section class="content">
      <div class="container-fluid">
      <div class="card">
    
  <!-- Today Birthday start-->
      @if(count($users_DOB) > 0) 
        <div class="card">
        <h4 class="card-header bg-info" style="font-size: 1.5rem;">
        <i class="far fa-calendar-alt"></i> Today Birthday! </h4>
       
        <ol type="1">
           @foreach ($users_DOB as $user)
            <li class="mt-1" style="font-size: 1.2rem;"> Today is <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a> Birthday! 🎉🎂 @if($user->birthday_sms_sent == '1') ✔ @else ✗ @endif </li>
         @endforeach
            </ol> </div>
      @endif
<!-- Today Birthday End-->


   <!-- Today Anniversary start-->
     @if(count($users_anniversary) > 0) 
        <div class="card">
        <h4 class="card-header bg-info" style="font-size: 1.5rem;">
        <i class="far fa-calendar-alt"></i> Today Anniversary! </h4>
          <ol type="1">
           @foreach ($users_anniversary as $anniversary)
            <li class="mt-1" style="font-size: 1.2rem;">Happy Anniversary <a href="{{ url('employee/ID/'. $anniversary->phone_number) }}" target="_blank">{{ $anniversary->name }}'s</a>! 🎉 </li>
            @endforeach
            </ol> 
          </div>
          @endif
  <!-- Today Anniversary End-->
         
<!-- Today Our Employer Son/daughter Birthday start-->
    @if(count($user_child) > 0)
    @php
        $todayChildBirthdays = false;
    @endphp

    @foreach ($user_child as $user)
        @foreach ($user->child_info as $child)
            @php
                $child_birthday = \Carbon\Carbon::parse($child->child_birthday);
            @endphp

            @if($child_birthday->isToday())
                @php
                    $todayChildBirthdays = true;
                    break; // Exit the loop once a birthday is found
                @endphp
            @endif
        @endforeach

        @if($todayChildBirthdays)
            @break; // Exit the outer loop once a birthday is found
        @endif
    @endforeach

    @if($todayChildBirthdays)
        <div class="card">
            <h4 class="card-header bg-info" style="font-size: 1.5rem;">
            <i class="far fa-calendar-alt"></i> Today Our Employer Son/daughter Birthday! 
            </h4>
            <ol type="1">
                @foreach ($user_child as $user)
                    @foreach ($user->child_info as $child)
                        @php
                            $child_birthday = \Carbon\Carbon::parse($child->child_birthday);
                        @endphp

                        @if($child_birthday->isToday())
                            <li class="mt-1" style="font-size: 1.2rem;"> Our Employer <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a>, @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s Birthday is today! 🎉🎂</li>
                        @endif
                    @endforeach
                @endforeach
            </ol> 
        </div>
    @endif
@endif
<!-- Today Our Employer Son/daughter Birthday End-->


  <!-- upcoming birthday next 7 days start---> 
  @if(count($upcomingBirthdays) > 0)
  <div class="card">
  <h4 class="card-header bg-info" style="font-size: 1.5rem;">
  <i class="far fa-calendar-alt"></i> Upcoming Birthday.. </h4>
  <ol type="1">
  @foreach ($upcomingBirthdays as $upcomingBirthday)
    <li class="mt-2" style="font-size: 1.2rem;"><a href="{{ url('employee/ID/'. $upcomingBirthday->phone_number) }}" target="_blank">{{ $upcomingBirthday->name }}</a> birthday (
    {{ \Carbon\Carbon::parse($upcomingBirthday->DOB)->format('F d, Y') }} )</li>
        
       @foreach ($upcomingBirthday->child_info as $child)
            <li> <a href="{{ url('employee/ID/'. $child->reg_user->phone_number) }}" target="_blank">{{ $child->reg_user->name }}'s</a> @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s birthday {{ $child->child_birthday }}</li>
        @endforeach

    @endforeach
    </ol>
    </div>
  <!-- upcoming birthday next 7 days end---> 

  @endif
  </div> 
</div> 
  
</section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Small boxes (Stat box) -->
        <div class="row">
          
        

<!-- this part only view admin/HR start-->
@auth
@if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))  
<div class="col-lg-12 col-lg-12"> 
<div class="card p-2">
   <div class="card">

   <h4 class="card-header bg-secondary" style="font-size: 1.5rem;">
   <i class="nav-icon fab fa-avianex"></i> Some employees submitted leave applications today.</h4>

   <!-- <div class="card-body" style="max-height: 500px; overflow-y: scroll;"> -->
   <div class="card-body">
   <div class="container-fluid p-2" style="margin-top: -15px;">
   <a href="{{ url('admin/application').'/'.'1' }}" class="d-inline p-2 btn-sm btn-success">All Approved 
   <span class="badge-pill badge-warning" style="font-size:80%;">{{ $approve }}</span></a>

   <a href="{{ url('admin/application').'/'.'0' }}" class="d-inline p-2 btn-sm btn-warning text-white">All Pending 
   <span class="badge-pill badge-danger" style="font-size:80%;">{{ $pending }}</span></a>
   
   <a href="{{ url('admin/application').'/'.'2' }}" class="d-inline p-2 btn-sm btn-danger">All Rejected 
   <span class="badge-pill badge-warning" style="font-size:80%;">{{ $rejected }}</span></a>

   <a href="{{ url('admin/application').'/'.'3' }}" class="d-inline p-2 btn-sm btn-secondary">All Contact with HR 
    <span class="badge-pill badge-warning" style="font-size:80%;">{{ $contact_hr }}</span></a>


   <a href="{{ url('/admin/application/delay_office').'/'.'delay office' }}" class="d-inline p-2 btn-sm btn-success">All Delay Office Application
    <span class="badge-pill badge-warning" style="font-size:80%;">{{ $delay_office }}</span></a>
   </div>
  

   
   @if($all_leave->isEmpty())
    <p>No upcoming leave applications found.</p>
   @else
    
  <table id="leaveTable" class="table-hover table-responsive-lg" style="max-width:100%">
   <thead>
        <tr>
           <th>SL</th>
           <th>Leave_Type</th>
            <th>Employee</th>
            <th>Status</th>
            <th>Leave_Start</th>
            <th>Leave_End</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

    @php $i=1; @endphp
    
    @foreach($all_leave as $leave)
      @php
        $startDate = \Carbon\Carbon::parse($leave->application_start_date);
        $endDate = \Carbon\Carbon::parse($leave->application_end_date);
        $totalDays = $endDate->diffInDays($startDate) + 1; 
      @endphp

      <tr>
         <td style="text-align:center;">{{ $i++ }}</td>
         <td style="text-align:center;">{{ $leave->application_type }}</td>

        <td style="min-width:300px;">
        <strong>Employee:</strong> <a href="{{ url('/employee/ID/' . $leave->user->phone_number) }}" target="_blank"> {{ $leave->user->name }}</a>
        @if(isset($leave->application_start_date))
             applied for total {{ $totalDays }} days leave
         @endif
        <br>
       <strong> Note:</strong> <span class="text-muted">


  @php
    $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth();
    $lastDayOfMonth = \Carbon\Carbon::now()->endOfMonth();
    $leaveCount = \App\Models\LeaveApplication::where('status', 1)
        ->where('user_id',$leave->user->id)
        ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->count();

  $delayOfficeCount = \App\Models\LeaveApplication::where('application_type', 'Delay Office')
        ->where('user_id',$leave->user->id)
        ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->count(); 
  @endphp  
            @if(isset($leave->application_start_date))
            This employee has already taken <b>{{ $leaveCount }}</b> days off this month
            @else
            This employee <b>{{ $delayOfficeCount }}</b> days late in office in this month
            @endif
            </span>

        </td>

      
    <td>
      <a href="{{ url('admin/application/edit/'.$leave->id ) }}">  
         @if ($leave->status == 0)
             <span class="badge-pill badge-warning text-white">Pending</span>
         @elseif ($leave->status == 1)
              <span class="badge-pill badge-success">Approved</span>
         @elseif ($leave->status == 2)
               <span class="badge-pill badge-danger">Rejected</span>
         @elseif ($leave->status == 3)
                <span class="badge-pill badge-secondary">Contact HR Department</span>
        @elseif ($leave->application_type == 'Delay Office')
        <span class="badge-pill badge-secondary">Delay Office</span>
        @else
                <span class="badge-pill badge-secondary">Unknown</span>
         @endif
        </a>
     </td>

               
     <td>
      {{ isset($leave->application_start_date) ? $leave->application_start_date->format('d M, Y l') : 'Delay' }}
     </td>
               
      <td>
      {{ isset($leave->application_end_date) ? $leave->application_end_date->format('d M, Y l') : 'Delay' }}
      </td>

      <td>
         <a href="{{ url('admin/application/edit/'.$leave->id ) }}" class="btn-sm btn-danger"><i class="fas fa-edit"> Edit </i></a>
      </td>

  </tr>
       @endforeach
@endif

</tbody></table>


   </div>
   </div>
  </div>
</div>


<script>
    $(document).ready(function() {
        $('#leaveTable').DataTable({
            searching: false, 
            lengthChange: false, 
            info: false, 
            dom: 'Bfrtip',
            
            dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],

        });
    });
</script>



<div class="col-lg-12 col-lg-12"> 
<div class="card p-2">
   <div class="card">
   <h4 class="card-header bg-secondary" style="font-size: 1.5rem;">
   <i class="nav-icon fab fa-avianex"></i> Upcoming leaves</h4>

  <div class="card-body">

   @if($upcomingLeave->isEmpty())
    <p>No upcoming leave applications found.</p>
@else
   <ol start="1">
        @foreach($upcomingLeave as $leave)
        @php
        // Convert start and end dates to Carbon instances
        $startDate = \Carbon\Carbon::parse($leave->application_start_date);
        $endDate = \Carbon\Carbon::parse($leave->application_end_date);

        // Calculate the difference in days
        $totalDays = $endDate->diffInDays($startDate) + 1; 
         @endphp

            <li>
                <strong>Employee:</strong> <a href="{{ url('/employee/ID/' . $leave->user->phone_number)  }}" target="_blank"> {{ $leave->user->name }}</a> want total {{ $totalDays }} days leave<br>

          <strong>Status:</strong> 
            <a href="{{ url('admin/application/edit/'.$leave->id ) }}">  
          @if ($leave->status == 0)
        <span class="badge-pill badge-danger">Pending</span>

         @elseif ($leave->status == 1)
        <span class="badge-pill badge-success">Approved</span>
        
         @elseif ($leave->status == 2)
        <span class="badge-pill badge-danger">Rejected</span>

        @elseif ($leave->status == 3)
        <span class="badge-pill badge-secondary">Contact HR Department</span>

        @else
        <span class="badge-pill badge-secondary">Unknown</span>
         @endif
      </a>
         <br>

                <strong>Want Leave From:</strong> <span class="text-muted">{{ $leave->application_start_date->format('d M, Y l') }}</span>
                 <strong>To:</strong> <span class="text-muted">{{ $leave->application_end_date->format('d M, Y l') }}</span><br>
               
                <strong>Application Created:</strong>  <span class="text-muted">{{ $leave->created_at->format('d M, Y l') }}</span><br>
            
               <strong> Note:</strong> <span class="text-muted"> 
                
  @php
    $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth();
    $lastDayOfMonth = \Carbon\Carbon::now()->endOfMonth();
    $leaveCount = \App\Models\LeaveApplication::where('status', 1)
        ->where('user_id',$leave->user->id)
        ->whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])
        ->count();
  @endphp 
            This employee has already taken {{ $leaveCount }} days off this month
            </span>


            </li>
        @endforeach
    </ol>
@endif


   </div>
   </div>
  </div>
</div>

@endif
@endauth
<!-- this part only view admin/HR end-->



        <div class="col-lg-6 col-lg-6"> 
           <!-- TO DO List -->
           <div class="card">
              <div class="card-header bg-primary">
                <h3 class="card-title">
                <i class="nav-icon fas fa-bullhorn"></i>
                  Notice Board
                </h3>
              </div>
          
       <div class="card-body" style="max-height: 350px; overflow-y: scroll;">
               
       <ul class="todo-list" data-widget="todo-list">
        
@if(count($all_notice) > 0)
@foreach ($all_notice as $all_notices)
    <li>
        <span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>
        @if($all_notices->notice_file && file_exists(public_path('assets/notice/' . $all_notices->notice_file)))
    <a href="{{ url('assets/notice/' . $all_notices->notice_file) }}" target="_blank">
@endif

            <span class="text">
                <span class="badge badge badge-primary">{{ $all_notices->notice_type }}</span> {{ $all_notices->notice_title }}
            </span>
            <small class="badge badge-danger"><i class="far fa-clock"></i> {{ $all_notices->created_at->diffForHumans() }}</small>
            @if(file_exists(public_path('assets/notice/' . $all_notices->notice_file)))
                <div class="tools"> <a href="{{ url('/admin/notice/view/' . $all_notices->id ) }}"> <i class="fas fa-eye"></i> View Full Notice </a></div>
            </a>
            
        
        @endif
    </li>
@endforeach

  @else 
  <li>No data found</li>
  @endif 

     </ul>
        </div>
  
    
            </div>
            <!-- /.card -->
    
          </div> 




<div class="col-lg-6 col-lg-6"> 

<!-- TO DO List -->
<div class="card">
   <div class="card-header bg-primary">
     <h3 class="card-title">
     <i class="nav-icon fab fa-avianex"></i>
       All Recent Leave
     </h3>

     <div class="card-tools">
     </div>
   </div>

   <div class="card-body" style="max-height: 350px; overflow-y: scroll;">
     <ul class="todo-list" data-widget="todo-list">

     @if(count($all_leave) > 0)
     @foreach ($all_leave as $all_leaves)    
       <li>
         <span class="handle">
           <i class="fas fa-ellipsis-v"></i>
           <i class="fas fa-ellipsis-v"></i>
         </span>
  
      <!--    <div  class="icheck-primary d-inline ml-2">
           <input type="checkbox" value="" name="todo1" id="todoCheck1">
           <label for="todoCheck1"></label>
         </div> -->
    
         <span class="text"><a href="{{ url('/employee/ID/' . $all_leaves->user->phone_number)  }}" target="_blank">{{ $all_leaves->user->name }}</a> ({{ $all_leaves->user->department_name }})</span> applied for leave
         <small class="badge badge-danger"><i class="far fa-clock"></i> {{ $all_leaves->created_at->diffForHumans() }}</small>

       </li>
       @endforeach

  @else 
  <li>No data found</li>
  @endif 
  
     </ul>
   </div>

 </div>
 <!-- /.card -->

</div> 




<!-- Holiday Events Start -->
<div class="col-lg-12 col-lg-12"> 
<div class="card p-2">
   <div class="card">

   <h3 class="card-header bg-primary" style="font-size: 1.2rem;"><i class="far fa-calendar-alt"></i> Holiday Events</h3>

   <div class="card-body" style="max-height: 500px; overflow-y: scroll;">


  <table id="holidayTable" class="table table-responsive-lg" style="max-width:100%">
   <thead>
        <tr>
           <th>SL</th>
            <th>Holiday Type</th>
            <th>Holiday Title</th>
            <th>Holiday Start From</th>
            <th>Holiday End</th>
            <th> Duration </th>
            <th> File </th>
        </tr>
    </thead>
    <tbody>
    @php
    $i=1;
    @endphp
    @foreach($all_holiday as $holidayinfo)
    <tr>
       <td style="text-align:center;">{{ $i++ }}</td>
       <td> {{ $holidayinfo->holiday_type }}</td>
       <td> {{ $holidayinfo->holiday_title }} </td>
       <td> {{ $holidayinfo->start_date->format('d M, Y') }} </td>
       <td> {{ $holidayinfo->end_date->format('d M, Y') }} </td>
       <td> 
        @php
        $startDate = \Carbon\Carbon::parse($holidayinfo->start_date);
        $endDate = \Carbon\Carbon::parse($holidayinfo->end_date);
        $totalDays = $endDate->diffInDays($startDate) + 1; 
        @endphp
        <span class="badge badge-primary" style="font-size:16px; text-align:center;">{{ $totalDays }} Days</span>
       </td>
       <td> @if($holidayinfo->holiday_file) <a href="{{ url('assets/holiday_file/'. $holidayinfo->holiday_file) }}" target="_blanl"> {{ $holidayinfo->holiday_file }}</a>
      @else
      No files
      @endif
      </td>
     </tr>
     @endforeach
</tbody></table>

   </div>
   </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#holidayTable').DataTable({
            searching: false, 
            lengthChange: false, 
            info: false, 
            dom: 'Bfrtip',
            
            dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],

        });
    });
</script>
<!-- Holiday Events End -->





<div class="col-lg-6 col-lg-6">
          <div class="card bg-gradient-secondary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Birthday Event Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
            <!--       <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div> -->
                  <button type="button" class="btn btn-secondary btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-secondary btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              
          
<div class="card-body pt-0">

<!--The calendar -->
<!-- DateTimePicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<div id="calendar" style="width: 100%; height:300px;"></div></div></div>
            
<style>.date-highlighted {background-color: yellow !important; color: black !important;}</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#calendar').datetimepicker({
        format: 'L',
        inline: true
    });

    var highlightedDates = [
    @foreach ($users_DOB as $user)
        { date: new Date('{{ $user->DOB }}'), 
        message: "Today is {{ $user->count() }} empoyeer Birthday! " },
    @endforeach
];

    highlightedDates.forEach(function (highlight) {
        var formattedDate = moment(highlight.date).format('L');
        var targetDay = document.querySelector('.datepicker-days td[data-day="' + formattedDate + '"]');
        
        if (targetDay) {
            targetDay.classList.add('date-highlighted');

            targetDay.addEventListener('mouseenter', function () {
                targetDay.classList.add('hovered-highlighted-date');

     //alert('You clicked on a highlighted date: ' + formattedDate);
    var Welcome = new bootstrap.Modal(document.getElementById('exampleModal'));
    Welcome.show();
    targetDay.addEventListener('mouseleave', function removeHoveredClass() {
        targetDay.classList.remove('hovered-highlighted-date');
        targetDay.removeEventListener('mouseleave', removeHoveredClass);
        Welcome.hide(); // Hide the modal when the mouse leaves the date
    });
            });
        }
    });
});
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Today is {{ isset($user) ? $user->count() : 0 }} employer Birthday! And {{ $users_anniversary->count() }} employer anniversary and our employer's {{ $user_child_birthday->count() }} child birthday!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <ol type="1">
            @foreach ($users_DOB as $user)
            <li> Today is <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a> Birthday! 🎉🎂 @if($user->birthday_sms_sent == '1') ✔ @else ✗ @endif </li>
            
            @foreach ($users_anniversary as $anniversary)
            <li>Happy Anniversary <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $anniversary->name }}'s</a>! 🎉🎂 </li>
            @endforeach

        @foreach ($user_child as $user)
            @foreach ($user->child_info as $child)
            <li> Our Employer <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a>, @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s Birthday is today! 🎉🎂</li>
            @endforeach
    
         @endforeach
         @endforeach
            </ol> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div></div> 



    <div class="col-lg-6 col-lg-6">
          <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                 Holiday Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              
<div class="card-body pt-0">

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<div id="holidaycalendar" style="width: 100%;height:300px;"></div></div></div>
            
<style>.date-highlightedxx {background-color: yellow !important; color: black !important;}</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#holidaycalendar').datetimepicker({
        format: 'L',
        inline: true
    });

    var highlightedDatesxx = [
    @foreach ($holiday as $user)
        { date: new Date('{{ substr($user->start_date, 0, 10) }}'), 
        message: "Today is {{ $user->count() }} empoyeer Birthday! " },
    @endforeach
];

    highlightedDatesxx.forEach(function (highlightxx) {
        var formattedDatex = moment(highlightxx.date).format('L');
        var targetDay = document.querySelector('.datepicker-days td[data-day="' + formattedDatex + '"]');
        
        if (targetDay) {
            targetDay.classList.add('date-highlighted');

            targetDay.addEventListener('mouseenter', function () {
                targetDay.classList.add('hovered-highlighted-date');

     //alert('You clicked on a highlighted date: ' + formattedDate);
    var Welcome = new bootstrap.Modal(document.getElementById('exampleModalxx'));
    Welcome.show();
    targetDay.addEventListener('mouseleave', function removeHoveredClass() {
        targetDay.classList.remove('hovered-highlighted-date');
        targetDay.removeEventListener('mouseleave', removeHoveredClass);
        Welcome.hide(); // Hide the modal when the mouse leaves the date
    });
            });
        }
    });
});
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModalxx" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Today is Holiday!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <ol type="1">
       

          @foreach ($holiday as $user)
         Holiday start from  {{ substr($user->start_date, 0, 10) }} to {{ substr($user->end_date, 0, 10) }}
         
         @php
        $startDate = \Carbon\Carbon::parse($user->start_date);
        $endDate = \Carbon\Carbon::parse($user->end_date);
        $totalDays = $endDate->diffInDays($startDate) + 1; // Add 1 to include both start and end dates
        @endphp

       <span class="btn btn-success">  {{ $totalDays }} Days </span>
            @endforeach
    
            </ol> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div></div> 










</div>
</section>
  </div>
  
  @endsection
