@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

            <div class="container-fluid px-4">

        <a href="{{route('doctor.create')}}" id="btn-design"> <button>Add Doctors</button></a> <br>
                @include('doctors.table')


            </div>


    </div>

@endsection

@push('scripts')

@endpush
