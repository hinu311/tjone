<!DOCTYPE html>
<html lang="en">
<?php error_reporting(0); ?>
<?php
if($_REQUEST["msg"]<>"")
{	
?>
	<script type="text/javascript">
	alert('<?php echo $_REQUEST["msg"]; ?>');	
	</script>
<?php
}
?>
<!-- Mirrored from thevectorlab.net/slicklab/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Apr 2015 08:56:13 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Template">
    <meta name="keywords" content="admin dashboard, admin, flat, flat ui, ui kit, app, web app, responsive">
    <link rel="shortcut icon" href="img/ico/favicon3.png">
    <title>TJ ONE CONSTRUCTION LOGIN</title>

    <!-- Base Styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->


</head>

  <body class="login-body">

      <div class="login-logo">
          <!--<img src="uploads/image_20160101114151.jpg" style="height:130px;width:200px" alt=""/>-->
		<h1 style="color:#FFF;">TJ ONE CONSTRUCTION</h1>
      </div>

      <h2 class="form-heading">login</h2>
                                       

      <div class="container log-row">
          <form class="form-signin" action="Process_login.php">
              <div class="login-wrap">
                  <input type="text" name="username" class="form-control" autocomplete="off" placeholder="User ID" autofocus required>
                  <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
                  <input type="submit" class="btn btn-lg btn-success btn-block"  name="LoginButton" value="Login"/>
                 <!-- <a  data-toggle="modal" href="#forgotPass" onClick="callforget()"> Forgot Password?</a>-->
              </div>
              <!-- Modal -->
              <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="forgotPass" class="modal fade">
                  <div class="modal-dialog" >
                      <div class="modal-content">
                      	
                        <div id="forget" >
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title">Forgot Password ?</h4>
                         	 
                          </div>
                          <div class="modal-body">
                              <p>Enter Your User Name To Get Your Password...</p>
                              <input type="text" name="ForgetUser" id="ForgetUser" placeholder="User Name..." autocomplete="off" class="form-control placeholder-no-fix" value="" autofocus >

                          </div>
                          <div class="modal-footer">
                              <input name="Cancel" data-dismiss="modal" value="Cancel" class="btn btn-default" type="button" />
                              <input name="Forget" value="Get Password" class="btn btn-success" type="button" onClick="displaynone()" />
                          </div>
                          </div>
                          
                          <div id="forgetmessage" style="display:none">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title">Password ...</h4>
                          </div>
                          <div class="modal-body">
                              <P ID="pd"></P>
                          </div>
                          <div class="modal-footer">
                              <input name="Cancel" data-dismiss="modal" value="Cancel" class="btn btn-default" type="button" />

                          </div>
                          </div>
                          
                      </div>
                  </div>                  
              </div>
              <!-- modal -->

		

          </form>
     	<!--<a href="forgotpass.php"><center><h4>Forgotten your password?</h4></center></a>-->
		
      </div>


      <!--jquery-1.10.2.min-->
      <script src="js/jquery-1.11.1.min.js"></script>
      <!--Bootstrap Js-->
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jrespond..min.html"></script>
<script type="text/javascript">
	
	
	function displaynone()
	{
		var usr=document.getElementById("ForgetUser").value;
	//	 $("#city").html('');
	 var dataString = 'state='+usr ;
	$.ajax({
		type: "POST",
		url: "KalashData.php?action=forgot_pass",
		data: dataString,
		cache: false,
		success: function(result){
                 	//alert(result);
				//		$("#forgotPass").html("<p></p>");  
				document.getElementById("forget").style.display='none';
	document.getElementById("forgetmessage").style.display='block';
	document.getElementById("pd").innerHTML=result;
						//$("#forgetmessage").append("hijih"); 
						
			
		}
	});
	}	
	function callforget()
	{
		//alert("call");
		document.getElementById("forget").style.display='block';
		document.getElementById("ForgetUser").value='';
		document.getElementById("ForgetUser").focus();
	document.getElementById("forgetmessage").style.display='none';				
	}	
</script>
  </body>

</html>