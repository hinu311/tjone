<?php
include("header.php");

$obj=new DB_Connect;
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$banner= str_replace('\'', '*', $_REQUEST["txt_banner"]);
		   	
	if($mode=='insert')
	{
			if($_FILES["img_banner"]["name"] != "")
			{
			$MainFileName=$_FILES["img_banner"]["name"];	
			
			$MainFileName=str_replace(' ','',$MainFileName);	
			
			if (file_exists("uploads/banner/" . $MainFileName)) 
			{				
				$Arr = explode('.',$MainFileName);
				$i=0;
				$MainFileName = $Arr[0].$i.".".$Arr[1];
				while(file_exists("uploads/banner/".$MainFileName))
				{
					$i++;
					$MainFileName = $Arr[0].$i.".".$Arr[1];
				}
				
			}
			/*else
			{
				move_uploaded_file($_FILES["img_banner"]["tmp_name"], "uploads/banner/" . $MainFileName);
			}
			*/
			$banner_insert="insert into banner values('','".$banner."','".$MainFileName."')";
				$res=$obj->insert($banner_insert);	
				
				//echo $str;
				 //exit();
				if($res==1)
				{
					move_uploaded_file($_FILES["img_banner"]["tmp_name"],"uploads/banner/".$MainFileName);
					header("location:banner.php?msg=".$banner." banner added successfully");
				}
				else
				{
					header("location:banner.php?msg1=".$banner." banner already exist..");
				}
			}
			else
			{
				header("location:banner.php?msg1=Please select Image!!");	
			}

				
	}
	else if($mode=='update')
	{
		
		 				
				$banner = str_replace('\'', '*', $_REQUEST["txt_banner"]);
			if($_FILES["img_banner"]["name"] != "") 
			{
					
				$pho1 = $_REQUEST["old_photo"];
				
				unlink("uploads/banner/".$pho1);
				$newfilename=$_FILES["img_banner"]["name"];
				$newfilename=str_replace(' ','',$newfilename);
				if (file_exists("uploads/banner/" . $newfilename)) 
				{				
					$Arr = explode('.',$newfilename);
					$i=0;
					$newfilename = $Arr[0].$i.".".$Arr[1];
					while(file_exists("uploads/banner/".$newfilename))
					{
						$i++;
						$newfilename = $Arr[0].$i.".".$Arr[1];
					}
					
				}
			/*	else
				{
					move_uploaded_file($_FILES["img_banner"]["tmp_name"], "uploads/banner/" . $newfilename);
				}*/
				
				$catalog_update="update banner set banner_name='".$banner."',img='".$newfilename."' where id='".$_REQUEST["bannerid"]."'";
			
				
				
			}
			else
			{
				$banner = str_replace('\'', '*', $_REQUEST["txt_banner"]);
				
	
			 	$banner_update="update banner set banner_name='".$catalog."' where id='".$_REQUEST["catalogid"]."'";
				
			}
				
				
				$res=$obj->update($banner_update);
				
				if($res==1)
				{
					move_uploaded_file($_FILES["img_banner"]["tmp_name"],"uploads/banner/".$newfilename);
					header("location:banner.php?msg=".$banner." banner updated successfully");
				}
				else
				{
					
					header("location:banner.php?msg1=".$banner." banner already exist..");
				}
				
		
	}			
	
}

