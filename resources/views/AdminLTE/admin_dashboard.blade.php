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
                <h3>44</h3>

                <p>Total Feedback</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Total Task</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
    </section>


  
   <section class="content">
      <div class="container-fluid">
        <div class="card p-2">
  <h4 class="card header p-1"> Today Birthday! </h4>
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


  <!-- upcoming birthday next 7 days --> 
 
  <h4 class="card header p-1">Upcoming Birthday.. </h4>
  <ol type="1">
   @foreach ($upcomingBirthdays as $upcomingBirthday)
    <li><a href="{{ url('employee/ID/'. $upcomingBirthday->phone_number) }}" target="_blank">{{ $upcomingBirthday->name }}</a> birthday {{ $upcomingBirthday->DOB }}</li>
        
       @foreach ($upcomingBirthday->child_info as $child)
            <li> <a href="{{ url('employee/ID/'. $child->reg_user->phone_number) }}" target="_blank">{{ $child->reg_user->name }}'s</a> @if($child->child_gender == 'female') daughter @else son @endif {{ $child->child_name }}'s birthday {{ $child->child_birthday }}</li>
        @endforeach

    @endforeach
  </ol>


  </div> 
      </div> 
  
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-lg-6 col-6"> 
            
           <!-- TO DO List -->
           <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  To Do List
                </h3>

                <div class="card-tools">
                  <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                  </ul>
                </div>
              </div>
          
              <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                  <li>
          
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
             
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo1" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
               
                    <span class="text">Design a nice theme</span>
                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>

                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                      <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Make the theme responsive</span>
                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo3" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo4" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo5" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Check your messages and notifications</span>
                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo6" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Let theme shine like a star</span>
                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash-o"></i>
                    </div>
                  </li>
                </ul>
              </div>
  
              <div class="card-footer clearfix">
                <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
              </div>
            </div>
            <!-- /.card -->
          
          </div> 








    <div class="col-lg-6 col-6">
          <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Holiday Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              
<div class="card-body pt-0">

<!--The calendar -->
<!-- DateTimePicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<div id="holidaycalendar" style="width: 100%"></div></div></div>
            
<style>.date-highlighted {background-color: yellow !important; color: black !important;}</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#holidaycalendar').datetimepicker({
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











   <div class="col-lg-6 col-6">
          <div class="card bg-gradient-success">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar0.
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              
<div class="card-body pt-0">

<!--The calendar -->
<!-- DateTimePicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<div id="calendar" style="width: 100%"></div></div></div>
            
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




        
        </div>
</section>
  </div>
  
  @endsection
