@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <!-- <h4 class="card-title">Checkout for Order Id {{ $orderid }} </h4> -->
                        <h4 class="card-title my-4">Total cost: <span style="color: blue" class="amount"> Amount here</span></h4>

                        <!-- <>Order {{ $orderid }} checkout for {{ $email }}</h1> -->
                        <!-- <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                            <div class="row" style="margin-bottom:40px;">
                                <div class="col-md-8 col-md-offset-2">
                                    <input type="hidden" name="email" value="otemuyiwa@gmail.com"> {{-- required --}}
                                    <input type="hidden" name="orderID" value="345">
                                    <input type="hidden" name="amount" value="800"> {{-- required in kobo --}}
                                    <input type="hidden" name="quantity" value="3">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                                    <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
                                        {{ csrf_field() }}
                                    <div class="justify-center">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit" value="Pay Now!">
                                            <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection


<script>
    // $(document).ready(function(){
    //     var amnt = localStorage.getItem('grandTotal')
    //     var req = $.ajax({
    //         type: "POST",
    //         url: 'http://localhost:3000/checkout',
    //         data: {
    //             amount: amt
    //         },
    //         dataType: html
    //     })

    //     req.done(function(msg){
    //         console.log(msg)
    //     })

    //     req.fail(function(msg){
    //         console.log(msg)
    //     })
    // })
</script>
