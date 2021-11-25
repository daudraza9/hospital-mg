@extends('layouts.master')
@section('content')
@include('doctors.patient.add')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <button class="float-right" onclick="addPatientModal();">Adding doctors of patient </button>
                    @include('doctors.patient.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush

