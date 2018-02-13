<?php
include("header.php");

$obj=new DB_Connect;
if($_REQUEST["btn_submit"]<>"")
{
	extract($_REQUEST);
	$category = str_replace('\'', '*', $_REQUEST["txt_category"]);		   	
	
				
			for($i=0;$i<count($_FILES["img_category"]["tmp_name"]);$i++){
				
				if($_FILES["img_category"]["name"][$i] != ""){
				$MainFileName=$_FILES["img_category"]["name"][$i];	
				$MainFileName=str_replace(' ','',$MainFileName);	
				$Arr = explode('.',$MainFileName);
				$MainFileName = $Arr[0].time().".".$Arr[1];
				$category_insert="insert into gallery values(NULL,'".$category."','".$MainFileName."')";
				//echo $category_insert;exit();
				$res=$obj->insert($category_insert);	
				move_uploaded_file($_FILES["img_category"]["tmp_name"][$i],"uploads/".$MainFileName);
				}
			}
					
						
			header("location:category.php?msg=Image added successfully");
				
					
		
}

if($_REQUEST["flg"]=="del")
{
			
			extract($_REQUEST);
	
			 $material_del="delete from gallery where id ='".$_REQUEST["c_id"]."'";
			 
			 $res=$obj->delete($material_del);
				
			
				 if($res==1)
				 {
					unlink('uploads/'.$_REQUEST["img"]);
			
					header("location:category.php?msg=Image deleted successfully");
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

	  
	   function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#PreviewImage1').attr('src', e.target.result);
					document.getElementById("PreviewImage1").hidden=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#PreviewImage2').attr('src', e.target.result);
					document.getElementById("PreviewImage2").hidden=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#PreviewImage3').attr('src', e.target.result);
					document.getElementById("PreviewImage3").hidden=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#PreviewImage4').attr('src', e.target.result);
					document.getElementById("PreviewImage4").hidden=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

	function deletedata(c_id,img)
	{

		if(confirm("Are you sure to delete data?"))
		{	var loc="category.php?flg=del&c_id="+c_id+"&img="+img;
				
			
			window.location=loc;
		}
		
	}
	
	
	
	function resetdata()
	{
		
	window.location="category.php";
	}
	
	function add_img()
	{
		alert('hi');
		
	}

	</script>
    
         <!-- Excel sheet insertion session mesages from index1. php function starts-->
     <?php
if(isset($_SESSION["Categoryexcel"]))
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
                            <p><?php echo $_SESSION["Categoryexcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["Categoryexcel"]);
			  
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
									<label for="inputText" class="col-lg-2 control-label">Category</label>
     								    <div class="col-lg-9 col-md-8">
      	                               
                                               
        								<select name="txt_category" id="txt_category"  required style="width:50%" class="form-control " >
        								<option value="" >Select Category</option>
            							<?php
				
											$dp_category="select * from catalog";
											
											
											$res=$obj->select($dp_category);
			
				
											while($row3=mysql_fetch_array($res))
												{
					
													//$category=str_replace('"', '\'', $row3[1]);
										?>
        
        								<option value="<?php echo $row3[0]?>"><?php echo $row3[1]?> </option>
        
        
        								<?php
			
										}
										?>
       								 </select>
      								</div>
									</div>
									<div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Image*</label>
                                            <div class="col-lg-9 col-md-8">
           
                                                <input id="img_category" name="img_category[]"  class="btn btn-success"  type="file" required  onchange="readURL1(this)">
                                                <input id="img_category" name="img_category[]"  class="btn btn-success"  type="file"  onchange="readURL2(this)">
												<input id="img_category" name="img_category[]"  class="btn btn-success"  type="file"  onchange="readURL3(this)">
												<input id="img_category" name="img_category[]"  class="btn btn-success"  type="file"  onchange="readURL4(this)">
                                                
												
												
                                                 <img id='PreviewImage1' name="PreviewImage1" src="" hidden="true" height="100" width="120">
												  <img id='PreviewImage2' name="PreviewImage2" src="" hidden="true" height="100" width="120">
												   <img id='PreviewImage3' name="PreviewImage3" src="" hidden="true" height="100" width="120">
												    <img id='PreviewImage4' name="PreviewImage4" src="" hidden="true" height="100" width="120">
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
									Category Name
                                </th>
								
                                <th>
									Image
                                </th>
							    <th>
									Delete
                                </th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <?php
							
							$category="Select g.*,c.name from gallery g,catalog c where g.cid=c.id order by g.id DESC ";
							
							$res=$obj->select($category);
							$i=1;
							while($row=mysql_fetch_array($res))
							{
						
							?>
                            
                            <tr>
                                <td>
								<?php echo $i ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $row[3]) ?>
                                </td>
								<td><?php echo '<img src="uploads/'.$row[2].'"  height="65" width="100" >'; ?>
								 
                                </td>
                  
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