if($_REQUEST["btn_update"]<>"")
{
	$banner = str_replace('\'', '*', $_REQUEST["txt_banner"]);
	if($_FILES["img_banner"]["name"] != "") 
			{
				
				$pho1 = $_REQUEST["old_photo"];
				
				unlink("uploads/banner/".$pho1);
				$newfilename=$_FILES["img_banner"]["name"];
				$newfilename=str_replace(' ','',$newfilename);
				if (file_exists("uploads/banner/" . $newfilename)) 
				{				
					$Arr = explode('.',$newfilename);
					$i=0;
					$newfilename = $Arr[0].$i.".".$Arr[1];
					while(file_exists("uploads/banner/".$newfilename))
					{
						$i++;
						$newfilename = $Arr[0].$i.".".$Arr[1];
					}
					
				}
				/*else
				{
					move_uploaded_file($_FILES["img_banner"]["tmp_name"], "uploads/banner/" . $newfilename);
				}*/
				
				$banner_update="update banner set banner_name='".$banner."',img='".$newfilename."' where id='".$_REQUEST["bannerid"]."'";
			
				
				
			}
			else
			{
				$banner = str_replace('\'', '*', $_REQUEST["txt_banner"]);
				
	
			 	
				$banner_update="update banner set banner_name='".$banner."' where id='".$_REQUEST["bannerid"]."'";
				
			}
			$res=$obj->update($banner_update);
				
				if($res==1)
				{
					move_uploaded_file($_FILES["img_banner"]["tmp_name"],"uploads/banner/".$newfilename);
					header("location:banner.php?msg=".$banner." banner updated successfully");
				}
				else
				{
					
					header("location:banner.php?msg1=".$banner." banner already exist..");
				}
				
			 	
	
}
if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
	
			 $banner_del="delete from banner where id ='".$_REQUEST["c_id"]."'";
			 
			  $res=$obj->delete($banner_del);
			  unlink('uploads/banner/'.$_REQUEST["img"]);
				
			
				 if($res==1)
				 {
			 header("location:banner.php?msg=banner deleted successfully");
			 }
			 else
			 {
			 header("location:banner.php?msg1=You Can't delete this banner");
			 }
				
				
	
}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function(e) {
   // alert("hii");
	$(document).keydown(function(e) 
		{
    		// ESCAPE key pressed
			if (e.keyCode == 27) {
				//window.close();
				hidemessage();
			}
	});	
});
  
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#PreviewImage').attr('src', e.target.result);
					document.getElementById("PreviewImage").hidden=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>          


 
      <script type="text/javascript">

	function deletedata(c_id,img)
	{

		if(confirm("Are you sure to delete data?"))
		{	var loc="banner.php?flg=del&c_id="+c_id+"&img="+img;
			
			window.location=loc;
		}
		
	}
	
	function editdata(c_id,cat,imag)
	{				
		$('#bannerid').val(c_id);
		
		$('#txt_banner').val(cat.replace("*", "'"));
		
		$('#mode').val('update');
		
		
		$("#PreviewImage").attr("src","uploads/banner/"+imag);
		
		$("#old_photo").val(imag);
		document.getElementById("PreviewImage").hidden=false;
		
		
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
				 
	}
	
	
	function resetdata()
	{
		
	window.location="banner.php";
	}

	</script>
    
   <script type="text/javascript">
 
 				  	  	// Popup functions start
		function gridredirect()
		{
			window.location="#DataGrid";
		}
		  
		

		function hidemessage()
		{
				$("#ExcelMessage").attr("aria-hidden","true");
				$("#ExcelMessage").removeClass("in");	
				$("#ExcelMessage").removeAttr("style");
				window.location="#DataGrid";
		}
	
	//pop up function ends
</script>
 
          <!-- Excel sheet insertion session mesages from index1. php function starts-->
     <?php
if(isset($_SESSION["bannerExcel"]))
{
	echo "<script>
			  			gridredirect();
			  
			  </script>";
 ?>
              
              <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ExcelMessage" class="modal fade in" style="display:block;overflow:scroll;">
                  <div class="modal-dialog" >
                      <div class="modal-content">
                      	
                        <div id="forget"  >
                          <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" onclick="hidemessage();" aria-hidden="true">&times;
                              </button>
                              <h4 class="modal-title">Information</h4>
                          </div>
                          <div class="modal-body">
                            <p><?php echo $_SESSION["bannerExcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["bannerExcel"]);
			  
			   } ?>
    
 <!-- function ends -->
 
    
    
    

   <div class="page-head">
                <h3 class="m-b-less">
					Banner  <a href="uploads/excel/banner.xlsx"  class="btn btn-success" style="float:right" download>Download Excel</a>
                </h3>
                
             

            </div>
          
            <div class="wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                          
                            <div class="panel-body">
                                <div class=" form">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="" enctype="multipart/form-data">
									 
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Banner Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_banner" name="txt_banner"type="text" required />
                                                                         
                                                <input type="hidden" id="bannerid" name="bannerid" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
											</div>									
                                        </div>
                                         <div class="panel-body">
                                <div class=" form">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="">
									 
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Image*</label>
                                            <div class="col-lg-9 col-md-8">
           
                                                <input id="img_banner" name="img_banner"  class="btn btn-success" type="file"  onchange="readURL(this);">
                                               
                                                <img id='PreviewImage' name="PreviewImage" src=""  height="100" width="120" hidden="true">
                                         	<input type="hidden" id="old_photo" name="old_photo" value="" />
                                               
											</div>									
                                        </div>
	                                    	
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">     
                                                <button class="btn btn-success" value="submit" id="btn_submit" name="btn_submit" type="submit"> Save </button>
                                                <button class="btn btn-success hidden"  value="update" id="btn_update" name="btn_update" type="submit" >Update</button>
                                                <button class="btn btn-default" type="button" onclick="resetdata()">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
  <div id="DataGrid" class="row">
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
									Banner Name
                                </th>
								
                                <th>
									Image
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
							
							$banner="Select * from banner order by id DESC ";
							
							$res=$obj->select($banner);
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
								<td><?php echo '<img src="uploads/banner/'.$row[2].'"  height="65" width="100" >'; ?>
								  <input type="hidden" name="old_photo" id="old_photo"  value="<?php echo $row[2]; ?>" />
                                </td>
                  <td><a href="javascript: editdata('<?php echo $row[0] ?>','<?php echo $row[1] ?>','<?php echo $row[2] ?>')" >Edit</a></td>
  							   <td ><a href="javascript: deletedata('<?php echo $row[0] ?>','<?php echo $row[2] ?>')" >Delete</a></td>
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
                
            
			
               

<?php
include("footer.php");
?>