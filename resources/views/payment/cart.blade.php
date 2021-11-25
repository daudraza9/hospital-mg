@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:22%" class="text-center">Subtotal</th>
                    <th style="width:10%">Remove</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0 @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php $total += (float)$details['price'] * (float)$details['quantity'] @endphp
                        <tr data-id="{{ $id }}">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-3 hidden-xs">
                                        <img src="{{ $details['image'] }}" width="100"
                                                                         height="100" class="img-responsive"/>
                                    </div>
                                    <div class="col-sm-9">
                                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">${{ $details['price'] }}</td>
                            <td data-th="Quantity">
                                <input type="number" value="{{ $details['quantity'] }}"
                                       class="form-control quantity update-cart"/>
                            </td>
                            <td data-th="Subtotal" class="text-center">
                                ${{ (float)$details['price'] * (float)$details['quantity'] }}</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5"><h3 class="price"><strong>Total ${{ $total }}</strong></h3></td>
                </tr>
                <tr>
                    <td colspan="5" class="price">
                        <button class="btn btn-primary" type="button" data-toggle="collapse"
                                data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Continue Payment
                        </button>
                    </td>
                </tr>
                </tfoot>
            </table>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <form action="{{route('product.madePayment')}}" class="require-validation"
                          data-cc-on-file="false"
                          data-stripe-publishable-key="test_public_key"
                          id="payment-form" method="post">
                        @csrf
                        <input id="stripeToken" name="stripeToken" class='form-control' type='hidden' value="">
                        <div class="mb-3">
                            <label>Card Holder name</label>
                        <input id="name" name="name" class="" type="text" placeholder="Enter Name">
                        </div>
                        <input id="amount" name="amount" class='form-control' type='hidden' value="{{ $total }}">
                        <div class="col-12 mb-3">
                            <div id="card-element"
                                 style="border: solid #ced4da 1px;line-height: 1.5;padding: 1.5%;border-radius: 0.5rem;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="collapse">Close</button>
                            <button class='btn btn-primary submit-button' id="submit-button"
                                    data-secret="{{$intent->client_secret}}"  type='submit' style="margin-top: 10px;">
                                Pay Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>


    </div>


@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>

        $(document).ready(function () {
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
                                    window.location = '{{route('payment.ecommerceIndex')}}';
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
        });

        $(".update-cart").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('product.update.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('product.remove.from.cart') }}',
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endpush

