@include('layouts.top-nav')
<div id="layoutSidenav_nav" >
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="{{route('index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-home"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{route('department.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-stream"></i></div>
                    Departments
                </a>
                <a class="nav-link" href="{{route('doctor.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-md"></i></div>
                    Manage Doctors
                </a>
                <a class="nav-link" href="{{route('patient.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-user"></i></div>
                    Manage Patients
                </a>
                <a class="nav-link" href="{{route('nurse.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-nurse"></i></div>
                    Manage Nurses
                </a>
                <a class="nav-link" href="{{route('staff.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-friends"></i></div>
                  Manage Staff
                </a>
                <a class="nav-link" href="{{route('room.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-bed"></i></div>
                   Manage Rooms
                </a>
                <a class="nav-link" href="{{route('appointment.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-calendar"></i></div>
                    Manage Appointment                </a>

                <a class="nav-link" href="{{route('role.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Roles  </a>

{{--                @can(permissions['addUser'])--}}
                <a class="nav-link" href="{{route('user.add')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-user"></i></div>
                    Add User
                </a>
{{--                @endcan--}}
                <a class="nav-link" href="{{route('pdf.index')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Pdf  </a>
                <a class="nav-link" href="{{route('product.indexs')}}">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Product  </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: {{Auth::user()->name}}</div>
        </div>
    </nav>
</div>
