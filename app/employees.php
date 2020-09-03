<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    //
     protected $fillable = [
        'empname', 'email','contact','image'
    ];
}
