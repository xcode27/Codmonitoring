<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditlog extends Model
{
    //
    
     protected $connection = 'mysql';
     public $timestamps = false;
     protected $table = 'auditlog';
     protected $guarded = ['updated_at'];
}
