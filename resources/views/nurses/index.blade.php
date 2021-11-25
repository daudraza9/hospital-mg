@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <a href="{{route('nurse.create')}}"> <button class="float-right">Add Nurse</button></a>
                @include('nurses.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush
