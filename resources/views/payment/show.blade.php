@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <a href="{{route('payment.subscribe')}}"><button >Subscription</button></a>
                <a href="{{route('payment.ecommerceIndex')}}"><button>Ecommerce</button></a>
                <form accept-charset="UTF-8" action="{{route('payment.create')}}" class="require-validation"
                      data-cc-on-file="false"
                      data-stripe-publishable-key="test_public_key"
                      id="payment-form" method="post">
                    @csrf
                    <input id="stripeToken" name="stripeToken" class='form-control' type='hidden' value="">
                    <div class='col-xs-12 form-group required'>
                        <label class='control-label'>Name on Card</label>
                        <input id="name" name="name" data-field-name="Name on card" class='form-control' size='4' type='text' onkeyup="validation(this)" required>
                        <span class="text-danger error-text"></span>
                    </div>
                    <div class='col-xs-12 form-group card required'>
                        <label class='control-label'>Amount</label>
                        <input id="amount" name="amount" data-field-name="Amount" autocomplete='off' onkeyup="validation(this)"  class='form-control card-number' size='20'
                               type='text' required>
                        <span class="text-danger error-text"></span>
                    </div>
                    <div class="col-12 mb-3">
                        <div id="card-element"
                             style="border: solid #ced4da 1px;line-height: 1.5;padding: 1.5%;border-radius: 0.5rem;"></div>
                    </div>
                    <div id="card-errors" role="alert"></div>
                    <div class='form-row'>
                        <div class='form-group'>
                            <button class='form-control btn btn-primary submit-button' id="submit-button"
                                    data-secret="{{$intent->client_secret}}" type='submit' style="margin-top: 10px;">Pay
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

        const form = document.getElementById('payment-form');
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
                        url: $('#payment-form').attr('action'),
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        data: new FormData($('#payment-form')[0]),
                        success: function (response) {
                            if (response.success) {
                                window.location = '{{route('payment.index')}}';
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
                ajaxRequest.setForm('#payment-form');
                ajaxRequest.send();

            }
        });

        function validation(object, status) {
            var input = $(object);
            if(input.prop('required') && !input.val())
            {
                input.addClass('is-invalid');
                input.addClass('invalid');
                status = false;
                input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
            }else if(input.val()){
                var input_id = input.attr('id');
                if(input_id === 'name'){
                    status = validate.first_name(input, status);
                }
                else if(input_id === 'amount'){
                    status = validate.salary(input,status);
                }else{
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
            }else{
                input.siblings('span.select2-container--default').removeClass('invalid-select');
                input.removeClass('is-invalid');
            }
            return status;
        }

    </script>
@endpush

