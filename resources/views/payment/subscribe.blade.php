@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1>Subscription Data</h1>
                <form class="require-validation"
                      action="{{route('payment.Addsubscription')}}"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="test_public_key"
                      id="subscription-form" method="post">
                    @csrf
                    <input id="stripeToken" name="stripeToken" class='form-control' type='hidden' value="">
                    <div class='required'>
                        <label class='control-label'>Name on Card</label>
                        <input id="name" name="name" data-field-name="Name on card" class='form-control' size='4'
                               type='text' onkeyup="validation(this)" required>
                        <span class="text-danger error-text"></span>
                    </div>
                    <div class='mt-4'>

                        <input id="standard" name="plan" value="price_1JsNO8IDC9xLtD8VL4xTHEUw" checked type='radio'>
                        <label class='control-label' for="standard">Standard - $10 / month</label><br>
                        <input id="premium" name="plan" value="price_1JsNO8IDC9xLtD8VJFGl1Ikd" type='radio'>
                        <label class='control-label' for="premium">Premium - $20 / month</label><br>

                        <span class="text-danger error-text"></span>
                    </div>

                    <div class="col-12 mb-3">
                        <div id="card-element"
                             style="border: solid #ced4da 1px;line-height: 1.5;padding: 1.5%;border-radius: 0.5rem;"></div>
                    </div>
                    <div id="card-errors" role="alert"></div>
                    <div class='form-row'>
                        <div class='form-group'>
                            <button class='btn btn-primary submit-button' id="submit-button"
                                    data-secret="{{$intent->client_secret}}" type='submit' style="margin-top: 10px;">
                                Subscribe Now
                            </button>
                        </div>
                    </div>

                </form>
                @if((Session::has('success-message')))
                    <div class="alert alert-success col-md-12">
                        {{Session::get('success-message')}}
                    </div>
                @endif
                @if((Session::has('fail-message')))
                    <div class="alert alert-danger col-md-12">
                        {{Session::get('fail-message')}}
                    </div>
                @endif
            </div>
        </main>

    </div>

@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('subscription-form');
        const cardBtn = document.getElementById('submit-button');
        const cardHolderName = document.getElementById('name');

        let paymentIntentSet = false;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (paymentIntentSet === false) {
                cardBtn.disabled = true;
                const {setupIntent, error} = await stripe.confirmCardSetup(
                    cardBtn.dataset.secret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );
                if (error) {
                    printErrorMsg([error.message]);
                    cardBtn.disabled = false;
                } else {
                    paymentIntentSet = true;
                    $('#stripeToken').val(setupIntent.payment_method);
                    $.ajax({
                        type: 'POST',
                        url: $('#subscription-form').attr('action'),
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        data: new FormData($('#subscription-form')[0]),
                        success: function (response) {
                            if (response.success) {
                                window.location = '{{route('payment.subscribe')}}';
                            } else {
                                if (response.success == NULL) {
                                    printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                                } else {
                                    printErrorMsg([response.message]);
                                }
                            }
                        }
                    });
                }
            } else {
                cardBtn.disabled = true;
                ajaxRequest.setForm('#subscription-form');
                ajaxRequest.send();
            }
        });


    </script>
@endpush

