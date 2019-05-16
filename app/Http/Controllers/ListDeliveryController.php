<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\codTransaction;
use App\paymentEntry;
use DataTables;
use Excel;
use Session;

class ListDeliveryController extends Controller
{
    

    public function showAllTransaction($date)
    {
        //
       // return $date;

    	$dates = explode("*",$date);
    	$min = $dates[0];
    	$max = $dates[1];

        try{

	        	if($min == '' && $max == ''){

			       $details = DB::table('cod_transactions')
			       				->leftjoin('cod_payment_details', 'cod_transactions.id','cod_payment_details.cod_no')
			       				->Select("cod_transactions.*","cod_payment_details.reference_id","cod_payment_details.reference_date","cod_payment_details.payment_amount","cod_payment_details.date_payment",'cod_payment_details.maker as Firstname',"cod_payment_details.date_last_update")
			       				->get();
	               
	                return (DataTables::of($details)
	                                    ->addColumn('action', function($details){
	                                    	if($details->payment_amount == null){
	                                    		return '-';
	                                    	}else{
	                                    		

	                                        	return '<button class="btn btn-primary" title="Modify Details" id="'.$details->id.'!'.$details->CUSTOMER_NAME.'!'.$details->ADDRESS.'!'.$details->payment_amount.'!'.$details->reference_id.'!'.$details->reference_date.'" onclick="modDetails(this.id)" data-toggle="modal" data-target="#modModal" style="cursor: pointer;" ><i class="fa fa-edit"></i></button>';
	                                        	
	                                    	}
	                                    })
	                                    ->make(true));
	            }else{

	            	$details = DB::table('cod_transactions')
			       				->leftjoin('cod_payment_details', 'cod_transactions.id','cod_payment_details.cod_no')
			       				->Select("cod_transactions.*","cod_payment_details.reference_id","cod_payment_details.reference_date","cod_payment_details.payment_amount","cod_payment_details.date_payment",'cod_payment_details.maker as Firstname',"cod_payment_details.date_last_update")
			       				->whereRaw("DATE(cod_transactions.DATE_ENTRY) >= '".$min."' AND DATE(cod_transactions.DATE_ENTRY) <= '".$max."' ")
			       				->get();
	               
	                return (DataTables::of($details)
	                                    ->addColumn('action', function($details){
	                                    	if($details->payment_amount == null){
	                                    		return '-';
	                                    	}else{

	                                        	return '<button class="btn btn-primary" title="Modify Details" id="'.$details->id.'!'.$details->CUSTOMER_NAME.'!'.$details->ADDRESS.'!'.$details->payment_amount.'!'.$details->reference_id.'!'.$details->reference_date.'" onclick="modDetails(this.id)" data-toggle="modal" data-target="#modModal" style="cursor: pointer;" ><i class="fa fa-edit"></i></button>';
	                                 
	                                    	}
	                                    })
	                                    ->make(true));
	            }
	        }catch(\Exception $e){
	   			return $e;
	   		}
    }

     public function updatePayment(Request $request)
     {
     	$date_create = date('Y-m-d H:i:s');
        try{
		        $cod = $request->input('cod');
		        $payment = paymentEntry::where('cod_no','=', $cod)->first();

		       $payment->reference_id = $request->input('ref');
		       $payment->reference_date = $request->input('ref_date');
		       $payment->payment_amount = $request->input('payment');
		       $payment->date_last_update = $date_create;
		       $payment->save();

		       return  \Response(['msg'=>'Record successfully modified']);

   			}catch(\Exception $e){
   				return $e;
   			}
     }

