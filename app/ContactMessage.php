<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message'];

    protected $appends = ['sent', 'slug'];

    protected $dates = ['created_at'];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setTopicAttribute($value)
    {
        $this->attributes['topic'] = ucfirst($value);
    }

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = ucfirst($value);
    }

    public function getSentAttribute($value)
    {
        $date = $this->created_at->format('d/m/Y'.' - '. 'H:i a');
        return $date;
    }

    public function getSlugAttribute($value)
    {
        $slug = str_slug($this->name);

        return $slug;
    }
}
