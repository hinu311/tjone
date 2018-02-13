<?php
include("header.php");


$obj=new DB_Connect;
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$material = str_replace('\'', '*', $_REQUEST["txt_material"]);
	$category = str_replace('\'', '*', $_REQUEST["dp_category"]);
	
	   	
	if($mode=='insert')
	{
			 $material_insert="insert into material values('','".$category."','".$material."')";
				$res=$obj->insert($material_insert);	
				
				
				 
				if($res==1)
				{
					header("location:fabric.php?msg=".$material." fabric added successfully");
				}
				else
				{
					header("location:fabric.php?msg1=".$material." fabric already exist..");
				}

				
	}
	else if($mode=='update')
	{
		
		 $material_update="update material set name='".$material."',category_id='".$category."' where id='".$_REQUEST["FabricId"]."'";
				$res=$obj->update($material_update);
				
				if($res==1)
				{
					header("location:fabric.php?msg=".$material." fabric Updated successfully");
				}
				else
				{
					header("location:fabric.php?msg1=".$material." fabric Already Exist..");
				}
				
		
	}			
	
}

if($_REQUEST["btn_update"]<>"")
{
	$material = str_replace('\'', '*', $_REQUEST["txt_material"]);
	$category = str_replace('\'', '*', $_REQUEST["dp_category"]);
	
	
			 $material_update="update material set name='".$material."',category_id='".$category."' where id='".$_REQUEST["FabricId"]."'";
				$res=$obj->update($material_update);
				
				if($res==1)
				{
					header("location:fabric.php?msg=".$material." fabric updated successfully");
				}
				else
				{
					header("location:fabric.php?msg1=".$material." fabric already exist..");
				}
	
}
if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
	
			 
				
				$material_del1="SELECT product.* FROM `material`,product WHERE find_in_set(material.id,product.material) and material.id='".$_REQUEST["c_id"]."' group by product.id";
				$res_material_del1=$obj->select($material_del1);
				$num=mysql_num_rows($res_material_del1);
				
				
				 if($num<=0)
				 {
			 
			 		$material_del="delete from material where id ='".$_REQUEST["c_id"]."'";
				
			 $res=$obj->delete($material_del);
			 header("location:fabric.php?msg=fabric deleted successfully");
			 }
			 else
			 {
			 header("location:fabric.php?msg1=You Can't delete this fabric");
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
if(isset($_SESSION["Materialexcel"]))
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
                            <p><?php echo $_SESSION["Materialexcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["Materialexcel"]);
			  
			   } ?>
    
 <!-- function ends -->


     
   <div class="page-head">
                <h3 class="m-b-less">
					Fabric  <a href="uploads/excel/material.xlsx"  class="btn btn-success" style="float:right" download>Download Excel</a>
                </h3>
               
             

            </div>
            
            <div class="wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                          
                            <div class="panel-body">
                                <div class=" form">
                                    <form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="">
									 
                                        
                                        
                                    
                                        
                                        
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Fabric Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_material" name="txt_material"type="text" required />
                                                <input type="hidden" id="FabricId" name="FabricId" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
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
  <div  id="DataGrid" class="row">
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
									Fabric Name
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
							
							$material="select * from material order by id DESC";
							
							$res=$obj->select($material);
							$i=1;
							while($row=mysql_fetch_array($res))
							{
						
							?>
                            
                            <tr>
                                <td>
								<?php echo $i ?>
                                </td>
                                
                                 <td>
								<?php echo str_replace('*', '\'', $row[2]) ?>
                                </td>
								
                  <td><a href="javascript: editdata('<?php echo $row[0] ?>','<?php echo $row[1] ?>','<?php echo $row[2] ?>')" >Edit</a></td>
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
		{	var loc="fabric.php?flg=del&c_id="+c_id;
			
			window.location=loc;
		}
		
	}
	
	function editdata(c_id,cat,mat)
	{				
		$('#FabricId').val(c_id);
		$('#txt_material').val(mat.replace("*", "'"));
		$('#dp_category').val(cat.replace("*", "'"));
		$('#mode').val('update');
		
		
	//	$(".select2-chosen").text(stname);
		
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
				 
	}
	
	
	function resetdata()
	{
		
	window.location="fabric.php";
	}


	</script>

             
			
               

<?php
include("footer.php");
?>