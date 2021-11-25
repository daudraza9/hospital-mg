@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

         <a href="{{route('department.create')}}" class="btn-design mt-3"> <button class="float-right btn-style">Add Department</button></a>


            @include('department.table')
        </div>


    </div>

@endsection

@push('scripts')
@endpush
