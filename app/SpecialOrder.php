<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOrder extends Model
{
    protected $fillable = ['order_no', 'user_id', 'request', 'details', 'units', 'del_date', 'del_time', 'special_req'];

    protected $with = [];

    protected $appends = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
