<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PagesController extends Controller
{
    public function index(){
    	return view('pages.index');
    }

    public function home(){
        return view('pages.home');
    }

     public function CreateMenu(){

        return view('pages.menus');
    }

     public function MappedMenu(){

        return view('pages.accessrights');
    }

    
     public function CreateUser(){
         return view('pages.userregistration');
      
    }

    public function ongoingdeliver($id){
    	return view('pages.ongoing')->with('mod_id',$id);
    }

    public function paymententry($id){
    	return view('pages.PaymentEntry')->with('mod_id',$id);
    }

    public function deliverydetails($id){
    	return view('pages.listdelivery')->with('mod_id',$id);
    }

     public function userdetails(){
    	return view('pages.user');
    }

     public function changecredential($id){
        return view('pages.change_credentials')->with('mod_id',$id);
    }
}
