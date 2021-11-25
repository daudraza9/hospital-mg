@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Please Add Product</h3>
                        <div class="card" id="form-style">
                            <p class="blue-text">Please Enter details for new product<br>
                            <form enctype="multipart/form-data" class="form-card" id="product-form"
                                action="{{route('product.storeProduct')}}"
                                  method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name</label>
                                        <input type="text" id="name" name="name"
                                               placeholder="Enter Role name" data-field-name="Role-name"

                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Discription</label>
                                        <input type="text" id="discription" name="discription"
                                               placeholder="Enter discription name" data-field-name="discription-name"

                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Price</label>
                                        <input type="text" id="price" name="price"
                                               placeholder="Enter Price" data-field-name="Price-name"

                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Picture</label>
                                        <input type="file" id="image" name="image"
                                               placeholder="Select Picture" data-field-name="Picture"

                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="saveProduct('product-form');">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>

        function saveProduct(form_id) {

        {{--    var status = true;--}}
        {{--    $("form#" + form_id + " :input").each(function () {--}}
        {{--        status = validation(this, status);--}}
        {{--    });--}}
        //     if (status === true) {
                $.ajax({
                    type: 'POST',
                    url: $('#product-form').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#product-form')[0]),
                    success: function (response) {
                        if (response.success) {
                            window.location = '{{route('product.indexs')}}';
                        } else {
                            if (response.success == NULL) {
                                printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                            } else {
                                printErrorMsg([response.message]);
                            }
                        }
                    }
                });
        {{--    }else{--}}
        {{--        return status;--}}
        {{--    }--}}

        }


    </script>
@endpush
