<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $fillable = ['order_id', 'amount', 'user_id', 'status'];

    protected $table = 'charges';
}
