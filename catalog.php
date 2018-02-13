<?php
include("header.php");
$obj=new DB_Connect;
$Message="";
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$catalog= str_replace('\'', '*', $_REQUEST["txt_catalog"]);		   	
	if($mode=='insert')
	{
		if($_FILES["img_catalog"]["name"] != "")
		{
		
		$MainFileName=$_FILES["img_catalog"]["name"];	
		$MainFileName=str_replace(' ','',$MainFileName);	
		$Arr = explode('.',$MainFileName);
		$MainFileName = $Arr[0].time().".".$Arr[1];
		//echo $MainFileName;exit();
		//move_uploaded_file($_FILES["img_catalog"]["tmp_name"], "uploads/catalog/" . $MainFileName);
		
		
		/*if (file_exists("uploads/catalog/" . $MainFileName)) 
		{				
			$Arr = explode('.',$MainFileName);
			$i=0;
			$MainFileName = $Arr[0].$i.".".$Arr[1];
			while(file_exists("uploads/catalog/".$MainFileName))
			{
				$i++;
				$MainFileName = $Arr[0].$i.".".$Arr[1];
			}
			
		}
		else
		{
			move_uploaded_file($_FILES["img_catalog"]["tmp_name"], "uploads/catalog/" . $MainFileName);
		}	*/		
		$catalog_insert="insert into catalog values(NULL,'".$catalog."','".$MainFileName."')";
		
		$res=$obj->insert($catalog_insert);
		
		if($res==1)
		{	
			move_uploaded_file($_FILES["img_catalog"]["tmp_name"],"uploads/".$MainFileName);
			header("location:catalog.php?msg=".$catalog." Catalogue added successfully");
		}
		else
		{
			header("location:catalog.php?msg1=".$catalog." Catalogue already exist..");
		}
		}
		else
		{
			header("location:catalog.php?msg1=Please Select Image!!");
		}
	}
	else if($mode=='update')
	{
		$catalog = str_replace('\'', '*', $_REQUEST["txt_catalog"]);
		if($_FILES["img_catalog"]["name"] != "") 
		{
			$pho1 = $_REQUEST["old_photo"];
			unlink("uploads/catalog/".$pho1);
			$newfilename=$_FILES["img_catalog"]["name"];	
			$newfilename=str_replace(' ','',$newfilename);		
			if (file_exists("uploads/catalog/" . $newfilename)) 
			{				
				$Arr = explode('.',$newfilename);
				$i=0;
				$newfilename = $Arr[0].$i.".".$Arr[1];
				while(file_exists("uploads/catalog/".$newfilename))
				{
					$i++;
					$newfilename = $Arr[0].$i.".".$Arr[1];
				}
				
			}
			/*else
			{
				move_uploaded_file($_FILES["img_catalog"]["tmp_name"], "uploads/catalog/" . $newfilename);
			}*/
			$catalog_update="update catalog set name='".$catalog."',img='".$newfilename."' where id='".$_REQUEST["catalogid"]."'";
		}
		else
		{
			$catalog = str_replace('\'', '*', $_REQUEST["txt_catalog"]);
			$catalog_update="update catalog set name='".$catalog."' where id='".$_REQUEST["catalogid"]."'";				
		}
		$res=$obj->update($catalog_update);
		if($res==1)
		{
			move_uploaded_file($_FILES["img_catalog"]["tmp_name"],"uploads/catalog/".$newfilename);
			header("location:catalog.php?msg=".$catalog." Catalogue updated successfully");
		}
		else
		{
			header("location:catalog.php?msg1=".$catalog." Catalogue already exist..");
		}	
	}				
}

