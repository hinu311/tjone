<?php
include("header.php");
$obj=new DB_Connect;
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$level = str_replace('\'', '*', $_REQUEST["txt_level"]);
	$catalog = str_replace('\'', '*', $_REQUEST["dp_catalog"]);
	$catta="";
	   	
	if($mode=='insert')
	{
			
				for($i=0;$i<sizeof($catalog);$i++)
				{
    								 
					$cataList .= $catta.$catalog[$i];					 
    				$catta = ',';
					
				}
				
				 $material_insert="insert into level values('','".$level."','". $cataList."')";
				 
					
					$res=$obj->insert($material_insert);
				
				if($res==1)
				{
					header("location:level1.php?msg=".$level." Level added successfully");
				}
				else
				{
					header("location:level1.php?msg1=".$level." Level already exist..");
				}

				
	}
	else if($mode=='update')
	{
		$level = str_replace('\'', '*', $_REQUEST["txt_level"]);
	$catalog = str_replace('\'', '*', $_REQUEST["dp_catalog"]);
	
	
				for($i=0;$i<sizeof($catalog);$i++)
				{
    								 
					$cataList .= $catta.$catalog[$i];					 
    				$catta = ',';
					
				}
				
			 $level_update="update level set user_level='".$level."',catalog_id='".$cataList."' where id='".$_REQUEST["levelid"]."'";
				$res=$obj->update($level_update);
				
				if($res==1)
				{
					
					header("location:level1.php?msg=".$level." Level updated successfully");
				}
				else
				{
					
					header("location:level1.php?msg1=".$level." Level already exist..");
				}
		
	}			
	
}

if($_REQUEST["btn_update"]<>"")
{
	$level = str_replace('\'', '*', $_REQUEST["txt_level"]);
	$catalog = str_replace('\'', '*', $_REQUEST["dp_catalog"]);
	
	
				for($i=0;$i<sizeof($catalog);$i++)
				{
    								 
					$cataList .= $catta.$catalog[$i];					 
    				$catta = ',';
					
				}
			 $level_update="update level set user_level='".$level."',catalog_id='".$cataList."' where id='".$_REQUEST["levelid"]."'";
				$res=$obj->update($level_update);
				
				if($res==1)
				{
					
					header("location:level1.php?msg=".$level." Level updated successfully");
				}
				else
				{
					
					header("location:level1.php?msg1=".$level." Level already exist..");
				}
	
}
if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
	
			 $level_del="delete from level where id ='".$_REQUEST["l_id"]."'";
				
			 $res=$obj->delete($level_del);
				 if($res==1)
				 {
			 header("location:level1.php?msg=Level deleted successfully");
			 }
			 else
			 {
			 header("location:level1.php?msg1=You Can't delete this Level");
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
if(isset($_SESSION["Levelexcel"]))
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
                            <p><?php echo $_SESSION["Levelexcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["Levelexcel"]);
			  
			   } ?>
    
 <!-- function ends -->

     
   <div class="page-head">
                <h3 class="m-b-less">
					Level  <a href="uploads/excel/level.xlsx"  class="btn btn-success" style="float:right" download>Download Excel</a>
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
                                            <label for="cname" class="control-label col-lg-2">Level*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_level" name="txt_level"type="text" required />
                                                <input type="hidden" id="levelid" name="levelid" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
											</div>									
                                        </div>
                                        
                                       
                                        
                                        <div class="form-group">
      									<label for="inputText" class="col-lg-2 control-label">Catalogue*</label>
     								    <div class="col-lg-9 col-md-8" id="catadiv">
      	                               
                                        
        
        		<select name="dp_catalog[]" id="dp_catalog"  required style="width:50%" class="form-control " multiple="multiple" >
            							<?php
				
											$dp_catalog="select * from catalog";
											
											
											$res=$obj->select($dp_catalog);
			
				
											while($row2=mysql_fetch_array($res))
												{
					
													$catalog=str_replace('"', '\'', $row2[1]);
										?>
        
        								<option value="<?php echo $row2[0]?>"><?php echo $catalog?> </option>
        
        
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
									Level Name
                                </th>
                                <th>
									Catalogue Name
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
							
							$level="select l1.id,l1.user_level,l1.catalog_id,c1.name from level l1,catalog c1 where l1.catalog_id=c1.id order by l1.id ASC  ";
							
							$res=$obj->select($level);
							$inc=0;
							while($row=mysql_fetch_array($res))
							{
						$inc++;
							?>
                            
                            <tr>
                                <td>
								<?php echo $inc ?>
                                </td>
                                <td>
								
								<?php 
								if($row[0]=="1")
								{
								
								echo str_replace('*', '\'', $row[1]);
								echo "(DefaultLevel)";
								
								}
								else
								{
									echo str_replace('*', '\'', $row[1]);
								}
								?>
                                </td>
                                 <td>
								
								
								<?php
								
								
								$myArray =explode(',', $row[2]);
								//sprint_r($myArray);
								 
								//echo $myArray[1];
								for($i=0;$i<sizeof($myArray);$i++)
								{				
					
									
									$get_arra="SELECT GROUP_CONCAT(t2.name) FROM level as t1 LEFT JOIN catalog as t2 ON find_in_set(t2.id, t1.catalog_id)where t1.catalog_id='".$row[2]."'  group by t1.id ";
									//echo $get_arra;
									$res_get_arra=$obj->select($get_arra);
									//echo $res_get_arra;
									
								}
								 
								 $row1=mysql_fetch_array($res_get_arra);
								 echo str_replace('*', '\'', $row1[0]);
								 ?>
                                </td>
								
                  <td><a href="javascript: editdata('<?php echo $row[0] ?>','<?php echo $row[1] ?>','<?php echo $row[2] ?>')" >Edit</a></td>
  							   <td >
                               <?php
                               if($row[0]!='1')
							   {
								?>
                                <a href="javascript: deletedata('<?php echo $row[0] ?>')" >Delete</a></td>
                                <?php   
								}
							   
							   ?>
                              
                               
                               
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
 

	function deletedata(l_id)
	{

		if(confirm("Are you sure to delete data?"))
		{	var loc="level1.php?flg=del&l_id="+l_id;
			
			window.location=loc;
		}
		
	}
	
	function editdata(c_id,level,catalog_id)
	{				
		$('#levelid').val(c_id);
		$('#txt_level').val(level.replace("*", "'"));
		
		/*if(level=="Level0")
		{
			alert("hello");
			document.getElementById("txt_level").readOnly = true;
		}
		else
		{
			document.getElementById("txt_level").readOnly = false;
		}*/
		
		
		
		var i=0;
		var cata_ids=catalog_id.split(",");
		
	  $('select#dp_catalog option').removeAttr("selected");
		$.each(cata_ids, function(i,e){
	
		$("#dp_catalog option[value='"+e+"']").attr("selected", "selected");
});
		
		//$('#mode').val('update');
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#txt_level').focus();
				 
	}
	
	
	function resetdata()
	{
		
	window.location="level.php";
	}


	</script>

             
			
               

<?php
include("footer.php");
?>