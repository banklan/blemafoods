<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $fillable = ['order_id', 'amount', 'user_id', 'status'];

    protected $table = 'charges';

    protected $with = ['user'];

    protected $appends = ['date', 'charges_status'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::parse($this->created_at)->toFormattedDateString();
        return $date;
    }

    public function getChargesStatusAttribute($value)
    {
        if($this->status == 0){
            return 'NY Earned';
        }else{
            return 'Earned';
        }
    }
}
