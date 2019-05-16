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


var url = '{{ route("allTransactions", ":date") }}';
var url1 = url.replace(':date', date);

$('#rawdata').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		"lengthChange": false,
		"pageLength": 10,
		"ajax": url1,
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
				{"data" : "Firstname"},
				{"data" : "DATE_ENTRY"}
				

			]
	});

}




function addPayment(id){
	var info = id.split('!');
	 
	$('#cod_no').val(info[0]);
	$('#tran_no').val(info[1]);
	$('#txtcus').val(info[2]);
	$('#txtadd').val(info[3]);
	$('#txtamountnet').val(info[4]);

}

function savePayment(){


	var datas = {
				 _token: '{{csrf_token()}}',cod:$('#cod_no').val(),tranno:$('#tran_no').val(),payment:$('#txtamount').val(),maker:user,ref:$('#referenceid').val(),ref_date:$('#ref_date').val()
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('addPayment')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
				if(data.msg == 'Record saved.'){
					alert(data.msg);
					$('#rawdata').DataTable().ajax.reload();
					$('#referenceid').val('')
					$('#txtamount').val('')
					$('#exampleModal').modal('hide');
				}else{
					alert(data.msg);
				}
			});	
}

function delDetails(id){
	
	if(confirm('Are you sure you want to remove this entry. ?') == true){
			$.ajax({
			    type: 'GET',
			    url: '{{URL::to('removeDetails')}}'+'/'+id,
			}).done(function( msg ) {
				
				var data = jQuery.parseJSON(JSON.stringify(msg));
				alert(data.msg);

				$('#rawdata').DataTable().ajax.reload();
			});
		}
}
</script>
@section('content')

 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">Payment Details</a>

  </li>
</ol>
<input type="hidden" id="moduleid" value="{{$mod_id}}">
<input type="hidden" id="trn_no" />
<div class="input-group" style="width:600px;">
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
</div>
<br>
<center>
		<table class="table table-striped table-responsive" style="width: 100%; overflow-x: scroll; font-size: 10px; text-align: center; " id="rawdata">
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
					<th>MAKER</th>
					<th>DATE CREATED</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
</center>

@endsection
<!--add payment entry-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Payment amount</h5>
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
			    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
			  </div>
			  <input type="hidden" id="cod_no">
			  <input type="hidden" id="tran_no">
			  <input type="number" class="form-control" id="txtamountnet" step="0.01" placeholder="Enter amount" style="resize: none;" readonly ></input>
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
			  <input type="hidden" id="cod_no">
			  <input type="hidden" id="tran_no">
			  <input type="number" class="form-control" id="txtamount" step="0.01" placeholder="Enter amount" style="resize: none;" ></input>
		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnSavePayment" onclick="savePayment()">Save</button>
      </div>
    </div>
  </div>
</div>
<!--end payment entry-->



