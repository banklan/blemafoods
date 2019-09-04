@section('content')
    <h5>Dear {{ $user->name }}</h5><br>
    <h5>We receive your special order with order no {{ $order->order_no }}.</h5>
    <h5>Your order is been attended to and will be dispatched as soon as possible.</h5>
    <h5>We shall contact you by email <strong>{{ $user->email }}</strong> or through your mobile number <strong>{{ $user->phone }}</strong> should we have any clarifications.</h5>
    <h5>Once we are in your neighbourhood, our deliverer will call to inform you.</h5>
    <h5>You can track your order when you sign in into <a href="#">www.blema.com.ng</a>, on your dashboard, click on the order.</h5>
    <h5>Thank you for making us a part of your life.</h5><br>
    <h5>Blema</h5>
    <h5><a href="#">www.blema.com.ng</a></h5>
@endsection
