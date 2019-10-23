<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'user_id', 'product_id', 'service_id', 'units'];

    protected $with = ['product'];


    public function order_summary()
    {
        return $this->belongsTo('App\OrderSummary');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function service(){
        return $this->belongsTo('App\Service');
    }
}
