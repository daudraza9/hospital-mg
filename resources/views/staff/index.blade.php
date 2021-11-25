@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <a href="{{route('staff.create')}}"> <button class="float-right">Add Staff</button></a>

                @include('staff.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush
