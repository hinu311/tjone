<?php
include("header.php");

$obj=new DB_Connect;
$desg=$_SESSION["desig"];
if($_REQUEST["btn_submit"]<>"")	
{

	$mode = $_REQUEST["mode"];
	$Fname = str_replace('\'', '*', $_REQUEST["txt_fname"]);
	$Lname = str_replace('\'', '*', $_REQUEST["txt_lname"]);
	$Email = str_replace('\'', '*', $_REQUEST["txt_email"]);
	$UserName = str_replace('\'', '*', $_REQUEST["txt_Uname"]);
	$Mobile = str_replace('\'', '*', $_REQUEST["txt_mobile"]);
	$Utype =   str_replace('\'', '*',$_REQUEST["db_type"]);
	$Password = str_replace('\'', '*', $_REQUEST["txt_pass"]);
	$Status =  str_replace('\'', '*',$_REQUEST["db_status"]);
	
	   	
	if($mode=='insert')
	{
		$UserInsert = "INSERT INTO users (`fname`, `lname`, `emailid`, `uname`, `password`, `mb_no`, `user_typ`, `level`, `status`) VALUES ('".$Fname."', '".$Lname."', '".$Email."', '".$UserName."', '".$Password."', '".$Mobile."', '".$Utype."','".$Status."','1')";
			 
				$res=$obj->insert($UserInsert);	
				
				
				if($res==1)
				{
					header("location:manage_user.php?msg= User added successfully");
				}
				else
				{
					header("location:manage_user.php?msg1=User already exist..");
				}

				
	}
	else if($mode=='update')
	{
		
		$utype =   str_replace('\'', '*',$_REQUEST["db_type"]);
	$status =  str_replace('\'', '*',$_REQUEST["db_status"]);
	

	
			 $users_update="update users set user_typ='".$utype."',level='".$status."' where id='".$_REQUEST["Areaid"]."'";
				$res=$obj->update($users_update);
				
				if($res==1)
				{
					header("location:manage_user.php?msg= User information updated successfully");
				}
				else
				{
					header("location::manage_user.php?msg1= User information already exist..");
				}
				
		
	}			
	
}

if($_REQUEST["btn_update"]<>"")
{
	$utype =   str_replace('\'', '*',$_REQUEST["db_type"]);
	$status =  str_replace('\'', '*',$_REQUEST["db_status"]);
	
	$Fname = str_replace('\'', '*', $_REQUEST["txt_fname"]);
	$Lname = str_replace('\'', '*', $_REQUEST["txt_lname"]);
	$Email = str_replace('\'', '*', $_REQUEST["txt_email"]);
	$Mobile = str_replace('\'', '*', $_REQUEST["txt_mobile"]);
	
			 $user_update="update users set user_typ='".$utype."',level='".$status."',fname='".$Fname."',lname='".$Lname."',emailid='".$Email."',mb_no='".$Mobile."' where id='".$_REQUEST["Areaid"]."'";
				$res=$obj->update($user_update);
				
				if($res==1)
				{
					header("location:manage_user.php?msg=  User information updated successfully");
				}
				else
				{
					header("location::manage_user.php?msg1= User information already exist..");
				}
	
}
if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
	
			 $users_del="delete from users where id ='".$_REQUEST["c_id"]."'";
				
			 $res=$obj->delete($users_del);
				 if($res==1)
				 {
			 header("location:manage_user.php?msg=User information deleted successfully");
			 }
			 else
			 {
			 header("location:manage_user.php?msg1=You can't delete this user");
			 }
				
				
	
}

