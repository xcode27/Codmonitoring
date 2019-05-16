<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paymentEntry extends Model
{
    //
    protected $connection = 'mysql';
    public $timestamps = false;
   protected $table = 'cod_payment_details';
   protected $guarded = ['id'];
   protected $fillable = ['cod_no'
					        ,'tran_no'
						    ,'payment_amount'
						    ,'date_payment'
						    ,'maker'];
}
