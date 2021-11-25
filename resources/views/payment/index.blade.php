@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                    <a href="{{route('product.addProduct')}}"> <button class="float-right">Add Product</button></a>
                    <a href="{{route('payment.ecommerceIndex')}}"><button>Ecommerce</button></a>
                    @include('payment.table')
            </div>
        </main>

    </div>

@endsection

@push('scripts')

@endpush

