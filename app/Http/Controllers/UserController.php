<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Usermodel;
use DataTables;
use Auth;
use Validator;
use Session;


class UserController extends Controller
{
    //
    public function addUser(Request $request){
    	
    	$date_create = date('Y-m-d H:i:s');
    	$user = new Usermodel();

    	try{


    				if (Usermodel::where('username', '=', $request->input('un'))->exists()) {
                        return  \Response(['msg'=>'Username already in used.!']);
                    }else{

                    	$user->Firstname = $request->input('fn');
                    	$user->Middlename = $request->input('mn');
                    	$user->Lastname = $request->input('ln');
                    	$user->Contact = $request->input('contact');
                    	$user->Birthdate = $request->input('bd');
                    	$user->email = $request->input('mail');
                    	$user->username = $request->input('un');
                    	$user->password = Hash::make($request->input('pw'));
                    	$user->date_created = $date_create;
                    	$user->token = $request->input('_token');
                    	$user->user_type = $request->input('utype');
                    	$user->save();

                    return  \Response(['msg'=>'Record saved.']);
                    }

	    	}catch(\Exception $e){
	                return $e;
	        }
    }


    public function userList(){


    	 $details = Usermodel::select('id','Firstname','Middlename','Lastname','Contact','Birthdate','email','username',
    	 							    DB::raw('(CASE WHEN user_type = 0 THEN "Administrator" WHEN user_type = 1 THEN "Guest" WHEN user_type = 2 THEN "RECEIVER" ELSE "INPUTTER" END) AS user_class'),'user_type','date_last_login'
    	 							)->get();
                   
         return (DataTables::of($details)
                            ->addColumn('action', function($details){

                            	$user_details = $details->id.'*'.$details->Firstname.'*'.$details->Middlename.'*'.$details->Lastname.'*'.$details->Contact.'*'.$details->Birthdate.'*'.$details->email.'*'.$details->user_type;
                                return ' <button class="btn btn-primary" title="Update User" id="'.$user_details.'" onclick="getDetails(this.id)" data-toggle="modal" data-target="#modModal" style="cursor:pointer;""><i class="fa fa-edit"></i></button> &nbsp; <button class="btn btn-danger" title="Remove Details" id="'.$details->id.'" onclick="delUser(this.id)" style="cursor:pointer;""><i class="fa fa-trash"></i></button>';
                            })
                            ->make(true));

    }

    public function deleteUser($id){
    	try{
                Usermodel::destroy($id);
                return  \Response(['msg'=>'Record Deleted']);
                
            }catch(\Exception $e){
                return $e;
            }
    }


    public function updateUser(Request $request){

    	$date_create = date('Y-m-d H:i:s');

    	try{
		        $userid = $request->input('userid');
		        $user = Usermodel::where('id','=', $userid)->first();

		        $user->Firstname = $request->input('txtfn');
	        	$user->Middlename = $request->input('txtmn');
	        	$user->Lastname = $request->input('txtln');
	        	$user->Contact = $request->input('txtcontact');
	        	$user->Birthdate = $request->input('txtbd');
	        	$user->email = $request->input('txtmail');
	        	$user->user_type = $request->input('txtutype');
	        	$user->date_last_modified = $date_create;
		        $user->save();

		       return  \Response(['msg'=>'Record successfully modified']);

   			}catch(\Exception $e){
   				return $e;
   			}
    }


    public function userLogin(Request $request){

    	try{
                $date_login = date('Y-m-d H:i:s');


	    		$user = Usermodel::where('username', '=', $request->input('un'))->first();
	    		if($user){

		    		if(Hash::check($request->input('pw'), $user->password))
		    		{
		    					
		    					Session::put('user_id', $user->id);
		    					Session::put('session_token', $user->token);
		    					Session::put('Firstname', $user->Firstname);
                                Session::put('usertype', $user->user_type);

                                $user->is_active = 'Y';
                                $user->date_last_login = $date_login;
                                $user->save();

		                        return  \Response(['msg'=>'Welcome user']);
		            }else{
		            			return  \Response(['msg'=>'Invalid credentials']);
		            }
		        }else{
		        	return  \Response(['msg'=>'Invalid credentials']);
		        }

	        }catch(\Exception $e){
   				return $e;
   			}

    }

    public function logout(Request $request){

            
            $user = Usermodel::where('id', '=', $request->input('id'))->first();
            $user->is_active = 'N';
            $user->save();
            Session::flush();

           return  \Response(['msg'=>'Thank you and have a nice day.']);
    }

    public function updatecredentials(Request $request){

            $date_mod = date('Y-m-d H:i:s');

            $user = Usermodel::where('username', '=', $request->input('oldun'))->first();

            if($user){
                if(Hash::check($request->input('oldpw'), $user->password))
                        {
                                   
                                    $user->username = $request->input('newun');
                                    $user->password = Hash::make($request->input('newpw'));
                                    $user->date_last_modified = $date_mod;
                                    $user->save();

                                    return  \Response(['msg'=>'Record updated']);
                    }else{
                                return  \Response(['msg'=>'Old password not matched.!']);
                    }
            }else{
                 return  \Response(['msg'=>'Old Username not matched.!']);
            }

          
    }

}
