@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4 mt-2">

            <a href="{{route('appointment.create')}}"> <button class="float-right">Add Appointment</button></a>

            @include('appointment.table')
        </div>


    </div>

@endsection

@push('scripts')
@endpush
