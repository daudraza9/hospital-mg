@extends('generate-pdf.layout')
@section('content')
    <h2 class="align-content-center">PDF Generator</h2>

    <p>Record the cost of paper products including
        printing and writing paper, stationery, paper
        pads or notebooks, printer or copier paper,
        computer printout paper, examination paper,
        industrial use paper, bleached and unbleached
        paperboard, packaging papers packaging
        materials and packaging supplies, personal
        paper products (e.g. facial tissues, toilet seat
        covers, paper towels, toilet tissue, paper
        napkins and tablecloths) cardboard, laminated
        papers, coated papers, and newsprint and offset
        papers.</p>

    <table class="table table-bordered">
        <thead>
        <tr class="dp-style">
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th width="25%">Image</th>
        </tr>
        </thead>
        <tbody>
        @foreach($user as $key => $user)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><img src="{{$user->getFirstMediaUrl('avatar','thumb')}}" width="100%"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
