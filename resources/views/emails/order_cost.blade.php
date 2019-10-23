
    <h3>Dear {{ $user->name }}</h3><br>
    <h4>We receive your special order with order no {{ $order->order_no }}.</h4>
    <h4>Your order is been attended to and will be dispatched as soon as possible.</h4>
    <h4>The cost of your special order No {{ $order->order_no }} is &#8358;{{ $order->cost }}.</h4>
    <h4>Should in case you are no longer interested in this order kindly reply this email or call us back immediately.</h4>
    <h4>Should there be any need for clarifications, we shall contact you by email <strong>{{ $user->email }}</strong> or through your phone number <strong>{{ $user->phone }}</strong></h4>
    <h4>Once our bearers are in your neighbourhood, we will call to inform you.</h4>
    <h4>You can track your order when you sign in into <a href="#">www.blema.com.ng</a>, on your dashboard, click on the Order link.</h5>
    <h4>Thank you for making us a part of your life.</h4><br>
    <h4>Blema Deliveries</h4>
    <p><a href="#">www.blema.com.ng</a></p>