     public function exportReport($date){

	     	$dates = explode("*",$date);
	    	$min = $dates[0];
	    	$max = $dates[1];

	    	
	    	try{ 

	    	 	
	    	 		if($min == '' && $max == ''){

			       $details = DB::table('cod_transactions')
			       				->leftjoin('cod_payment_details', 'cod_transactions.id','cod_payment_details.cod_no')
			       				 ->leftjoin('tblusers', 'cod_transactions.maker','tblusers.id')
			       				->Select("cod_transactions.*","cod_payment_details.payment_amount","cod_payment_details.reference_id","cod_payment_details.reference_date","cod_payment_details.date_payment",'tblusers.Firstname')
			       				->get()->toArray();

			       	$details_array[] = array("DOC_NO",
											"CUSTOMER_NAME",
											"ADDRESS",
                                             "TRAN_DATE",
											"AMOUNT_TOTAL",
											"PERCENT_LESS_1",
											"PERCENT_LESS_2",
											"PERCENT_LESS_3",
											"AMOUNT_PERCENT_LESS",
											"AMOUNT_ADJ_LESS",
											"DESC_LESS_1",
											"DESC_LESS_2",
											"DESC_LESS_3",
											"AMOUNT_LESS_1",
											"AMOUNT_LESS_2",
											"AMOUNT_LESS_3",
											"DESC_ADDTL",
											"AMOUNT_ADDTL",
											"IS_TAX_INCLUSIVE",
											"PERCENT_TAX",
											"AMOUNT_TAX",
											"AMOUNT_NET",
                                            "REFERENCE_ID",
                                            "REFERANCE_DATE",
											"PAYMENT_AMOUNT",
											"DATE_PAYMENT",
											"MAKER");

			       	foreach ($details as $data) {
				       		$details_array[] = array("DOC_NO" => $data->DOC_NO,
											"CUSTOMER_NAME" => $data->CUSTOMER_NAME,
											"ADDRESS" => $data->ADDRESS,
                                            "TRAN_DATE" => $data->TRAN_DATE,
											"AMOUNT_TOTAL" => $data->AMOUNT_TOTAL,
											"PERCENT_LESS_1" => $data->PERCENT_LESS_1,
											"PERCENT_LESS_2" => $data->PERCENT_LESS_2,
											"PERCENT_LESS_3" => $data->PERCENT_LESS_3,
											"AMOUNT_PERCENT_LESS" => $data->AMOUNT_PERCENT_LESS,
											"AMOUNT_ADJ_LESS" => $data->AMOUNT_ADJ_LESS,
											"DESC_LESS_1" => $data->DESC_LESS_1,
											"DESC_LESS_2"  => $data->DESC_LESS_2, 
											"DESC_LESS_3"  => $data->DESC_LESS_3,
											"AMOUNT_LESS_1"  => $data->AMOUNT_LESS_1,
											"AMOUNT_LESS_2"  => $data->AMOUNT_LESS_2,
											"AMOUNT_LESS_3"  => $data->AMOUNT_LESS_3,
											"DESC_ADDTL"  => $data->DESC_ADDTL,
											"AMOUNT_ADDTL"  => $data->AMOUNT_ADDTL,
											"IS_TAX_INCLUSIVE"  => $data->IS_TAX_INCLUSIVE,
											"PERCENT_TAX"  => $data->PERCENT_TAX,
											"AMOUNT_TAX"  => $data->AMOUNT_TAX,
											"AMOUNT_NET"  => $data->AMOUNT_NET,
                                            "REFERENCE_ID"  => $data->reference_id,
                                             "REFERENCE_DATE"  => $data->reference_date,
											"PAYMENT_AMOUNT"  => $data->payment_amount,
											"DATE_PAYMENT"  => $data->date_payment,
											"MAKER"  => $data->Firstname);
				       	}

				       	Excel::create('COD Transactions',function($excel) use ($details_array){
				       		$excel->setTitle('COD Transactions');
				       		$excel->sheet('COD Transactions',function($sheet)
				       			use ($details_array){
				       				$sheet->fromArray($details_array, null, 'A1', false, false);
				       		});

				       	})->download('csv');
	               
	            }else{

	            	$details = DB::table('cod_transactions')
			       				->leftjoin('cod_payment_details', 'cod_transactions.id','cod_payment_details.cod_no')
			       				 ->leftjoin('tblusers', 'cod_transactions.maker','tblusers.id')
			       				->Select("cod_transactions.*","cod_payment_details.payment_amount","cod_payment_details.reference_id","cod_payment_details.reference_date","cod_payment_details.date_payment",'tblusers.Firstname')
			       				->whereRaw("DATE(cod_transactions.DATE_ENTRY) >= '".$min."' AND DATE(cod_transactions.DATE_ENTRY) <= '".$max."' ")
			       				->get()->toArray();

			       	$details_array[] = array("DOC_NO",
											"CUSTOMER_NAME",
											"ADDRESS",
                                             "TRAN_DATE",
											"AMOUNT_TOTAL",
											"PERCENT_LESS_1",
											"PERCENT_LESS_2",
											"PERCENT_LESS_3",
											"AMOUNT_PERCENT_LESS",
											"AMOUNT_ADJ_LESS",
											"DESC_LESS_1",
											"DESC_LESS_2",
											"DESC_LESS_3",
											"AMOUNT_LESS_1",
											"AMOUNT_LESS_2",
											"AMOUNT_LESS_3",
											"DESC_ADDTL",
											"AMOUNT_ADDTL",
											"IS_TAX_INCLUSIVE",
											"PERCENT_TAX",
											"AMOUNT_TAX",
											"AMOUNT_NET",
                                            "REFERENCE_ID",
                                            "REFERANCE_DATE",
											"PAYMENT_AMOUNT",
											"DATE_PAYMENT",
											"MAKER");

			       	foreach ($details as $data) {
				       		$details_array[] = array("DOC_NO" => $data->DOC_NO,
											"CUSTOMER_NAME" => $data->CUSTOMER_NAME,
											"ADDRESS" => $data->ADDRESS,
											"AMOUNT_TOTAL" => $data->AMOUNT_TOTAL,
											"PERCENT_LESS_1" => $data->PERCENT_LESS_1,
											"PERCENT_LESS_2" => $data->PERCENT_LESS_2,
											"PERCENT_LESS_3" => $data->PERCENT_LESS_3,
											"AMOUNT_PERCENT_LESS" => $data->AMOUNT_PERCENT_LESS,
											"AMOUNT_ADJ_LESS" => $data->AMOUNT_ADJ_LESS,
											"DESC_LESS_1" => $data->DESC_LESS_1,
											"DESC_LESS_2"  => $data->DESC_LESS_2, 
											"DESC_LESS_3"  => $data->DESC_LESS_3,
											"AMOUNT_LESS_1"  => $data->AMOUNT_LESS_1,
											"AMOUNT_LESS_2"  => $data->AMOUNT_LESS_2,
											"AMOUNT_LESS_3"  => $data->AMOUNT_LESS_3,
											"DESC_ADDTL"  => $data->DESC_ADDTL,
											"AMOUNT_ADDTL"  => $data->AMOUNT_ADDTL,
											"IS_TAX_INCLUSIVE"  => $data->IS_TAX_INCLUSIVE,
											"PERCENT_TAX"  => $data->PERCENT_TAX,
											"AMOUNT_TAX"  => $data->AMOUNT_TAX,
											"AMOUNT_NET"  => $data->AMOUNT_NET,
                                            "REFERENCE_ID"  => $data->reference_id,
                                            "REFERENCE_DATE"  => $data->reference_date,
											"PAYMENT_AMOUNT"  => $data->payment_amount,
											"DATE_PAYMENT"  => $data->date_payment,
											"MAKER"  => $data->Firstname);
				       	}

				       	Excel::create('COD Transactions',function($excel) use ($details_array){
				       		$excel->setTitle('COD Transactions');
				       		$excel->sheet('COD Transactions',function($sheet)
				       			use ($details_array){
				       				$sheet->fromArray($details_array, null, 'A1', false, false);
				       		});

				       	})->download('csv');
	               
	            }

	    	 }catch(\Exception $e){
	   			return $e;
	   		}
     }
}
