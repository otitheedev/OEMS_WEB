<style>
  /* Hide the default scrollbar */
.dropdown-menu::-webkit-scrollbar {
    display: none;
}

/* Define custom scrollbar styles */
.dropdown-menu {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer/Edge */
}

/* Custom scrollbar styles for WebKit-based browsers */
.dropdown-menu::-webkit-scrollbar {
    width: 10px; /* Adjust as needed */
}

.dropdown-menu::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track color */
}

.dropdown-menu::-webkit-scrollbar-thumb {
    background: #888; /* Thumb color */
    border-radius: 5px; /* Thumb border radius */
}

</style>

<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/admin') }}" class="nav-link">Home</a>
      </li>
   <!--    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->


      <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

<!--        
        <ul>
           @auth
         Diaplay Content For All Auth User
          @if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))
            <li class="nav-item">
            ['admin', 'HR', 'Superadmin', 'Root']
            </li>
            @elseif(auth()->user()->hasRole('user'))
            <li class="nav-item">
             Content For USER
            </li>
            @endif
            @endauth
          </ul>
  -->


    <!-- 
    <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->




@auth
@if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))     

<!-- Unread Notifications Dropdown Menu Start -->
@if(count($notifications) > 0)
<li class="nav-item dropdown" id="reloadMAN">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-bell"></i>
        <span class="badge badge-danger navbar-badge">{{ count($notifications) }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="overflow-y: auto; max-height: calc(80vh - 56px);">
        <span class="dropdown-item dropdown-header" style="position: sticky; top: 0; background-color: #fff; z-index: 1000;">{{ count($notifications) }} Unread Notifications</span>
        <div class="dropdown-divider"></div>

        @foreach($notifications as $notification)
        <a href="#" onclick="openNotificationPopup('{{ $notification->id }}')">
            <div class="row p-2">
                <div class="col-3">
                    @php
                    $user = \App\Models\reg_user::find($notification->user_id);
                    @endphp
                    <img src="{{ url('assets/users/' . ($user->profile_pic ? $user->profile_pic : '')) }}" style="height:63px; width:63px;" class="img-circle">
                </div>
                <div class="col-9">
                    <span class="text-primary">{{ $notification->message }}</span> <br>
                    <span class="text-muted"> {{ $notification->created_at->diffForHumans() }} </span>
                </div>
            </div>
        </a>
        <hr>
        @endforeach

        <div class="dropdown-divider"></div>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer" style="position: sticky; bottom: 0; background-color: #fff; z-index: 1000;">See All Unread Notifications</a>
    </div>
</li>
@endif
<!-- Unread Notifications Dropdown End -->




<!-- Read Notification Start-->
      @if(count($all_notifications) > 0)
      <li class="nav-item dropdown" id="reloadMANREAD">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <!-- <i class="far fa-comments"></i> -->
          <i class="far fa-bell	" aria-hidden="true"></i>

          <span class="badge badge-warning navbar-badge">{{ count($all_notifications) }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="overflow-y: auto; max-height: calc(80vh - 56px);">
          <span class="dropdown-item dropdown-header" style="position: sticky; top: 0; background-color: #fff; z-index: 1000;">{{ count($all_notifications) }} Read Notifications</span>
         
          @foreach($all_notifications as $pnotification)
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" style="white-space: normal;">
            <i class="fas fa-check mr-2"></i> {{ $pnotification->message }}
            <span class="float-right text-muted text-sm">{{ $pnotification->created_at->diffForHumans() }}</span>
          </a>
          @endforeach

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer" style="position: sticky; bottom: 0; background-color: #fff; z-index: 1000;">See All Read Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
<!-- Read Notification End-->

<aside class="control-sidebar control-sidebar-dark" style="overflow-y: auto; max-height: calc(100vh - 56px);">
  <!-- Control sidebar content goes here -->
  <div class="p-3">
      @foreach($all_notifications as $pnotification)
          <a href="#" class="dropdown-item" style="white-space: normal;">
            <i class="fas fa-check-double mr-2"></i> {{ $pnotification->message }}
            <span class="float-right text-muted text-sm">{{ $pnotification->created_at->diffForHumans() }}</span>
          </a>
          @endforeach
  </div>

</aside>
@endif
@endif
@endauth


    </ul>



</nav>



<!-- JavaScript to handle opening popup and loading notification content -->
<script>
    function openNotificationPopup(notificationId) {
        // Display a confirmation dialog
        var confirmed = confirm("Are you sure you want to mark this notification as read?");
        
        // If the user confirms the action
        if (confirmed) {
            // Make an AJAX request to fetch the notification content
            $.ajax({
                url: '{{ route('mark-as-read', ['notification' => ':notificationId']) }}'.replace(':notificationId', notificationId),
                method: 'GET',
                success: function(response) {
                    // Reload specific elements after successful AJAX request
                    $('#reloadMAN').load(document.URL +  ' #reloadMAN');
                    $('#reloadMANREAD').load(document.URL +  ' #reloadMANREAD');
                    //$('#navLoad').load(document.URL +  ' #navLoad');
                },
                error: function(xhr) {
                    // Handle errors
                    console.error('Error:', xhr);
                }
            });
        }
    }
</script>

