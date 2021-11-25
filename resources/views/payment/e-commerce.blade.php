@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <main>

            <x-alert message="Welcome To CodeCamp"></x-alert>

            <div class="container-fluid px-4">
                <div class="row">
                @foreach($products as $product)

                <div class="card mt-3 margin-product" style="width: 18rem;">
                    <img src="{{$product->getFirstMediaUrl('image','thumb')}}" class="card-img-top" alt="..." width="100">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->discription}}</p>
                        <p class="card-text" id="name"><h5>{{$product->price}}</h5></p>
                        <a class="btn btn-primary" href="{{route('product.add.to.cart',['id'=>$product->id])}}">Add to Cart</a>
                    </div>
                </div>

                @endforeach
                    {{--Pagination--}}
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
 <span>

 </span>
        </main>


@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        {{--const stripe = Stripe('{{ env('STRIPE_KEY') }}');--}}

        {{--const elements = stripe.elements();--}}
        {{--const cardElement = elements.create('card');--}}
        {{--cardElement.mount('#card-element');--}}

        {{--const form = document.getElementById('payment-form');--}}
        {{--const cardBtn = document.getElementById('submit-button');--}}
        {{--const cardHolderName = document.getElementById('name');--}}

        {{--let paymentIntentSet = false;--}}

        {{--form.addEventListener('submit', async (e) => {--}}
        {{--    e.preventDefault();--}}
        {{--    if (paymentIntentSet === false) {--}}
        {{--        cardBtn.disabled = true;--}}
        {{--        const {setupIntent, error} = await stripe.confirmCardSetup(--}}
        {{--            cardBtn.dataset.secret, {--}}
        {{--                payment_method: {--}}
        {{--                    card: cardElement,--}}
        {{--                    billing_details: {--}}
        {{--                        name: cardHolderName.value--}}
        {{--                    }--}}
        {{--                }--}}
        {{--            }--}}
        {{--        );--}}
        {{--        if (error) {--}}
        {{--            printErrorMsg([error.message]);--}}
        {{--            cardBtn.disabled = false;--}}
        {{--        } else {--}}
        {{--            paymentIntentSet = true;--}}
        {{--            $('#stripeToken').val(setupIntent.payment_method);--}}
        {{--            $.ajax({--}}
        {{--                type: 'POST',--}}
        {{--                url: $('#payment-form').attr('action'),--}}
        {{--                dataType: "json",--}}
        {{--                processData: false,--}}
        {{--                contentType: false,--}}
        {{--                data: new FormData($('#payment-form')[0]),--}}
        {{--                success: function (response) {--}}
        {{--                    if (response.success) {--}}
        {{--                        window.location = '{{route('payment.ecommerceIndex')}}';--}}
        {{--                    } else {--}}
        {{--                        if (response.success == NULL) {--}}
        {{--                            printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);--}}
        {{--                        } else {--}}
        {{--                            printErrorMsg([response.message]);--}}
        {{--                        }--}}
        {{--                    }--}}
        {{--                }--}}
        {{--            });--}}
        {{--        }--}}
        {{--    } else {--}}
        {{--        cardBtn.disabled = true;--}}
        {{--        ajaxRequest.setForm('#payment-form');--}}
        {{--        ajaxRequest.send();--}}
        {{--    }--}}
        {{--});--}}

    </script>
@endpush

