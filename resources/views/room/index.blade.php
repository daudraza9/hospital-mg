@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <a href="{{route('room.create')}}"> <button class="float-right">Add Room</button></a>
                hi this is Room index page !!!!!!!1
                @include('room.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush

