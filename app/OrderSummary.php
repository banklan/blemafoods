<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSummary extends Model
{
    protected $fillable = ['order_id', 'user_id', 'item_count', 'services_counts', 'value', 'message', 'order_status', 'pymt_mode', 'pymt_status'];

    protected $table = 'order_summaries';

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = ucfirst($value);
    }
}
