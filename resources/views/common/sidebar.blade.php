<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">NBCC {{Auth::user()->name}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
 <!-- Nav Item - Utilities Collapse Menu -->
 @role('admin')
 <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
        aria-expanded="true" aria-controls="collapseStudents">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Manage Students </span>
    </a>
    <div id="collapseStudents" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Students </h6>
         
          

           
            <a href="{{route('studentList')}}" class="collapse-item {{ Route::is('studentList') ? '' : '' }}">Student List</a>
            <a href="{{route('paymentVerify')}}" class="collapse-item {{ Route::is('paymentVerify') ? '' : '' }}">Verify Student Payment</a>
          
        </div>
    </div>
</li>
@endrole
@role('admin')
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Student Corner</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Student Corner:</h6>
       
            <a href="{{route('post')}}" class="collapse-item {{ Route::is('post') ? '' : '' }}">Letest Post</a>
            <a href="{{route('student_assets')}}" class="collapse-item {{ Route::is('student_assets') ? '' : '' }}">Student Assets</a>

           
          
        </div>
    </div>
</li>

@endrole
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Masters</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master List:</h6>
              
                @role('admin')
                <a href="{{route('country')}}" class="collapse-item {{ Route::is('country') ? '' : '' }}">Country Master</a>
                <a href="{{route('state')}}" class="collapse-item {{ Route::is('state') ? '' : '' }}">State Master</a>
                <a href="{{route('city')}}" class="collapse-item {{ Route::is('city') ? '' : '' }}">City Master</a>
                <a href="{{route('course')}}" class="collapse-item {{ Route::is('course') ? '' : '' }}">Course Master</a>
                <a href="{{route('class')}}" class="collapse-item {{ Route::is('class') ? '' : '' }}">Class Master</a>
                

                @else
                <a href="{{route('profile')}}" class="collapse-item {{ Route::is('profile') ? '' : '' }}">Profile</a>
                @endrole
               
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    @role('admin')
    <div class="sidebar-heading">
        Admin Power
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Role & Permission</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               
                <a href="{{route('role')}}" class="collapse-item {{ Route::is('role') ? '' : '' }}">Manage Role</a>
              
            </div>
        </div>
    </li>
   
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
            aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-folder"></i>
            <span>User</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                
                <a href="{{route('user')}}" class="collapse-item {{ Route::is('user') ? '' : '' }}">Add User </a>
                <a href="{{route('userList')}}" class="collapse-item {{ Route::is('userList') ? '' : '' }}">User List</a>
              
            </div>
        </div>
    </li>
    @endrole
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>