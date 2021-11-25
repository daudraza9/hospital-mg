@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-3">
                <a href="{{route('patient.create')}}"> <button class="float-right mb-3">Add paitent</button></a>

@include('patient.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')
<script>
    $(window).load(function()
    {
        $("#preloaders").fadeOut(2000);
    });
</script>
@endpush

