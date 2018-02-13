<?php
include("header.php");


$obj=new DB_Connect;
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$color = str_replace('\'', '*', $_REQUEST["txt_color"]);
	$colorcd = str_replace('\'', '*', $_REQUEST["txt_colorcd"]);
	   	
	if($mode=='insert')
	{
			 $color_insert="insert into color values('','".$color."','".$colorcd."')";
				
				$res=$obj->insert($color_insert);	
				if($res==1)
				{
					header("location:color.php?msg=".$color." color added successfully");
				}
				else
				{
					header("location:color.php?msg1=".$color." color already Exist..");
				}

				
	}
	else if($mode=='update')
	{
		
	
	
			 $color_update="update color set name='".$color."',colorcode='".$colorcd."' where id='".$_REQUEST["colorid"]."'";
				$res=$obj->update($color_update);
				
				if($res==1)
				{
					header("location:color.php?msg=".$color." color updated successfully");
				}
				else
				{
					header("location:color.php?msg1=".$color." color already exist..");
				}
	}
	
}

if($_REQUEST["btn_update"]<>"")
{
	$color = str_replace('\'', '*', $_REQUEST["txt_color"]);
	$colorcd = str_replace('\'', '*', $_REQUEST["txt_colorcd"]);
	
	
			 $color_update="update color set name='".$color."',colorcode='".$colorcd."' where id='".$_REQUEST["colorid"]."'";
				$res=$obj->update($color_update);
				
				if($res==1)
				{
					header("location:color.php?msg=".$color." color updated successfully");
				}
				else
				{
					header("location:color.php?msg1=".$color." color already exist..");
				}
	
}
if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
			
			
	
			 $color_del="delete from color where id ='".$_REQUEST["c_id"]."'";
				
			 $res=$obj->delete($color_del);
				 if($res==1)
				 {
			 header("location:color.php?msg=color deleted successfully");
			 }
			 else
			 {
			 header("location:color.php?msg1=You Can't delete this color");
			 }
				
				
	
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript" >
		
		 $(document).ready(function(e) {
 //  alert("hii");
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
if(isset($_SESSION["Colorexcel"]))
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
                            <p><?php echo $_SESSION["Colorexcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["Colorexcel"]);
			  
			   } ?>
    
 <!-- function ends -->

   
	

   <div class="page-head">
                <h3 class="m-b-less">
					Colour <a href="uploads/excel/color.xlsx"  class="btn btn-success"  style="float:right" download>Download Excel</a>
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
                                            <label for="cname" class="control-label col-lg-2">Colour*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_color" name="txt_color"type="text" required />
                                                <input type="hidden" id="colorid" name="colorid" value="" >
                                                <input type="hidden" id="mode" name="mode" value="insert" >
											</div>									
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Colour Code*</label>
                                            <div class="col-lg-9 col-md-8">
                                             <input class="jscolor"  id="txt_colorcd" name="txt_colorcd"type="text" >
                                               
                                               
                                              
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
									 colour
                                </th>
								
                                <th>
									 colour code
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
							
							$color="Select * from color order by id DESC ";
						
							
							$res=$obj->select($color);
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
                                <?php
									if($row[0]=="1")
									{?>
                                    	<!--<td style="background-image:url(uploads/multicolor1.png)">-->
                                       <td style="width:200px;"> <img src="uploads/multicolor1.png" style="width:50px"></td>
									<?php
									}
									else
									{
								?>
                                	<td style="background-color:<?php echo "#".str_replace('*', '\'', $row[2]) ?>">
								<?php echo str_replace('*', '\'', $row[2]) ?>
                                
                                <?php
									}
								?>
								</td>
                                     <td>
									 <?php
									 if($row[0]!="1")
									 {
									 ?>             
                               <a href="javascript: editdata('<?php echo $row[0] ?>','<?php echo $row[1] ?>','<?php echo $row[2] ?>')" >Edit</a></td>
  							  
  	                             <?php
									 }
									 
								 ?>
                                 
                                 <td>
                                 <?php 
								 if($row[0]!="1")
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
			  
			  	  	// Popup functions start
	
	
	//pop up function ends


	function deletedata(c_id)
	{

		if(confirm("Are you sure to delete data?"))
		{	var loc="color.php?flg=del&c_id="+c_id;
			
			window.location=loc;
		}
		
	}
	
	function editdata(c_id,color,colorcd)
	{				
		
		$('#colorid').val(c_id);
		$('#txt_color').val(color.replace("*", "'"));
		$('#txt_colorcd').val(colorcd.replace("*", "'"));
		$('#txt_colorcd').attr("style","background:#"+colorcd);
		$('#mode').val('update');
		
		
	
		
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
				 
	}
	
	
	function resetdata()
	{
		
	window.location="color.php";
	}


			
 </script> 
 <!-- Script for color picker    -->             
<script src="jscolor.js"></script>
<?php
include("footer.php");
?>