<?php

namespace App\Http\Controllers;

use App\Order;
use App\Charges;
use Carbon\Carbon;
use App\OrderSummary;
use App\SpecialOrder;
use App\Mail\OrderReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private function orderId(){
        $year= Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('j');
        $rand = substr(sha1(mt_rand()), 17, 6);
        $orderId = $year.$month.$day.$rand;

        return $orderId;
    }

    public function sendSpecialOrder(Request $request)
    {
        // print_r($request->order);
        $this->validate($request, [
            'order.name' => 'required|max:50',
            'order.details' => 'required|max:300',
            'order.units' => 'required|max:20',
            'order.request' => 'max:140'
        ]);

        $year= Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('j');
        $rand = substr(sha1(mt_rand()), 17, 6);
        $orderId = '99'.$day.$month.$year.$rand;

        $order = new SpecialOrder;
        $order->order_no = $orderId;
        $order->user_id = 10;
        $order->request = $request->order['name'];
        $order->details = $request->order['details'];
        $order->units = $request->order['units'];
        $order->del_date = $request->order['delDate'];
        $order->del_time = $request->order['delTime'];
        $order->special_req = $request->order['special_req'];
        $order->save();

        //send an email to user and blema
        $user = Auth::user();
        // Mail::to($user->email)->send(new OrderReceived($user, $order));

        return response()->json($order, 200);
    }

    public function payOnDelivery(Request $request)
    {
        $orders = $request->orders;
        $services = $request->services;
        $user = Auth::user();

        $year= Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('j');
        $rand = substr(sha1(mt_rand()), 17, 6);
        $orderId = $year.$month.$day.$rand;

        for($i=0; $i < count($orders); $i++){
           $order = new Order;
           $order->order_id = $orderId;
           $order->user_id = 1;
           $order->product_id = $orders[$i]['product']['id'];
           $order->units = $orders[$i]['units'];

           $order->save();
        }

        for($i=0; $i < count($services); $i++){
            $order = new Order;
            $order->order_id = $orderId;
            $order->user_id = Auth::id();
            $order->service_id = $services[$i]['id'];
            $order->units = $services[$i]['units'];

            $order->save();
         }

        // //create order summary
        $this->validate($request, [
            'message' => 'max:100'
        ]);

        $summary = new OrderSummary;
        $summary->order_id = $orderId;
        $summary->user_id =  Auth::id();
        $summary->item_count = count($orders);
        $summary->services_count = count($services);
        $summary->value = $request->total;
        $summary->message = $request->message;
        $summary->order_status = 'Received';
        $summary->pymt_mode = 'POD';
        $summary->pymt_status = 0;
        $summary->save();

        //store charges
        $charges = new Charges;
        $charges->amount = $request->charges;
        $charges->user_id = 1;
        $charges->status = 0;
        $charges->order_id = $orderId;

        $charges->save();

        return response()->json($summary, 200);
    }

    public function sendOrderReceivedEmails(Request $request)
    {
        $order = $request->order;
        $user = Auth::user();

        Mail::to($user->email)->send(new OrderReceived($user, $order));
        Mail::to('blemadeliveries@gmail.com')->send(new OrderReceived($user, $order));


    }
}
