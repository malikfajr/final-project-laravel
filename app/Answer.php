<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $primatyKey = 'id';
    protected $guarded = [];
    public $incrementing = false;

    public function question()
    {
      return $this->belongsTo('App\Question');
    }

    public function votes()
    {
      return $this->hasMany('App\Vote');
    }
}