if($_REQUEST["btn_update"]<>"")
{
	$catalog = str_replace('\'', '*', $_REQUEST["txt_catalog"]);
	if($_FILES["img_catalog"]["name"] != "") 
	{
		
		$pho1 = $_REQUEST["old_photo"];
		unlink("uploads/catalog/".$pho1);
		$newfilename=$_FILES["img_catalog"]["name"];	
		$newfilename=str_replace(' ','',$newfilename);		
		if (file_exists("uploads/catalog/" . $newfilename)) 
		{				
			$Arr = explode('.',$newfilename);
			$i=0;
			$newfilename = $Arr[0].$i.".".$Arr[1];
			while(file_exists("uploads/catalog/".$newfilename))
			{
				$i++;
				$newfilename = $Arr[0].$i.".".$Arr[1];
			}
			
		}
		/*else
		{
			move_uploaded_file($_FILES["img_catalog"]["tmp_name"], "uploads/catalog/" . $newfilename);
		}*/
		$catalog_update="update catalog set name='".$catalog."',img='".$newfilename."' where id='".$_REQUEST["catalogid"]."'";
	}
	else
	{
		$catalog = str_replace('\'', '*', $_REQUEST["txt_catalog"]);
		$catalog_update="update catalog set name='".$catalog."' where id='".$_REQUEST["catalogid"]."'";
	}
	$res=$obj->update($catalog_update);
	if($res==1)
	{
		move_uploaded_file($_FILES["img_catalog"]["tmp_name"],"uploads/".$newfilename);
		header("location:catalog.php?msg=".$catalog." Catalogue updated successfully");
	}
	else
	{
		header("location:catalog.php?msg1=".$catalog." Catalogue already exist..");
	}
}
if($_REQUEST["flg"]=="del")
{
	extract($_REQUEST);
	
	$catalog_del1="SELECT product.* FROM `catalog`,product WHERE find_in_set(catalog.id,product.catalog) and catalog.id='".$_REQUEST["c_id"]."' group by product.id";
	
				$res_catalog_del1=$obj->select($catalog_del1);
				$num=mysql_num_rows($res_catalog_del1);
				
	
	
	if($num<=0)
	{
		
		
		$level_del1="SELECT level.* FROM `catalog`,level WHERE find_in_set(catalog.id,level.catalog_id) and catalog.id='".$_REQUEST["c_id"]."' group by level.id";
				
				$res_level_del1=$obj->select($level_del1);
				$num1=mysql_num_rows($res_level_del1);
				if($num1<=0)
				{
		
					$material_del="delete from catalog where id ='".$_REQUEST["c_id"]."'";
					$res=$obj->delete($material_del);
					unlink('uploads/catalog/'.$_REQUEST["img"]);
					header("location:catalog.php?msg=Catalogue deleted successfully");
				}
		
	
	else
	{
		header("location:catalog.php?msg1=You Can't delete this Category");
	}
	}
	else
	{
		header("location:catalog.php?msg1=You Can't delete this Category");
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


/*$(document).ready(function(e) {
	alert("in");	
    $("form").submit(function(){
		alert("in form");
        var img = document.getElementById('img_catalog').value;
		alert(img);
		if(img=='')
		{
			alert("Please Select Imge");
			return false;
		}
		else
		{		
			return true;
		}
		
		
    });
	
});
*/
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

	function readURL(input) 
	{
    	if (input.files && input.files[0]) 
		{
        	var reader = new FileReader();
			reader.onload = function (e) {
            $('#PreviewImage').attr('src', e.target.result);
			document.getElementById("PreviewImage").hidden=false;
        	}
			reader.readAsDataURL(input.files[0]);
        }
    }
	function deletedata(c_id,img)
	{
		if(confirm("Are you sure to delete data?"))
		{	
			var loc="catalog.php?flg=del&c_id="+c_id+"&img="+img;			
			window.location=loc;
		}		
	}	
	function editdata(c_id,cat,imag)
	{				
		$('#catalogid').val(c_id);
		$('#txt_catalog').val(cat.replace("*", "'"));
		$('#mode').val('update');
		$("#PreviewImage").attr("src","uploads/catalog/"+imag);
		$("#old_photo").val(imag);
		//$("#img_catalog").val(imag);
		document.getElementById("PreviewImage").hidden=false;
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
	}
	function resetdata()
	{
		window.location="catalog.php";
	}		
	</script>
    
     <!-- Excel sheet insertion session mesages from index1. php function starts-->
     <?php
if(isset($_SESSION["Catalogexcel"]))
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
                            <p><?php echo $_SESSION["Catalogexcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["Catalogexcel"]);
			  
			   } ?>
    
 <!-- function ends -->
     	<div class="page-head">
    									
                                          
                                         	
	                                    	 
                                        	
    									
   	</div>
    <div class="wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                          
                            <div class="panel-body">
                                <div class=" form">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="" enctype="multipart/form-data">									 
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Category Name</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_catalog" name="txt_catalog"type="text" placeholder="Category Name" required />                                                                         
                                                <input type="hidden" id="catalogid" name="catalogid" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
											</div>									
                                        </div>
                                       
                                         
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Category Image</label>
                                            <div class="col-lg-9 col-md-8">
           
                                                <input id="img_catalog" name="img_catalog" class="btn btn-success" type="file" required onchange="readURL(this);"  />
                                                 <img id='PreviewImage' name="PreviewImage" src="" hidden="true" height="100" width="120">
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
                          <!--  <header class="panel-heading ">
                                Convertable Data Table
                                <span class="tools pull-right">
                                    <a class="fa fa-repeat box-refresh" href="javascript:;"></a>
                                    <a class="t-close fa fa-times" href="javascript:;"></a>
                                </span>
                            </header>-->
                                    <table class="table convert-data-table data-table">
                            <thead>
                            <tr>
                                <th>
                                    Serial No.
                                </th>
                                <th>
									Category Name
                                </th>
								
                                <th>
									Image
                                </th>
								
                            	<th>
                                    No.of Image
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
							
							$catalog="Select * from catalog order by id DESC ";
							
							$res=$obj->select($catalog);
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
								<td><?php echo '<img src="uploads/'.$row[2].'"  height="65" width="100" >'; ?>
								  <input type="hidden" name="old_photo" id="old_photo"  value="<?php echo $row[2]; ?>" />
                                </td>
                                <td>
                                	<?php
										
							$countproduct="sELECT count(id) as count_cat FROM gallery where  cid".$row[0];
										$res_countproduct=$obj->select($countproduct);
										$row1=mysql_fetch_array($res_countproduct);
										 if($row1[1]=="")
										 {
											echo "0";
										 }
										 else
										 {
										 echo $row1[1];
										 }
									?>
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