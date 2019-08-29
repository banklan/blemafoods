<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    protected $appends = ['slug'];


    public function product()
    {
        return $this->hasMany('App\Product');
    }

    public function getSlugAttribute($value)
    {
        $slug = str_slug($this->name);

        return $slug;
    }
}
