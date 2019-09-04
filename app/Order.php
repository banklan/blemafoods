<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'user_id', 'product_id', 'service_id', 'units'];


    public function order_summary()
    {
        return $this->belongsTo('App\OrderSummary');
    }
}
