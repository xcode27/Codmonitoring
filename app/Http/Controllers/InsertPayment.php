<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\codTransaction;
use App\paymentEntry;
use App\Auditlog;
use DataTables;
use Illuminate\Support\Facades\DB;
use Session;

class InsertPayment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePayment(Request $request)
    {
        $date_create = date('Y-m-d H:i:s');

            $cod = new paymentEntry();

            try{

                    if($request->input('payment') == null){
                            return  \Response(['msg'=>'Payment is empty']);
                            
                    }else{

                        if (paymentEntry::where('cod_no', '=', $request->input('cod'))->exists()) {
                            return  \Response(['msg'=>'Already recorded']);
                        }else{

                        $cod->cod_no = $request->input('cod');
                        $cod->tran_no = $request->input('tranno');
                        $cod->payment_amount = $request->input('payment');
                        $cod->date_payment = $date_create;
                        $cod->maker = $request->input('maker');
                        $cod->reference_id = $request->input('ref');
                        $cod->reference_date = $request->input('ref_date');
                        $cod->save();

                        $codtran = codTransaction::where('id', '=', $request->input('cod'))->first();

                        if($codtran){

                            $codtran->IS_PAID = 'Y';
                            $codtran->save();
                            
                        }

                        return  \Response(['msg'=>'Record saved.']);
                        }

                    }

                }catch(\Exception $e){
                     return $e;
                }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function showAllTransaction($date)
     {

        $dates = explode("*",$date);
        $min = $dates[0];
        $max = $dates[1];

        try{

                if($min == '' && $max == ''){
                   
                    $details =  DB::table('cod_transactions')
                                ->Select( 'cod_transactions.id','cod_transactions.TRAN_NO','cod_transactions.CUSTOMER_NAME','cod_transactions.ADDRESS','cod_transactions.TRAN_DATE','cod_transactions.DOC_NO',
                                                    'cod_transactions.AMOUNT_TOTAL','cod_transactions.PERCENT_LESS_1','cod_transactions.PERCENT_LESS_2','cod_transactions.PERCENT_LESS_3',
                                                    'cod_transactions.AMOUNT_PERCENT_LESS','cod_transactions.AMOUNT_ADJ_LESS','cod_transactions.DESC_LESS_1','cod_transactions.DESC_LESS_2',
                                                    'cod_transactions.DESC_LESS_3','cod_transactions.AMOUNT_LESS_1','cod_transactions.AMOUNT_LESS_2','cod_transactions.AMOUNT_LESS_3',
                                                    'cod_transactions.DESC_ADDTL','cod_transactions.AMOUNT_ADDTL','cod_transactions.IS_TAX_INCLUSIVE','cod_transactions.PERCENT_TAX',
                                                    'cod_transactions.AMOUNT_TAX','cod_transactions.AMOUNT_NET','cod_transactions.maker as Firstname','cod_transactions.DATE_ENTRY')
                                                ->whereNotIn('cod_transactions.id', function($query)
                                                                        {
                                                                            $query->select('cod_no')
                                                                                  ->from('cod_payment_details')
                                                                                  ->whereRaw('cod_payment_details.cod_no = cod_transactions.id');
                                                            })
                                                ->get();
                   
                    return (DataTables::of($details)
                                        ->addColumn('action', function($details){
                                          

                                                    return ' <button class="btn btn-primary" title="Payment Entry" id="'.$details->id.'!'.$details->TRAN_NO.'!'.$details->CUSTOMER_NAME.'!'.$details->ADDRESS.'!'.$details->AMOUNT_NET.'" onclick="addPayment(this.id)" data-toggle="modal" data-target="#exampleModal" style="cursor:pointer;""><i class="fa fa-plus"></i></button> &nbsp; <button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="delDetails(this.id)" style="cursor:pointer;""><i class="fa fa-trash"></i></button>';
                                            
                                        })
                                        ->make(true));
                }else{

                    $details =  DB::table('cod_transactions')
                                ->Select( 'cod_transactions.id','cod_transactions.TRAN_NO','cod_transactions.CUSTOMER_NAME','cod_transactions.ADDRESS','cod_transactions.TRAN_DATE','cod_transactions.DOC_NO',
                                                    'cod_transactions.AMOUNT_TOTAL','cod_transactions.PERCENT_LESS_1','cod_transactions.PERCENT_LESS_2','cod_transactions.PERCENT_LESS_3',
                                                    'cod_transactions.AMOUNT_PERCENT_LESS','cod_transactions.AMOUNT_ADJ_LESS','cod_transactions.DESC_LESS_1','cod_transactions.DESC_LESS_2',
                                                    'cod_transactions.DESC_LESS_3','cod_transactions.AMOUNT_LESS_1','cod_transactions.AMOUNT_LESS_2','cod_transactions.AMOUNT_LESS_3',
                                                    'cod_transactions.DESC_ADDTL','cod_transactions.AMOUNT_ADDTL','cod_transactions.IS_TAX_INCLUSIVE','cod_transactions.PERCENT_TAX',
                                                    'cod_transactions.AMOUNT_TAX','cod_transactions.AMOUNT_NET','cod_transactions.maker as Firstname','cod_transactions.DATE_ENTRY')
                                                ->whereNotIn('cod_transactions.id', function($query)
                                                                        {
                                                                            $query->select('cod_no')
                                                                                  ->from('cod_payment_details')
                                                                                  ->whereRaw('cod_payment_details.cod_no = cod_transactions.id');
                                                            })
                                                ->whereRaw("DATE(DATE_ENTRY) >= '".$min."' AND DATE(DATE_ENTRY) <= '".$max."' ")
                                                ->get();
                   
                    return (DataTables::of($details)
                                        ->addColumn('action', function($details){
                                           if(Session::get('usertype') == 3){

                                                    return '<button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="delDetails(this.id)" style="cursor:pointer;""><i class="fa fa-trash"></i></button>';
                                            }else{

                                                    return ' <button class="btn btn-primary" title="Payment Entry" id="'.$details->id.'!'.$details->TRAN_NO.'!'.$details->CUSTOMER_NAME.'!'.$details->ADDRESS.'!'.$details->AMOUNT_NET.'" onclick="addPayment(this.id)" data-toggle="modal" data-target="#exampleModal" style="cursor:pointer;""><i class="fa fa-plus"></i></button> &nbsp; <button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="delDetails(this.id)" style="cursor:pointer;""><i class="fa fa-trash"></i></button>';
                                            }
                                        })
                                        ->make(true));

                }

            }catch(\Exception $e){
                return $e;
            }

     }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function deleteDetails($id)
    {
        $date_create = date('Y-m-d H:i:s');
        try{
                $auditlog = Auditlog::create([
                                'action' => 'REMOVE',
                                'rec_id' => $id,
                                'maker' => Session::get('user_id'),
                                'date_created' => $date_create,
                ]);
                
                codTransaction::destroy($id);
                return  \Response(['msg'=>'Record Deleted']);
                
            }catch(\Exception $e){
                return $e;
            }
    }

    public function alldelivered(){

          try{
                $details = codTransaction::get()->count();
                return $details;

            }catch(\Exception $e){
                return $e;
            }
    }

     public function paiddelivered(){

          try{
                $details = codTransaction::where('IS_PAID', 'Y')->get()->count();
                return $details;

            }catch(\Exception $e){
                return $e;
            }
    }

    public function unpaiddelivered(){

          try{
                $details = codTransaction::where('IS_PAID', 'N')->get()->count();
                return $details;

            }catch(\Exception $e){
                return $e;
            }
    }
}
