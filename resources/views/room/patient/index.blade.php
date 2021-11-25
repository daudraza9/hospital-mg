@extends('layouts.master')
@section('content')
    @include('room.patient.add')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <button class="float-right" onclick="addRoomPatientModal();">Adding Room to patient </button>
                @include('room.patient.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')
    <script>

    </script>
@endpush

