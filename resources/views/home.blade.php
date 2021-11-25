@extends('auth.layouts.auth-master')

@section('content')
    <div class="app-content content content-vcenter bg-image2">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-lg-4 col-md-6 col-10 box-shadow-2 p-0">

                                <button class="btn btn-lg btn-glow btn-bg-gradient-x-purple-blue"
                                        style="margin-bottom: 2%;"><i class="ft ft-arrow-left"></i> Dashboard
                                </button>
                            </a>
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0">

                                    <div class="font-large-1  text-center">
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <h1>Welcome to Hospital Management</h1>
                                    </div>

{{--                                    <a href="{{route('login')}}" <button class="btn btn-primary">Login</button></a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
