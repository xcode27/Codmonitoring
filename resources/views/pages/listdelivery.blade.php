@extends('layout.app')
<style type="text/css">
	th, td {
  white-space: nowrap;
}
tr:hover td {background:#ccfff5}
</style>
<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">

$(document).ready(function(){

	getAllTransactions();

	$('#btnSearch').click(function(){

		if($('#min-date').val() == '' || $('#max-date').val() == ''){
				alert('Please input two dates');
				return false;
			}
		$("#rawdata").dataTable().fnDestroy();
		getAllTransactions();
	});

	 checkUserControl();

});





function getAllTransactions(){

var min = $('#min-date').val();
var max = $('#max-date').val();
var date = min+'*'+max;


var url = '{{ route("listTransactions", ":date") }}';
var url1 = url.replace(':date', date);
$('#rawdata').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		"lengthChange": false,
		"pageLength": 10,
		"ajax":url1,
		"columns":[
				{"data" : "action", orderable:false, searchable: false , width: "50%"},
				{"data" : "DOC_NO"},
				{"data" : "CUSTOMER_NAME"},
				{"data" : "ADDRESS"},
				{"data" : "TRAN_DATE"},
				{"data" : "AMOUNT_TOTAL"},
				{"data" : "PERCENT_LESS_1"},
				{"data" : "PERCENT_LESS_2"},
				{"data" : "PERCENT_LESS_3"},
				{"data" : "AMOUNT_PERCENT_LESS"},
				{"data" : "AMOUNT_ADJ_LESS"},
				{"data" : "DESC_LESS_1"},
				{"data" : "DESC_LESS_2"},
				{"data" : "DESC_LESS_3"},
				{"data" : "AMOUNT_LESS_1"},
				{"data" : "AMOUNT_LESS_2"},
				{"data" : "AMOUNT_LESS_3"},
				{"data" : "DESC_ADDTL"},
				{"data" : "AMOUNT_ADDTL"},
				{"data" : "IS_TAX_INCLUSIVE"},
				{"data" : "PERCENT_TAX"},
				{"data" : "AMOUNT_TAX"},
				{"data" : "AMOUNT_NET"},
				{"data" : "reference_id"},
				{"data" : "reference_date"},
				{"data" : "payment_amount"},
				{"data" : "date_payment"},
				{"data" : "Firstname"},
				{"data" : "date_last_update"}
				

			],
			dom: 'Bfrtip',
			"buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
       		 ]
	});


}



function modDetails(id){

	var info = id.split('!');

	$('#codid').val(info[0]);
	$('#txtcus').val(info[1]);
	$('#txtadd').val(info[2]);
	$('#txtamountpayment').val(info[3]);
	$('#referenceid').val(info[4]);
	$('#ref_date').val(info[5]);
}

function updatePayment(){


	if($('#modtxtamount').val() == ''){
		alert('Payment amount is required');
		return false;
	}
	var datas = {
				 _token: '{{csrf_token()}}',cod:$('#codid').val(),payment:$('#modtxtamount').val(),ref:$('#referenceid').val(),ref_date:$('#ref_date').val()
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('updatePayment')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
					alert(data.msg);
					$('#rawdata').DataTable().ajax.reload();
					$('#modtxtamount').val('')
			});	
}

function exportExcel(){

	var min = $('#min-date').val();
	var max = $('#max-date').val();
	var date = min+'*'+max;

	window.location.href='{{URL::to('exportReport')}}'+'/'+date;
}

</script>
@section('content')

 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">List of delivery</a>
  </li>
</ol>
<input type="hidden" id="moduleid" value="{{$mod_id}}">
<input type="hidden" id="trn_no" />

<div class="input-group" style="width:700px;">
	<span>From:&nbsp;</span>
	<div class="input-group-prepend">
	    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
	  </div>
	  <input type="date" class="form-control" id="min-date">
	  <span>&nbsp;To:&nbsp;</span>
	<div class="input-group-prepend">
	    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
	</div>
	  <input type="date" class="form-control" id="max-date">
	  &nbsp;<button class="btn btn-primary" id="btnSearch" >Search</button>
	   &nbsp;<a href="#" class="btn btn-primary" id="btnExport" onclick=" exportExcel()">Export</a>
</div>
<br>
<center>
		<table class="table table-striped table-responsive" style="width: 100%; overflow-x: scroll; font-size: 10px; text-align: center; "  id="rawdata">
			<thead>
				<tr>
					<th>ACTION</th>
					<th>DOC NO</th>
					<th>CUSTOMER NAME</th>
					<th>ADDRESS</th>
					<th>TRANSACTION DATE</th>
					<th>TOTAL AMOUNT</th>
					<th>PERCENT 1</th>
					<th>PERCENT 2</th>
					<th>PERCENT 3</th>
					<th>AMOUNT PERCENT LESS</th>
					<th>AMOUNT ADJUST LESS</th>
					<th>DESC LESS 1</th>
					<th>DESC LESS 2</th>
					<th>DESC LESS 3</th>
					<th>AMOUNT LESS 1</th>
					<th>AMOUNT LESS 2</th>
					<th>AMOUNT LESS 3</th>
					<th>DESC ADDITIONAL</th>
					<th>AMOUNT ADDITIONAL</th>
					<th>TAX INCLUSIVE</th>
					<th>PERCENT TAX</th>
					<th>AMOUNT TAX</th>
					<th>AMOUNT NET</th>
					<th>REFERENCE ID</th>
					<th>REFERENCE DATE</th>
					<th>PAYMENT</th>
					<th>DATE PAID</th>
					<th>MAKER</th>
					<th>DATE LAST MODIFIED</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
</center>

@endsection


<!--modify details-->
<div class="modal fade" id="modModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modify Payment amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="input-group">
			  <div class="input-group-prepend">
			    <span class="input-group-text"><i class="fa  fa-user"></i></span>
			  </div>
		
			  <textarea  class="form-control" id="txtcus"  style="resize: none;"  readonly></textarea>
		</div>

		<hr style="width: 100%;">

		<div class="input-group">
			  <div class="input-group-prepend">
			    <span class="input-group-text"><i class="fa  fa-user"></i></span>
			  </div>
		
			  <textarea  class="form-control" id="txtadd"  style="resize: none;"  readonly></textarea>
		</div>

		<hr style="width: 100%;">

        <div class="input-group">
			  <div class="input-group-prepend">
			    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
			  </div>
			  <input type="text" class="form-control" id="referenceid"  placeholder="Enter Reference" style="resize: none;"></input>
		</div>

		<hr style="width: 100%;">

        <div class="input-group">
			  <div class="input-group-prepend">
			    <span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
			  </div>
			  <input type="date" class="form-control" id="ref_date"  style="resize: none;"></input>
		</div>

		<hr style="width: 100%;">


        <div class="input-group">
			  <div class="input-group-prepend">
			    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
			  </div>
			 
			  <input type="number" class="form-control" id="txtamountpayment" step="0.01" style="resize: none;" readonly ></input>
		</div>

		<hr style="width: 100%;">

        <div class="input-group">
			<div class="input-group-prepend">
		    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
		  </div>
		  <input type="hidden" id="cod_no">
		  <input type="hidden" id="tran_no">
		  <input type="number" class="form-control" id="modtxtamount" step="0.01" placeholder="Enter amount" style="resize: none;" ></input>
		  <input type="hidden" id="codid">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnmodPayment" onclick="updatePayment()">Update</button>
      </div>
    </div>
  </div>
</div>
<!--end modify-->

