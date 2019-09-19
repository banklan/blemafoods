<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    protected $with = ['sender', 'receiver'];

    protected $appends = ['self_owned', 'sender_name', 'time'];


    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function getSelfOwnedAttribute($value)
    {
        if($this->sender_id === Auth::id()){
            return true;
        }
        return false;
    }

    public function getSenderNameAttribute($value)
    {
        if($this->sender_id === Auth::id()){
            return 'Me';
        }else{
            return 'Blema';
        }
    }

    public function getTimeAttribute($value)
    {
        $created = Carbon::parse($this->created_at)->diffForHumans();
        return $created;
    }

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = ucfirst($value);
    }


}
