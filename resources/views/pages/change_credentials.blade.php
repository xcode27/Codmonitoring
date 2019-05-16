@extends('layout.app')
<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">
$(document).ready(function(){
	checkUserControl();
});


function updateCredentials(){
	

	var oldun = $('#oun').val();
	var oldpw = $('#opw').val();
	var newun = $('#nun').val();
	var newpw = $('#npw').val();
	

	if(oldun == ''){
		alert('Old Username is required');
		return false;
	}

	if(oldpw == ''){
		alert('Old Password is required');
		return false;
	}

	if(newun == ''){
		alert('New Username is required');
		return false;
	}

	if(newpw == ''){
		alert('New Password is required');
		return false;
	}

	if($('#npw').val().length < 4){
		alert('Password must atleast 4 characters !')
		return false;
	}



	  $.ajax({
          type: 'POST',
          dataType : 'json',
           beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer ' + getToken ); },
          url:"http://192.168.1.55:8002/api/register?module=update_credential&oldun="+oldun+"&oldpw="+oldpw+"&newun="+newun+"&newpw="+newpw,

         success: function( msg ) {
                   var data = jQuery.parseJSON(JSON.stringify(msg));

                   if(data.status != 'Authorization Token not found'){

                        if(data.errors){
                            alert(data.errors);
                            return false;
                        }

                       if(data.status == 'error'){
                            alert(data.message);
                       }else{
                            alert('User successfully saved.');
                       }
                     }else{
                        alert('You are not allowed to create module.! Authorization Token not found.');
                     }
          }
       }); 
	

	
}



</script>
@section('content')
 <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Change Username/Password</a>
      </li>
 </ol>
 <input type="hidden" id="moduleid" value="{{$mod_id}}">
<center>
		<table class="table">
			
			<tbody>
				<tr>
					<td style="width:160px;"><span style="color:red;">*</span> &nbsp;Old Username&nbsp;:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="oun" placeholder="Enter Old user name" >
						 </div>			
					</td>
				</tr>
				<tr>
					<td style="width:160px;"><span style="color:red;">*</span> &nbsp;Old Password&nbsp;:</td>
					<td>
						<div class="form-group">
						    <input type="password" class="form-control" id="opw" placeholder="Enter Old Password" >
						 </div>			
					</td>
				</tr>
				<tr>
					<td style="width:160px;"><span style="color:red;">*</span> &nbsp;New Username&nbsp;:</td>
					<td>
						<div class="form-group">
						    <input type="text" class="form-control" id="nun" placeholder="Enter New user name" >
						 </div>			
					</td>
				</tr>
				<tr>
					<td style="width:160px;"><span style="color:red;">*</span> &nbsp;New Password&nbsp;:</td>
					<td>
						<div class="form-group">
						    <input type="password" class="form-control" id="npw" placeholder="Enter New Password" >
						 </div>			
					</td>
				</tr>
				<tr>
					<td colspan="6" align="right">
						<button class="btn btn-primary" id="btnSave"  onclick="updateCredentials()"><i class="fa fa-save"></i>&nbsp;Save</button>
						<button class="btn btn-danger" id="btnClose"><i class="fa fa-window-close" onclick="window.location.href='{{ action("PagesController@home") }}' "></i>&nbsp;Close</button>
					</td>
				</tr>
			</tbody>
		</table>

		
</center>
@endsection


<!--end modify-->