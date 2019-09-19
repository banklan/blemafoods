<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'service_id', 'name', 'price', 'unit', 'size', 'color', 'picture'];

    protected $with = ['category', 'service'];

    protected $appends = ['slug'];


    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function service()
    {
        return $this->hasMany('App\Service');
    }

    public function getSlugAttribute($value)
    {
        $slug = str_slug($this->name);

        return $slug;
    }

}
