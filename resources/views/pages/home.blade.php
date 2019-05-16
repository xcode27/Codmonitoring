@extends('layout.app')

<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){

	
allDelivery();
paidDelivery();
unpaidDelivery();
checkUserControl();
});

function allDelivery(){
	$.ajax({
		    type: 'GET',
		    url: '{{URL::to('alldelivered')}}',
		}).done(function( msg ) {
			
			$('#no_of_delivered').html(msg);
		});
}


function paidDelivery(){
	$.ajax({
		    type: 'GET',
		    url: '{{URL::to('paiddelivered')}}',
		}).done(function( msg ) {
			
			$('#no_of_paid').html(msg);
		});
}

function unpaidDelivery(){
	$.ajax({
		    type: 'GET',
		    url: '{{URL::to('unpaiddelivered')}}',
		}).done(function( msg ) {
			
			$('#no_of_unpaid').html(msg);
		});
}

</script>
@section('content')
 <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Overview</li>

     
  </ol>
  <div class="row" style="height: 100px;">
  		<div class="col-xl-4 col-sm-6 mb-4">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <div class="mr-5"><span id="no_of_delivered"></span> &nbsp;Total Delivered Stocks</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                 <!-- <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>-->
                </a>
              </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-4">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <div class="mr-5"><span id="no_of_paid">0</span> &nbsp;Total Paid Delivery</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                 <!-- <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>-->
                </a>
              </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-4">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <div class="mr-5"><span id="no_of_unpaid">0</span> &nbsp;Total Unpaid Delivery</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                 <!-- <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>-->
                </a>
              </div>
        </div>
  </div>
@endsection