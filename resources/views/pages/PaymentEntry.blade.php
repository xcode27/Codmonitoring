@extends('layout.app')
<style type="text/css">
	th, td {
  white-space: nowrap;
}
</style>
<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">
var  rawdatas = '';
$(document).ready(function(){

	$('#txtSearch').keypress(function(e){
		var key = e.which;
		 if(key == 13)  // the enter key code
		  {
		    getTransactions();
			$('#btnSave').focus();
		  }
		
	});

	 checkUserControl();

	var url = '{{ route("displayEntry", ":user") }}';
  	var url1 = url.replace(':user', user);

	$('#rawdata2').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		"lengthChange": false,
		"pageLength": 5,
		"ajax": url1,
		"columns":[
        		{"data" : "DOC_NO"},
				{"data" : "CUSTOMER_NAME"},
				{"data" : "ADDRESS"},
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
				{"data" : "DATE_ENTRY"}

			]
	});

	checkUserControl();

});

function getTransactions(){

$("#rawdata tr").remove();
	var docno = $('#txtSearch').val();

	if(docno == ''){
		alert('Please enter document no. !');
		return false;
	}

	$.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	      }
	  });

	$.ajax({
	    type: "GET",
	    dataType : "json",
	    //url: '{URL::to('payment')}}'+'/'+docno,
	    url: "http://192.168.1.100:805/api_cod/index.php?doc_no="+ docno +"&type=cod&token="+ getToken,
	}).done(function( msg ) {
		
		
	    var data = jQuery.parseJSON(JSON.stringify(msg));
	  

	 
	   if(msg == null || msg == ''){
	    	alert('No record found');
	    }else{
	    	$('#trn_no').val(data[0].TRAN_NO);
		    $('#tdate').val(data[0].TRAN_DATE);
		    $('#txtcustomer').val(data[0].CONTACT_NAME);
		    $('#txtaddress').val(data[0].ADDRESS1);
		    $('#txtterm').val(data[0].TRM_CODE);

		
			var dets = '';
			$.each(msg, function(key, value){

				
				var datas = data[0].TRAN_NO+'!'+data[0].TRAN_DATE+'!'+data[0].CONTACT_NAME+'!'+data[0].ADDRESS1+'!'+value.AMOUNT_TOTAL+'!'+value.PERCENT_LESS_1+'!'+value.PERCENT_LESS_2+'!'+value.PERCENT_LESS_3+'!'+value.AMOUNT_PERCENT_LESS+'!'+value.AMOUNT_ADJ_LESS+'!'+value.DESC_LESS_1+'!'+value.DESC_LESS_2+'!'+value.DESC_LESS_3+'!'+value.AMOUNT_LESS_1+'!'+value.AMOUNT_LESS_2+'!'+value.AMOUNT_LESS_3+'!'+value.DESC_ADDTL+'!'+value.AMOUNT_ADDTL+'!'+value.IS_TAX_INCLUSIVE+'!'+value.PERCENT_TAX+'!'+value.AMOUNT_TAX+'!'+value.AMOUNT_NET;
			
				
				dets += '<tr>';
				dets += '<td>'+value.AMOUNT_TOTAL+'</td>';
				dets += '<td>'+value.PERCENT_LESS_1+'%'+'</td>';
				dets += '<td>'+value.PERCENT_LESS_2+'%'+'</td>';
				dets += '<td>'+value.PERCENT_LESS_3+'%'+'</td>';
				dets += '<td>'+value.AMOUNT_PERCENT_LESS+'</td>';
				dets += '<td>'+value.AMOUNT_ADJ_LESS+'</td>';
				dets += '<td>'+value.DESC_LESS_1+'</td>';
				dets += '<td>'+value.DESC_LESS_2+'</td>';
				dets += '<td>'+value.DESC_LESS_3+'</td>';
				dets += '<td>'+value.AMOUNT_LESS_1+'</td>';
				dets += '<td>'+value.AMOUNT_LESS_2+'</td>';
				dets += '<td>'+value.AMOUNT_LESS_3+'</td>';
				dets += '<td>'+value.DESC_ADDTL+'</td>';
				dets += '<td>'+value.AMOUNT_ADDTL+'</td>';
				dets += '<td>'+value.IS_TAX_INCLUSIVE+'</td>';
				dets += '<td>'+value.PERCENT_TAX+'</td>';
				dets += '<td>'+value.AMOUNT_TAX+'</td>';
				dets += '<td>'+value.AMOUNT_NET+'</td>';
				
				dets += '</tr>';

				rawdatas = datas;
			});
			$('#rawdata').append(dets);
		
		}
	});
}

