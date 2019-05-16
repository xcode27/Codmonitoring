<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usermodel extends Model
{
    //
    protected $connection = 'mysql';
    public $timestamps = false;
    protected $table = 'tblusers';
    protected $guarded = ['updated_at'];
    protected $casts = [
        'date_created' => 'datetime:Y-m-d',
    ];
}
