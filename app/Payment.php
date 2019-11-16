<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'order_id', 'amount', 'trx_ref', 'trx_status', 'trx_msg', 'trx_trans'];

    protected $with = ['user'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
