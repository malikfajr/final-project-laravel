<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primatyKey = 'id';
    protected $guarded = [];
    public $incrementing = false;

    public function answer()
    {
      return $this->hasMany('App\Answer');
    }

    public function votes()
    {
      return $this->hasMany('App\Vote');
    }
}
