 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('/admin') }}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Employee Desk</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      @if(auth()->check())
        <div class="image">
          <img src="{{ asset('assets/users/'. auth()->user()->profile_pic) }}" style="height:55px; width:55px;" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
         <a href="{{ url('employee/ID/'. auth()->user()->phone_number) }}" class="d-block mt-2" target="_blank">{{ auth()->user()->name }}</a>
        </div>
        @endif
      </div>





    
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>


        
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @auth
          @if(auth()->user()->hasRole(['admin', 'HR', 'Superadmin', 'Root']))     
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>

          </li>


          <li class="nav-item">
            <a href="{{ url('admin/users') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Employer
              </p>
            </a>
          </li>


      <li class="nav-item">
            <a href="{{ url('admin/department') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Department
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/sms/createSMS') }}" class="nav-link">
              <i class="nav-icon fas fa-mobile"></i>
              <p>
               Send SMS
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('admin/addRole') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               Add Admin Role
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('/admin/activitylogs') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
               Activity Logs
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          @elseif(auth()->user()->hasRole('user'))
          @endif

          <!-- Start Code here for Other Auth -->
          <li class="nav-item">
            <a href="{{ url('') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i> <p>Leave Application</p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="{{ url('') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i> <p>Attendance</p>
            </a>
          </li>
          
         
    <li class="nav-item">
     <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="nav-icon fas fa-sign-out-alt"></i> Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </li>

    
     @endauth
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>