?>

 
     
   <div class="page-head">
                <h3 class="m-b-less">
					Manage User
                </h3>
               
             

            </div>
           
            <div class="wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                          
                            <div class="panel-body">
                                <div class=" form">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="">
                                        <!-- First Name-->
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">First Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_fname" name="txt_fname"type="text" required />
                                                <input type="hidden" id="Areaid" name="Areaid" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
											</div>									
                                        </div>
                                        
                                        <!-- Last Name-->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Last Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_lname" name="txt_lname"type="text" required />
                                                
											</div>									
                                        </div>
                                        
                                        <!-- email-->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Email*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_email" name="txt_email"type="text" required />
                                               
											</div>									
                                        </div>
                                        
                                        <!-- User Name-->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">User Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_Uname" name="txt_Uname"type="text" required />
                                                
											</div>									
                                        </div>
                                        
                                        <!-- Password -->
                                         <div class="form-group " id="passDiv">
                                            <label for="cname" class="control-label col-lg-2">Password*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_pass" name="txt_pass" type="password"  required onchange="check_pass()"/>
                                                
											
                                            </div>									
                                       			 <div id="confirm_msg1" class="col-lg-9 col-md-8" style="margin-left:17%;">
                                                 </div>
                                        </div>
                                        
                                        <!-- CPassword-->
                                         <div class="form-group " id="passDiv1">
                                            <label for="cname" class="control-label col-lg-2">Re-type Password*</label>
                                            <div class="col-lg-9 col-md-8">
               <input class=" form-control" id="txt_cpass" name="txt_cpass" type="password" required  onchange="check_pass()"/>
                                                
											</div>	
                                            	 <div id="confirm_msg" class="col-lg-9 col-md-8" style="margin-left:17%;">
                                        </div>						
                                        </div>
                                        <!-- mobile no -->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Mobile No*</label>
                                            <div class="col-lg-9 col-md-8">
                                        
                                               
											<input class=" form-control" maxlength="10" minlength="10" id="txt_mobile" name="txt_mobile"type="text" pattern=".{10,10}" required onkeypress="return isNumberKey(event)" />
                                            </div>									
                                        </div>
                                        
                                        <!-- Type-->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2"> User Type*</label>
                                            <div class="col-lg-9 col-md-8">
                                            
                                            <select name="db_type" id="db_type" class="form-control" required>
                                                    <option value="">Select  Type</option>
                                                    <option value="user" selected="selected">user</option>
													<?php if($_SESSION["desig"]=="sa")
													{
														echo "<option value='admin'>admin</option>";
													}?>                                                    
                                                    
                                                    
                                                    
			                          
                            					</optgroup>
                        					</select>

                                            </div>									
                                        </div>
                                        
                                        <!-- Status-->
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Level*</label>
                                            <div class="col-lg-9 col-md-8">
                                                 
                                               											
                                            	<select name="db_status" id="db_status" class="form-control" required>
                                                    <option value="">Select Level</option>
                                                    <?php
				
											$dp_level="select * from level";
											
											
											$res=$obj->select($dp_level);
			
				
											while($row3=mysql_fetch_array($res))
												{
					
													$level=str_replace('"', '\'', $row3[1]);
										?>
        
        								<option value="<?php echo $row3[0]?>"><?php echo $level?> </option>
        
        
        								<?php
			
										}
										?>
                                                    		                          
	                            					
                        						 </select>
                                               

                                            </div>									
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">     
                                 <button class="btn btn-success" value="btn_submit" id="btn_submit" name="btn_submit" type="submit"> Save </button>
                          <button class="btn btn-success hidden"  value="btn_update" id="btn_update" name="btn_update" type="submit" >Update</button>
                                                <button class="btn btn-default" type="button" onclick="resetdata()">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
 
 
  <div class="row">
                      <div class="row"  style="overflow:scroll">
                    <div class="col-sm-12">
                        <section class="panel">
                         
                                    <table class="table convert-data-table data-table">
                            <thead>
                            <tr>
                                <th>
                                    Serial No.
                                </th>
                                <th>
									First Name
                                </th>
                                <th>
									Last Name
                                </th>
                                <th>
									Email Id
                                </th>
                                <th>
									User Name
                                </th>
                               
                                <th>
									Mobile No.
                                </th>
                                <th>
									Type
                                </th>
                                <th>
									Level
                                </th>
                                <th>
									Status
                                </th>
                                
								
                                
								<th>
                                    Edit
                                </th>
                                <th>
									Delete
                                </th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <?php
							
							if($_SESSION["desig"]=="sa")
							{
								$manage="select u1.id,u1.fname,u1.lname,u1.emailid,u1.uname,u1.mb_no,u1.user_typ,u1.level,l1.id,l1.user_level,u1.status from users u1,level l1 where u1.level=l1.id and u1.user_typ !='sa' order by u1.id DESC";
							}
							else if ($_SESSION["desig"]=="admin")
							{
								$manage="select u1.id,u1.fname,u1.lname,u1.emailid,u1.uname,u1.mb_no,u1.user_typ,u1.level,l1.id,l1.user_level,u1.status from users u1,level l1 where u1.level=l1.id and u1.user_typ != 'sa' and u1.user_typ != 'admin' order by u1.id DESC";
							}
							//echo $manage;
							
							$res=$obj->select($manage);
							
							
							
							
							$i=1;
							
							
							
							while($row=mysql_fetch_array($res))
							{
						
								
							?>
                            
                            <tr>
                                <td>
								<?php echo $i ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[1]) ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[2]) ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[3]) ?>
                                </td>
								<td>
								<?php echo str_replace('*', '\'', $row[4]) ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[5]) ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[6]) ?>
                                </td>
								
                                <td>
								<?php echo str_replace('*', '\'', $row[9]) ?>
                                </td>

								 <td><a href="javascript: ch_status('<?php echo $row[0] ?>')" id="<?php echo $row[0] ?>">
	  							 <?php 
	  								 if($row[10]=='1')
	  									 {
		  										 echo "Disable";
	   									}
	   									else
	  									 {
		  											 echo "Enable";
	   									}															
	   
	   

 ?>
       </a></td>

								
                  <td><a href="javascript: editdata('<?php echo $row[0] ?>','<?php echo $row[1] ?>','<?php echo $row[2] ?>','<?php echo $row[3] ?>','<?php echo $row[4] ?>','<?php echo $row[5] ?>','<?php echo $row[6] ?>','<?php echo $row[8] ?>')" >Edit</a></td>
  							   <td ><a href="javascript: deletedata('<?php echo $row[0] ?>')" >Delete</a></td>
                            </tr>
                           <?php
						   $i++;
							}
					
						   ?>
                           
                            </tbody>
                            </table>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
                
                
 <script type="text/javascript">

	function deletedata(c_id)
	{

		if(confirm("Are you sure to delete data?"))
		{	var loc="manage_user.php?flg=del&c_id="+c_id;
			
			window.location=loc;
		}
		
	}
	
	function editdata(c_id,fname,lname,email,uname,mno,type,status)
	{				
		$('#Areaid').val(c_id);
		$('#txt_fname').val(fname.replace("*", "'"));
		
		$('#txt_lname').val(lname.replace("*", "'"));
		
		$('#txt_email').val(email.replace("*", "'"));
		
		$('#txt_mobile').val(mno.replace("*", "'"));
		
		$('#db_type').val(type.replace("*", "'"));
		$('#db_status').val(status.replace("*", "'"));
		$('#txt_Uname').val(uname.replace("*", "'"));
		document.getElementById("txt_Uname").readOnly = true;
		

		
		
		document.getElementById("passDiv").hidden=true;
		document.getElementById("passDiv1").hidden=true;
		
		
		
		
		$('#mode').val('update');
		
		
	//	$(".select2-chosen").text(stname);
		
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
				 
	}
	
	
	function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	function resetdata()
	{
		
	window.location="manage_user.php";
	}


	function check_pass()
	{
			//alert("hello");
			var password=document.getElementById('txt_pass').value;
			var cpassword=document.getElementById('txt_cpass').value;
			 
			if(cpassword==password)
			{
				$('#confirm_msg').html("<font color='green'>Password match</font>");
				 
			}
			else
			{
				
				 $('#confirm_msg').html("<font color='red'>Password doesn't match</font>");
				 document.getElementById("txt_cpass").value="";
			}
	}
	
	
	function ch_status(id)
	{
	if(confirm("Do You want to change Status of user?"))
	{
		var String = 'bid='+ id;
	//alert(String);
	
			  $.ajax({
          type: "POST",
          url: "KalashData.php?action=change_status",
          data: String,
          cache: false,
          success: function(result){
                //  alert(result);
				
				 	//document.getElementById(id).innerHTML = result;
				
					window.location="manage_user.php?msg=status updated succesfully!";			  
				  
		  }
			  });
		
	}
}


	</script>

             
			
               

<?php
include("footer.php");
?>