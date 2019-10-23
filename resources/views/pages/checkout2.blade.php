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

                        <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                            <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="orderID" value="{{ $order }}">
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <!-- <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}} -->
                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}
                                <div class="text-center">
                                    <button class="btn btn-primary btn-lg my-4" type="submit" value="Pay Now!">
                                        <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                            <!-- var_dump() -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection

<script>

        var amount = window.localStorage.getItem('grandTotal')

        console.log(amount)

</script>


