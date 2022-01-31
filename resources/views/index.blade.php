@extends('layouts.master')
@section('title','hospital')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
{{--                <h1 class="mt-4">Dashboardssssssssssssss</h1>--}}
                <a href="{{route('exportCsv')}}"><button>Export CSV</button></a>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Total Doctors = {{$count}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('doctor.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Total Nurses = {{$nursecount}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('nurse.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Total Patient = {{$patientCount}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('patient.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Total Staff = {{$staffCount}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="{{route('staff.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt-0">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">Total Departments = {{$departmentCount}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white" href="{{route('department.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt-0">
                        <div class="card bg-info text-white">
                            <div class="card-body">Check Appointments = {{$appointmentCount}}</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white" href="{{route('appointment.index')}}">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

@endsection
@push('scripts')
<script>

</script>
@endpush
