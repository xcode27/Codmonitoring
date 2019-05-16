<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerTransaction;
use App\codTransaction;
use DataTables;
use Session;

class PaymentEntryController extends Controller
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
    public function store(Request $request)
    {
       
        $date_create = date('Y-m-d H:i:s');

        $cod = new codTransaction();

        try{
                    if (codTransaction::where('TRAN_NO', '=', $request->input('trno'))->exists()) {
                        return  \Response(['msg'=>'Already recorded']);
                    }else{

                    $cod->TRAN_NO = $request->input('trno');
                    $cod->CUSTOMER_NAME = $request->input('name');
                    $cod->TRAN_DATE = $request->input('tdate');
                    $cod->ADDRESS = $request->input('address');
                    $cod->DOC_NO = $request->input('docno');
                    $cod->AMOUNT_TOTAL = $request->input('amount');
                    $cod->PERCENT_LESS_1 = $request->input('p1');
                    $cod->PERCENT_LESS_2 = $request->input('p2');
                    $cod->PERCENT_LESS_3 = $request->input('p3');
                    $cod->AMOUNT_PERCENT_LESS = $request->input('amnt_percent');
                    $cod->AMOUNT_ADJ_LESS = $request->input('amnt_less');
                    $cod->DESC_LESS_1 = $request->input('dless1');
                    $cod->DESC_LESS_2 = $request->input('dless2');
                    $cod->DESC_LESS_3 = $request->input('dless3');
                    $cod->AMOUNT_LESS_1 = $request->input('amt_less1');
                    $cod->AMOUNT_LESS_2 = $request->input('amt_less2');
                    $cod->AMOUNT_LESS_3 = $request->input('amt_less3');
                    $cod->DESC_ADDTL = $request->input('desc_adtl');
                    $cod->AMOUNT_ADDTL = $request->input('amnt_adtl');
                    $cod->IS_TAX_INCLUSIVE = $request->input('is_tax'); // no return
                    $cod->PERCENT_TAX = $request->input('percent_tax');
                    $cod->AMOUNT_TAX = $request->input('amnt_tax');
                    $cod->AMOUNT_NET = $request->input('amnt_net');
                    $cod->IS_PAID = 'N';
                    $cod->DATE_ENTRY = $date_create;
                    $cod->maker = $request->input('user');
                    $cod->save();

                    return  \Response(['msg'=>'Record saved.']);
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
    public function show($id)
    {
        
        try{
                $payment = CustomerTransaction::select(
                                                    'TRAN_NO','CONTACT_NAME','TRAN_DATE','ADDRESS1','TRM_CODE'
                                                )->where('DOC_NO',$id)
                                                ->where('TRM_CODE', 'CASH')
                                                 ->where('CLEARED_PAYMENT', 'N')
                                                ->whereIn('TRAN_TYPE',[2,3,5,6])
                                                ->get(); 
               return \Response::json($payment);

            }catch(\Exception $e){
                return $e;
            }
        
    }

    public function orderDetails($tran_no){

        try{
                $details = CustomerTransaction::select(
                                                        'AMOUNT_TOTAL','PERCENT_LESS_1','PERCENT_LESS_2','PERCENT_LESS_3',
                                                        'AMOUNT_PERCENT_LESS','AMOUNT_ADJ_LESS','DESC_LESS_1','DESC_LESS_2',
                                                        'DESC_LESS_3','AMOUNT_LESS_1','AMOUNT_LESS_2','AMOUNT_LESS_3',
                                                        'DESC_ADDTL','AMOUNT_ADDTL','IS_TAX_INCLUSIVE','PERCENT_TAX',
                                                        'AMOUNT_TAX','AMOUNT_NET','AMOUNT_TOT_PAID'
                                                    )->where('TRAN_NO',$tran_no)
                                                    ->get();
               
                return \Response::json($details);

            }catch(\Exception $e){
                return $e;
            }
            
    }

    public function displayEntry($user){

        $date_create = date('Y-m-d');

        try{
                $details = codTransaction::select('DOC_NO','CUSTOMER_NAME','ADDRESS','AMOUNT_TOTAL','PERCENT_LESS_1','PERCENT_LESS_2','PERCENT_LESS_3',
                                                        'AMOUNT_PERCENT_LESS','AMOUNT_ADJ_LESS','DESC_LESS_1','DESC_LESS_2',
                                                        'DESC_LESS_3','AMOUNT_LESS_1','AMOUNT_LESS_2','AMOUNT_LESS_3',
                                                        'DESC_ADDTL','AMOUNT_ADDTL','IS_TAX_INCLUSIVE','PERCENT_TAX',
                                                        'AMOUNT_TAX','AMOUNT_NET','DATE_ENTRY')
                                                ->whereRaw("DATE(DATE_ENTRY) = '".$date_create."'")
                                                ->where('IS_PAID','N')
                                                ->where('maker', $user);
               
              
                return (DataTables::of($details)->make(true));

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
    public function destroy($id)
    {
        //
    }
}