function savePayment(){
	
	//saving of payment 
	var info = rawdatas.split('!');
	var transaction_no = info[0];
	var tdate = info[1];
	var customer = info[2];
	var address = info[3];
	var amount_total = info[4];
	var percent_less1 = info[5];
	var percent_less2 = info[6];
	var percent_less3 = info[7];
	var amount_percent = info[8];
	var amnt_adj_less = info[9];
	var desc_less_1 = info[10];
	var desc_less_2 = info[11];
	var desc_less_3 = info[12];
	var amnt_less_1 = info[13];
	var amnt_less_2 = info[14];
	var amnt_less_3 = info[15];
	var desc_adtl = info[16];
	var amnt_adtl = info[17];
	var is_tax = info[18];
	var percent_tax = info[19];
	var amnt_tax = info[20];
	var amnt_net = info[21];
	var payment = $('#txtpayment').val();
	var docno = $('#txtSearch').val();
	//var maker = $('#maker').val();


	if(transaction_no == ''){
		alert('Empty data. ! Please search for document no.');
		return false;
	}

	

	var datas = {
				 _token: '{{csrf_token()}}',trno:transaction_no,tdate:tdate,name:customer,address:address,docno:docno,amount:amount_total,p1:percent_less1,p2:percent_less2,p3:percent_less3,amnt_percent:amount_percent,amnt_less:amnt_adj_less,dless1:desc_less_1,dless2:desc_less_2,dless3:desc_less_3,amt_less1:amnt_less_1,amt_less2:amnt_less_2,amt_less3:amnt_less_3,desc_adtl:desc_adtl,amnt_adtl:amnt_adtl,is_tax:is_tax,percent_tax:percent_tax,amnt_tax:amnt_tax,amnt_net:amnt_net,user:user
				 //,payment:payment
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('savePayment')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
				if(data.msg == 'Record saved.'){
					alert(data.msg);
					document.location.reload();
				}else{
					alert(data.msg);
				}
			});	

}

</script>
@section('content')
 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">Invoice Details</a>
  </li>
</ol>
<input type="hidden" id="moduleid" value="{{$mod_id}}">
<center>
		 <input type="hidden" id="trn_no" />
		<table class="table" style="width: 100%; margin: auto;">
				<tr>
					<td style="width:160px; font-size: 20px;" >Document No  </td>
					<td>
						<div class="input-group" style="width:250px;">
						  <input type="text" class="form-control" id="txtSearch" placeholder="Enter Document No." >
						 
						  <div class="input-group-prepend">
						    <span class="input-group-text" style="background-color: #5bc0de; " id="btnsearch" title="Search" onclick="getTransactions()"><i class="fas fa-fw fa-search" style="cursor: pointer;"></i></span>
						  </div>
						</div>
					</td>
					<td style="width:400px;"><button class="btn btn-primary" id="btnSave" onclick="savePayment()"><i class="fa fa-save"></i>&nbsp;Save</button></td><td style="width:400px;"></td>
					<td style="width:185px; font-size: 20px;" >Transaction Date </td>
					<td>
						<div class="input-group" style="width:250px;">
							  <input type="text" class="form-control" id="tdate" readonly>
							  <div class="input-group-prepend">
							    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
							  </div>
						</div>
					</td>
					
				</tr>
		<tr><td colspan="6"></td></tr>
		</table>
		<table class="table" style="width: 100%; margin: auto;">
				<tr>
					<td style="font-size: 20px; text-align: right;">Customer</td>
					<td>
						<div class="input-group">
							<div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-fw fa-user"></i></span>
						  </div>
						  <textarea type="text" class="form-control" id="txtcustomer" placeholder="Customer name" style="resize: none;" readonly></textarea>
						</div>
					</td>
					<td style="font-size: 20px; text-align: right;" >Address</td>
					<td>
						<div class="input-group">
							<div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-fw fa-address-card"></i></span>
						  </div>
						  <textarea class="form-control" id="txtaddress" placeholder="Address" style="resize: none;" readonly></textarea>
						</div>
					</td>
					<td style="font-size: 20px; text-align: right;" >Term</td>
					<td>
						<div class="input-group">
							<div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-fw fa-list"></i></span>
						  </div>
						  <input type="text" class="form-control" id="txtterm" placeholder="TERMS" readonly>
						</div>
					</td>
				</tr>
		<tr><td colspan="6"></td></tr>
		</table>
		<table class="table table-striped table-responsive" style="width: 100%; overflow-x: scroll; font-size: 10px; text-align: center; ">
			<thead>
				<tr>
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
				</tr>
			</thead>
			<tbody id="rawdata">
			</tbody>
		</table>

		<ol class="breadcrumb">
		  <li class="breadcrumb-item">
		    <a href="#">List of COD Transaction</a>
		  </li>
		</ol>

		<table class="table table-striped table-responsive" style="width: 100%; overflow-x: scroll; font-size: 9px; text-align: center; " id="rawdata2">
			<thead>
				<tr>
                    <th>DOC NO</th>
					<th>CUSTOMER NAME</th>
					<th>ADDRESS</th>
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
					<th>DATE ENTRY</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
</center>
@endsection