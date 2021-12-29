@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                    <a href="{{route('role.create')}}"> <button class="float-right">Add Role</button></a>

                hi this is Room index page !!!!!!!1
{{--                @include('role.table')--}}

            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush

