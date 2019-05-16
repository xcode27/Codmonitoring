<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    //
    protected $connection = 'mysql2';
    protected $table = 'cust_tran_head';
}
