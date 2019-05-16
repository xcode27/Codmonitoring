<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class codTransaction extends Model
{
    //
   protected $connection = 'mysql';
   public $timestamps = false;
   protected $table = 'cod_transactions';
   protected $guarded = ['id','updated_at'];
   protected $casts = [
        'DATE_ENTRY' => 'datetime:Y-m-d',
    ];
   protected $fillable = ['TRAN_NO','CUSTOMER_NAME'
					        ,'TRAN_DATE'
						    ,'ADDRESS'
						    ,'DOC_NO'
						    ,'AMOUNT_TOTAL'
						    ,'PERCENT_LESS_1'
						    ,'PERCENT_LESS_2'
						    ,'PERCENT_LESS_3'
						    ,'AMOUNT_PERCENT_LESS'
						    ,'AMOUNT_ADJ_LESS'
						    ,'DESC_LESS_1'
						    ,'DESC_LESS_2'
						    ,'DESC_LESS_3'
						    ,'AMOUNT_LESS_1'
						    ,'AMOUNT_LESS_2'
						    ,'AMOUNT_LESS_3'
						    ,'DESC_ADDTL'
						    ,'AMOUNT_ADDTL'
						    ,'IS_TAX_INCLUSIVE'
						    ,'PERCENT_TAX'
						    ,'AMOUNT_TAX'
						    ,'AMOUNT_NET'
						    ,'IS_PAID'];
}
 