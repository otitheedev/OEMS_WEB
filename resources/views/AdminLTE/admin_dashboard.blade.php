@extends('AdminLTE.re_usable_admin.layouts')
@section('title', 'Home')
@section('content')

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

        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ \App\Models\reg_user::count() }}</h3>

                <p>Total Employee</p>
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
                <h3>{{ \App\Models\department::count() }}</h3>
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
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ \App\Models\LeaveApplication::count() }}</h3>

                <p>Leave Application</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('admin/application') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ \App\Models\notice::count() }}</h3>

                <p>Notice Board</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ url('admin/notice') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
    </section>



   <section class="content">
      <div class="container-fluid">
        <div class="card p-2">
        <div class="card">
        @if(count($users_DOB) > 0) 
        <h4 class="card-header" style="font-size: 1.5rem;"><i class="ion ion-load-a mr-1"></i> Today Birthday! </h4>@endif
       
        <ol type="1">
          @foreach ($users_DOB as $user)
            <li class="mt-1"> Today is <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a> Birthday! 🎉🎂 @if($user->birthday_sms_sent == '1') ✔ @else ✗ @endif </li>

            @foreach ($users_anniversary as $anniversary)
            <li class="mt-1">Happy Anniversary <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $anniversary->name }}'s</a>! 🎉🎂 </li>
            @endforeach

           @foreach ($user_child as $user)
            @foreach ($user->child_info as $child)
            <li class="mt-1"> Our Employer <a href="{{ url('employee/ID/'. $user->phone_number) }}" target="_blank">{{ $user->name }}'s</a>, @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s Birthday is today! 🎉🎂</li>
            @endforeach

         @endforeach
         @endforeach
            </ol> 
</div>

  <!-- upcoming birthday next 7 days ---> 
  @if(count($upcomingBirthdays) > 0)
  <div class="card">
  <h4 class="card-header" style="font-size: 1.5rem;"><i class="ion ion-ios-clock mr-1"></i> Upcoming Birthday.. </h4>
  <ol type="1">
  @foreach ($upcomingBirthdays as $upcomingBirthday)
    <li class="mt-2"><a href="{{ url('employee/ID/'. $upcomingBirthday->phone_number) }}" target="_blank">{{ $upcomingBirthday->name }}</a> birthday (
    {{ \Carbon\Carbon::parse($upcomingBirthday->DOB)->format('F d, Y') }} )</li>
        
       @foreach ($upcomingBirthday->child_info as $child)
            <li> <a href="{{ url('employee/ID/'. $child->reg_user->phone_number) }}" target="_blank">{{ $child->reg_user->name }}'s</a> @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s birthday {{ $child->child_birthday }}</li>
        @endforeach

    @endforeach
    </div>
    @endif
  </ol>


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
   <h4 class="card-header" style="font-size: 1.5rem;"><i class="ion ion-clipboard mr-1"></i> Today employees are submitting leave applications</h4>

   <div class="card-body" style="max-height: 370px; overflow-y: scroll;">

   @if($all_leave->isEmpty())
    <p>No upcoming leave applications found.</p>
   
    @else
   <ol start="1">
        @foreach($all_leave as $leave)
        @php
        // Convert start and end dates to Carbon instances
        $startDate = \Carbon\Carbon::parse($leave->application_start_date);
        $endDate = \Carbon\Carbon::parse($leave->application_end_date);

        // Calculate the difference in days
        $totalDays = $endDate->diffInDays($startDate) + 1; 
         @endphp

            <li class="mt-2">
                <strong>Employee:</strong> <a href="{{ url('/employee/ID/' . $leave->user->phone_number)  }}" target="_blank"> {{ $leave->user->name }}</a> applied for total {{ $totalDays }} days leave<br>
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
                <strong>Application Start Date:</strong> {{ $leave->application_start_date->format('d M, Y l') }}<br>
                <strong>Application End Date:</strong> {{ $leave->application_end_date->format('d M, Y l') }}<br>
         
                <!-- Add more details as needed -->
            </li>
        @endforeach
    </ol>
@endif


   </div>
   </div>
  </div>
</div>







<div class="col-lg-12 col-lg-12"> 
<div class="card p-2">
   <div class="card">
   <h4 class="card-header" style="font-size: 1.5rem;"><i class="ion ion-clock mr-1"></i> Upcoming leaves</h4>

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

                <strong>Application Start Date:</strong> {{ $leave->application_start_date->format('d M, Y l') }}<br>
                <strong>Application End Date:</strong> {{ $leave->application_end_date->format('d M, Y l') }}<br>
         
                <!-- Add more details as needed -->
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
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  Notice Board
                </h3>
              </div>
          
       <div class="card-body" style="max-height: 350px; overflow-y: scroll;">
               
       <ul class="todo-list" data-widget="todo-list">
        
@if(count($all_notice) > 0)
@foreach ($all_notice as $all_notices)
    <li>
        <span class="handle"><i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i></span>
        @if(file_exists(public_path('assets/notice/' . $all_notices->notice_file)))
            <a href="{{ url('assets/notice/' . $all_notices->notice_file) }}" target="_blank">
        @endif
            <span class="text">
                <span class="badge badge badge-primary">{{ $all_notices->notice_type }}</span> {{ $all_notices->notice_title }}
            </span>
            <small class="badge badge-danger"><i class="far fa-clock"></i> {{ $all_notices->created_at->diffForHumans() }}</small>
            @if(file_exists(public_path('assets/notice/' . $all_notices->notice_file)))
                <div class="tools"><i class="fas fa-eye"></i></div>
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
   <div class="card-header">
     <h3 class="card-title">
       <i class="ion ion-clipboard mr-1"></i>
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
