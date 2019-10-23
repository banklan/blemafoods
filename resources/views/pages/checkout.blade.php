@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h4 class="text-center">Confirmation of order</h4>
                    </div>
                    <div class="card-body">
                        <h5>Dear {{ $user }}, the total cost of your order is <strong>&#8358;{{ $amount / 100}}</strong>.</h5>

                        <!-- <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="orderID" value="{{ $order }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                            <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg my-4" type="submit" value="Pay Now!">
                                    <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                </button>
                            </div>
                        </form> -->
                        <form >
                            <script src="https://js.paystack.co/v1/inline.js"></script>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg my-4" type="button" onclick="payWithPaystack()">
                                    <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection

<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_test_d03620aa3577ca9b6de2f4bfd1a26e3e8991b11c',
      email: 'flexinalbo14@gmail.com',
      amount: 250000,
      currency: "NGN",
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
         ]
      },
      callback: function(response){
          alert('success. transaction ref is ' + response.reference);
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>

