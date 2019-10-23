<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SpecialOrder extends Model
{
    protected $fillable = ['order_no', 'user_id', 'request', 'details', 'units', 'del_date', 'del_time', 'special_req'];

    protected $with = ['user'];

    protected $appends = ['date', 'time', 'status'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::parse($this->created_at)->toFormattedDateString();
        return $date;
    }

    public function getTimeAttribute($value)
    {
        $time = Carbon::parse($this->created_at)->format('H:ia');
        return $time;
    }

    public function getStatusAttribute($value)
    {
        if($this->order_status === '1'){
            return 'Order has been received.';
        }

        if($this->order_status === '2'){
            return 'Order is been processed.';
        }

        if($this->order_status === '3'){
            return 'Order is on transit to you.';
        }

        if($this->order_status === '7'){
            return 'Order Delivered.';
        }
    }
}
