
<?php 
	include("header.php");
	$obj=new DB_Connect;
	
	$uname=$_SESSION["user"];
	

if($_REQUEST["btnsubmit"]<>"")
{
	
	$query = "Select * from users where uname = '".$uname."' and password = '".str_replace('\'', '*', $_REQUEST["Old"])."'";
	
	$res  = $obj->select($query);
	
	$row = mysql_fetch_array($res);
	if($row>0)
	{
		
		$qr = "update users set password = '".str_replace('\'', '*', $_REQUEST["Re"])."' where uname = '".$uname."'";
		if(mysql_query($qr))
		{
			
			header("location:home.php?msg=Your Password has been Successfully Changed..");
		}
	}
	else
	{
			
		header("location:ChangePD.php?msg1=Your Old Doesn't Matched..!");
	}
	
}
?>
<?php
/*if($_REQUEST["msg"]<>"")
{
?>
<div class="alert alert-success fade in">
    <button class="close close-sm" type="button" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>
Message : 
    </strong>
<?php echo $_REQUEST["msg"] ?>
</div>
<?php
}*/
?>
<form method="post" action="">
<div class="wrapper">

	<br><br><br><br><br><br><br><br>
	<div class="row">
    	<div class="col-lg-3">
        </div>
    	<div class="col-lg-6">
			<section class="panel">
            	<div class="panel-body">
                	<div class="row">
                		<div class="col-lg-4">
                        	<center>
                			<label for="Old">Old Password</label>
                            </center>
                		</div>
                		<div class="col-lg-8">
                        	<center>
                			<input class=" form-control" id="Old" name="Old" minlength="2" type="password"  />
                            </center>
                		</div>
                	</div>
                    <br/>
                    <div class="row">
                		<div class="col-lg-4">
                        	<center>
                			<label for="Old">New Password</label>
                            </center>
                		</div>
                		<div class="col-lg-8">
                        	<center>
                			<input class=" form-control" id="New" name="New" minlength="2" type="password"  />
                            </center>
                		</div>
                	</div>
                    <br/>
                    <div class="row">
                		<div class="col-lg-4">
                        	<center>
                			<label for="Old">Re-Enter Password</label>
                            </center>
                		</div>
                		<div class="col-lg-8">
                        	<center>
                			<input class=" form-control" id="Re" name="Re" minlength="2" type="password" />
                            </center>
                		</div>
                	</div>
                    <br/>
                    <div class="row">
                		<div class="col-lg-12">
                			<button class="btn btn-success" value="submit" id="btnsubmit" name="btnsubmit" onClick=" return getpa();" type="submit" style="width:inherit	;"> Change </button>
                		</div>
                	</div>
                </div>
        	</section>
		</div>  
        <div class="col-lg-3">
        </div>         
    </div>
<script type="text/javascript">

function getpa()
{
	var oldd = document.getElementById("Old").value;
	if(oldd!="")
	{
		var  p1 = document.getElementById("New").value;
		var p2 = document.getElementById("Re").value;
		if(p1!="" && p2!="")
		{
			if(p1==p2)
			{				
				return true;
			}
			else
			{
				alert("Passwords Doesn't Matched...!");
				return false;
			}
		}
		else
		{
			alert("Please Enter New Password");
			return false;
		}
	}
	else
	{
		alert("Please Enter Old Password..!");
		return false;
	}
}

/*
$(document).ready(function(){	
	alert("form ready");	
	$('form').submit(function(){	
		var od = $('#Old').val();
		if(od!="")
		{
			var p1=$('#New').val();
			var p2=$('#Re').val();	
			if(p1==p2)
			{
				alert("Password Matched");	
			}
			else
			{
				alert("Your Password Doesn't Match");
				return false;
			}
		}
		else
		{
			alert("Please Enter Old Password");
			return false;
		}		
		return true;
	});
});*/
</script>

</div>

</form>



<?php include("footer.php");?>