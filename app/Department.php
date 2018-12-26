<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey='depid';
    //

    public function businessunit()
    {
        return $this->belongsTo('App\Businessunit','buid','unitid');
    }

}
