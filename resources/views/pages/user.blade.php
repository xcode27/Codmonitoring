@extends('layout.app')

<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">

$(document).ready(function(){

	$('#btnNew').click(function(){
		$('#fn').focus();

		$('#fn').val('');
		$('#mn').val('');
		$('#ln').val('');
		$('#contact').val('');
		$('#email').val('');
		$('#un').val('');
		$('#pw').val('');
		$('#cpw').val('');

	});

	Userlist();

	checkUserControl();

});


function Userlist(){
	$('#rawdata').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		"lengthChange": false,
		"pageLength": 5,
		"ajax":'{{ route('userlist') }}',
		"columns":[
				{"data" : "Firstname"},
				{"data" : "Middlename"},
				{"data" : "Lastname"},
				{"data" : "Contact"},
				{"data" : "Birthdate"},
				{"data" : "email"},
				{"data" : "username"},
				{"data" : "user_class"},
				{"data" : "date_last_login"},
				{"data" : "action", orderable:false, searchable: false}

			]
	});

	$('.receiver').click(function(){
		alert($('.receiver').val())
	})
}

function saveUser(){
	var x = '';

	if($('#fn').val() == ''){
		$("#fn").css("border-color","red");
		x = 1;
	}else{
		$("#fn").css("border-color","#ffffff");
	}

	if($('#ln').val() == ''){
		$("#ln").css("border-color","red");
		x = 1;
	}else{
		$("#ln").css("border-color","#ffffff");
	}

	if($('#contact').val() == ''){
		$("#contact").css("border-color","red");
		x = 1;
	}else{
		$("#contact").css("border-color","#ffffff");
	}

	if($('#bd').val() == ''){
		$("#bd").css("border-color","red");
		x = 1;
	}else{
		$("#bd").css("border-color","#ffffff");
	}

	if($('#email').val() == ''){
		$("#email").css("border-color","red");
		x = 1;

	}else{
		$("#email").css("border-color","#ffffff");
	}

	if($('#un').val() == ''){
		$("#un").css("border-color","red");
		x = 1;
	}else{
		$("#un").css("border-color","#ffffff");
	}

	if($('#pw').val() == ''){
		$("#pw").css("border-color","red");
		x = 1;

	}else{
		$("#pw").css("border-color","#ffffff");
	}

	if($('#cpw').val() == ''){
		$("#cpw").css("border-color","red");
		x = 1;

	}else{
		$("#cpw").css("border-color","#ffffff");
	}


	if($('#utype').val() == ''){
		$("#utype").css("border-color","red");
		x = 1;

	}else{
		$("#utype").css("border-color","#ffffff");
	}

	

	var fn = $('#fn').val();
	var mn = $('#mn').val();
	var ln = $('#ln').val();
	var contact = $('#contact').val();
	var bd = $('#bd').val();
	var mail = $('#email').val();
	var un = $('#un').val();
	var pw = $('#pw').val();
	var cpw = $('#cpw').val();
	var utype = $('#utype').val();

	

	if(x == 0){

		if($('#pw').val().length < 4){
			
			alert('Password must atleast 4 characters !')
			return false;
		}

		if(pw != cpw){

			alert('password mismatch.!');
			return false;
		}


		var datas = {
				 _token: '{{csrf_token()}}',fn:fn,mn:mn,ln:ln,contact:contact,bd:bd,mail:mail,un:un,pw:pw,utype:utype
				}

			/*$.ajaxSetup({
			      headers: {
			          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			      }
			  });*/

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('addUser')}}',
			}).done(function( msg ) {
				//console.log(msg);
				//return false;
				var data = jQuery.parseJSON(JSON.stringify(msg));
				if(data.msg == 'Record saved.'){
					alert(data.msg);
					$('#rawdata').DataTable().ajax.reload();
				}else{
					alert(data.msg);
				}
			});	
	}

	
}

function getDetails(id){

	var info = id.split('*');

	$('#userid').val(info[0]);
	$('#txtfn').val(info[1]);
	$('#txtmn').val(info[2]);
	$('#txtln').val(info[3]);
	$('#txtcontact').val(info[4]);
	$('#txtbd').val(info[5]);
	$('#txtmail').val(info[6]);
	$('#txtutype').val(info[7]);


}

function updateUser(){

	var userid = $('#userid').val();
	var txtfn = $('#txtfn').val();
	var txtmn = $('#txtmn').val();
	var txtln = $('#txtln').val();
	var txtcontact = $('#txtcontact').val();
	var txtbd = $('#txtbd').val();
	var txtmail = $('#txtmail').val();
	var txtutype = $('#txtutype').val();

	if(txtfn == ''){
		alert('Firstname is required');
		return false;
	}
	if(txtln == ''){
		alert('Lastname is required');
		return false;
	}
	if(txtcontact == ''){
		alert('Contact # is required');
		return false;
	}
	if(txtbd == ''){
		alert('Birthdate is required');
		return false;
	}
	if(txtmail == ''){
		alert('Email is required');
		return false;
	}

	if(txtutype == ''){
		alert('User type is required');
		return false;
	}
	var datas = {
				 _token: '{{csrf_token()}}',userid:userid,txtfn:txtfn,txtmn:txtmn,txtln:txtln,txtcontact:txtcontact,txtbd:txtbd,txtmail:txtmail,txtutype:txtutype
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('updateUser')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
					alert(data.msg);
					$('#rawdata').DataTable().ajax.reload();

					$('#userid').val('');
					$('#txtfn').val('');
					$('#txtmn').val('');
					$('#txtln').val('');
					$('#txtcontact').val('');
					$('#txtbd').val('');
					$('#txtmail').val('');
			});	

}


function delUser(id){

	if(confirm('Are you sure you want to remove this entry. ?') == true){
			$.ajax({
			    type: 'GET',
			    url: '{{URL::to('deleteUser')}}'+'/'+id,
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
        <a href="#">User details</a>
      </li>
 </ol>
<center>
		<table class="table">
			<thead>
				<tr>
					<td colspan="6">Details</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;First name:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="fn" placeholder="Enter First name" style="border-color:#ffffff;" onkeyup="this.value = this.value.toUpperCase();">
						 </div>			
					</td>
					<td style="width:150px;">Middle name:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="mn" placeholder="Enter Middle name" style="border-color:#ffffff;" onkeyup="this.value = this.value.toUpperCase();">
						 </div>			
					</td>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;Last name:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="ln" placeholder="Enter Last name" style="border-color:#ffffff;" onkeyup="this.value = this.value.toUpperCase();">
						 </div>			
					</td>
				</tr>
				<tr>
					<td style="width:150px;"><span style="color:red;">*</span> &nbsp;Contact #:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="contact" placeholder="Enter Contact" style="border-color:#ffffff;" onkeypress="return isNumber(event)" maxlength="11">
						 </div>			
					</td>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;Birth date:</td>
					<td>
						<div class="form-group">
						    <input type="date" class="form-control" id="bd" style="border-color:#ffffff;">
						 </div>			
					</td>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;Email:</td>
					<td>
						<div class="form-group">
						    <input type="email" class="form-control" id="email" placeholder="Enter Email Address" style="border-color:#ffffff;">
						 </div>			
					</td>
				</tr>
				<tr>
					
					<td style="width:150px;"><span style="color:red;">*</span> &nbsp;Username:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="un" placeholder="Enter Username" style="border-color:#ffffff;">
						 </div>			
					</td>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;Password:</td>
					<td>
						<div class="form-group">
						    <input type="password" class="form-control" id="pw" placeholder="Enter password" style="border-color:#ffffff;">
						 </div>			
					</td>
					<td style="width:110px;"><span style="color:red;">*</span> &nbsp;Retype Password:</td>
					<td>
						<div class="form-group">
						    <input type="password" class="form-control" id="cpw" placeholder="Confirm password" style="border-color:#ffffff;">
						 </div>			
					</td>
				</tr>
				<tr>
					
					<td style="width:150px;"><span style="color:red;">*</span> &nbsp;User type:</td>
					<td colspan="5">
						<div class="form-group">
						    <select class="form-control" id="utype" style="border-color:#ffffff;">
						    	<option></option>
						    	<option value="0">Administrator</option>
						    	<option value="1">Guest</option>
						    	<option value="2">Receiver</option>
						    	<option value="3">Inputter</option>
						    </select>
						 </div>			
					</td>
					
				</tr>
			
				<tr>
					<td colspan="6" align="right">
						<button class="btn btn-primary" id="btnNew"><i class="fa fa-plus"></i>&nbsp;New</button>
						<button class="btn btn-primary" id="btnSave"  onclick="saveUser()"><i class="fa fa-save"></i>&nbsp;Save</button>
						<button class="btn btn-danger" id="btnClose"><i class="fa fa-window-close" onclick="window.location.href='{{ action("PagesController@home") }}' "></i>&nbsp;Close</button>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table table-striped" style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; "  id="rawdata">
			<thead>
				<tr>
					<th>FIRST NAME</th>
					<th>MIDDLE NAME</th>
					<th>LAST NAME</th>
					<th>CONTACT #</th>
					<th>BIRTHDATE</th>
					<th>EMAIL</th>
					<th>USERNAME</th>
					<th>USER TYPE</th>
					<th>DATE LAST LOGIN</th>
					<th>ACTION</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit user details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	
      		
			        <div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-user"></i></span>
					  	</div>
					  <input type="text" class="form-control" id="txtfn" placeholder="Enter Firstname" style="resize: none;" onkeyup="this.value = this.value.toUpperCase();"></input>
					  <input type="hidden" id="userid" />
					</div>

					<hr style="width: 100%;">

					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-user"></i></span>
					  	</div>
					  <input type="text" class="form-control" id="txtmn" placeholder="Enter middlename" style="resize: none;" onkeyup="this.value = this.value.toUpperCase();"></input>
					</div>
				
					<hr style="width: 100%;">
				
					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-user"></i></span>
					  	</div>
					  <input type="text" class="form-control" id="txtln" placeholder="Enter lastname" style="resize: none;" onkeyup="this.value = this.value.toUpperCase();"></input>
					</div>
				
					<hr style="width: 100%;">

					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-mobile"></i></span>
					  	</div>
					  <input type="text" class="form-control" id="txtcontact" placeholder="Contact" style="resize: none;" onkeypress="return isNumber(event)" maxlength="11"></input>
					</div>

					<hr style="width: 100%;">

					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-calendar"></i></span>
					  	</div>
					  <input type="date" class="form-control" id="txtbd" style="resize: none;" ></input>
					</div>

					<hr style="width: 100%;">

					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="far fa-envelope"></i></span>
					  	</div>
					  <input type="text" class="form-control" id="txtmail" placeholder="Email" style="resize: none;" ></input>
					</div>

					<hr style="width: 100%;">

					<div class="input-group">
						<div class="input-group-prepend">
					    <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
					  	</div>
					    <select class="form-control" id="txtutype">
					    	<option></option>
					    	<option value="0">Administrator</option>
					    	<option value="1">Guest</option>
					    	<option value="2">Receiver</option>
						    <option value="3">Inputter</option>
					    </select>
					</div>	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id="btnmodPayment" onclick="updateUser()">Update</button>
	     </div>

  	 
    </div>
  </div>
</div>
<!--end modify-->