<?php
include("header.php");


	$obj=new DB_Connect;

if($_REQUEST["btn_submit"]<>"")
{
	
	
	extract($_REQUEST);
	
	$material1 = str_replace('\'', '*', $_REQUEST["dp_material"]);
	$catalog1 = str_replace('\'', '*', $_REQUEST["dp_catalog"]);
	$category1 = str_replace('\'', '*', $_REQUEST["dp_category"]);
	$color1 = str_replace('\'', '*', $_REQUEST["chk_color"]);	
	$product1 =str_replace('\'', '*', $_REQUEST["txt_pname"]);
	$desc1 = str_replace('\'', '*', $_REQUEST["txta_desc"]);
	$sku_code1 = str_replace('\'', '*', $_REQUEST["txt_sku_code"]);
	$size = str_replace('\'', '*', $_REQUEST["txt_size"]);
	$cut = str_replace('\'', '*', $_REQUEST["txt_cut"]);
	
	
	$catta="";
	$matta="";
	
	$rad=$_REQUEST["rad"];
	$rad2=$_REQUEST["rad2"];
	 	
	if($mode=='insert')
	
	{
		
		
		if($_FILES["img_product"]["name"] != "")
		{
			
		$MainFileName=$_FILES["img_product"]["name"];	
		$Arr = explode('.',$MainFileName);
		$MainFileName = $product1.".".$Arr[1];		
		$MainFileName=str_replace(' ','',$MainFileName);
		$MainFileName=str_replace('*','',$MainFileName);
		
			
			
		if (file_exists("uploads/products/" . $MainFileName)) 
		{								
			$i=0;
			$MainFileName = $product1.$i.".".$Arr[1];
			while(file_exists("uploads/products/".$MainFileName))
			{
				$i++;
				$MainFileName = $product1.$i.".".$Arr[1];
			}
			
		}
		/*else
		{
			move_uploaded_file($_FILES["img_product"]["tmp_name"], "uploads/products/" . $MainFileName);
		}
*/			
		for($i=0;$i<sizeof($catalog1);$i++)
		{
    		$cataList .= $catta.$catalog1[$i];					 
    		$catta = ',';
		} 
		for($i=0;$i<sizeof($material1);$i++)
		{
    		$mataList .= $matta.$material1[$i];					 
    		$matta = ',';
		}
		
		
		if($rad2=="yes")
		{
		$product_insert="insert into product values('','".$product1."','".$MainFileName."','".$sku_code1."','".$category1."','".$desc1."','".$cataList."','".$mataList."','".$size."','".$cut."','".$rad."','featured')";
		}
		else
		{
			$product_insert="insert into product values('','".$product1."','".$MainFileName."','".$sku_code1."','".$category1."','".$desc1."','".$cataList."','".$mataList."','".$size."','".$cut."','".$rad."','-')";
		}
		
		
		$res=$obj->insert_id($product_insert);
		
		
	
		for($i=0;$i<count($color1);$i++)
		{
			
			$procolor_insert="insert into pro_color values('','".$res."','".$color1[$i]."')";
			$rescolour=$obj->insert($procolor_insert);
		}
		
		if (isset($_FILES['files']))
		{
			$targetPath = "uploads/products/";
			for($i=0;$i<count($_FILES['files']['name']);$i++)
			{
				
			if(!$_FILES['files']['name'][$i]=="")
			{
				$Subimage = $_FILES['files']['name'][$i];
				$SubImageArr = explode(".",$Subimage);
				$SubImageTemp = $_FILES["files"]["tmp_name"][$i];
				$j=0;
				$Subimage = $res."_".$j.".".$SubImageArr[1];
						
						if(file_exists($targetPath.$Subimage))						
						{
							$j++;
							$Subimage = $res."_".$j.".".$SubImageArr[1];
							while(file_exists($targetPath.$Subimage))
							{
								$j++;
								$Subimage = $res."_".$j.".".$SubImageArr[1];
							}
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);						
						}
						else
						{
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);								
						}
						
						$sub_img_pro="insert into pro_sub_images values('null','".$res."' , '".$Subimage."')";					
						
						$ressub_img=$obj->insert($sub_img_pro);
						
						
					}
				
					
				}
    				
		

				
				
				if($res>0)
				{
					move_uploaded_file($_FILES["img_product"]["tmp_name"],"uploads/products/".$MainFileName);
							
					
					header("location:product.php?msg= Product added successfully");
				}
				else
				{
					
					header("location:product.php?msg1= Product already Exist..");
				}
		}
		
				
	
				
	}
	else
		{
			

			header("location:product.php?msg1= Please select Image!!");
		}

	}
	else if($mode=='update')
	{
		
	
			
		
			if($_FILES["img_product"]["name"] != "") 
	{
		
				
				$pho1 = $_REQUEST["old_photo"];
				
				unlink("uploads/products/".$pho1);
				
				$MainFileName=$_FILES["img_product"]["name"];	
				$Arr = explode('.',$MainFileName);
				$MainFileName = $product1.".".$Arr[1];
				$MainFileName=str_replace(' ','',$MainFileName);
				$MainFileName=str_replace('*','',$MainFileName);	
					
				if (file_exists("uploads/products/" . $MainFileName)) 
				{				
						
						$i=0;
						$MainFileName = $product1.$i.".".$Arr[1];
						while(file_exists("uploads/products/".$MainFileName))
						{
							$i++;
							$MainFileName = $product1.$i.".".$Arr[1];
						}
						move_uploaded_file($_FILES["img_product"]["tmp_name"],"uploads/products/".$MainFileName);
					}
					else
					{
						move_uploaded_file($_FILES["img_product"]["tmp_name"], "uploads/products/" . $MainFileName);
					}
				
				 
					for($i=0;$i<sizeof($catalog1);$i++)
					{
    								 
					
					$cataList .= $catta.$catalog1[$i];					 
    				$catta = ',';
					
					}
				
					for($i=0;$i<sizeof($material1);$i++)
					{
    					
									 
						$mataList .= $matta.$material1[$i];					 
    					$matta = ',';
					
					}				 
				 
				 if($rad2=="yes")
				 {
				 $product_update="update product set name='".$product1."',img='".$MainFileName."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='featured' where id='".$_REQUEST["productid"]."'";
				 }
				 else
				 {
				 	$product_update="update product set name='".$product1."',img='".$MainFileName."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='-' where id='".$_REQUEST["productid"]."'";
				 }
			
			
			}
			
			else
			{
				
				for($i=0;$i<sizeof($catalog1);$i++)
					{
    								 
					
					$cataList .= $catta.$catalog1[$i];					 
    				$catta = ',';
					
					}
				
					for($i=0;$i<sizeof($material1);$i++)
					{
    					
								 
						$mataList .= $matta.$material1[$i];					 
    					$matta = ',';
					
					}	
				
			 	
				 if($rad2=="yes")
				 {
				 $product_update="update product set name='".$product1."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='featured' where id='".$_REQUEST["productid"]."'";
				 
				 
				 }
				 else
				 {
				 	$product_update="update product set name='".$product1."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='-' where id='".$_REQUEST["productid"]."'";
				 }
				
			}
			
		
			$res=$obj->update($product_update);
				
				$product_delete="delete from pro_color where product_id='".$_REQUEST["productid"]."'";
				$Productres_delete=$obj->delete($product_delete);
				
				for($i=0;$i<count($color1);$i++)
				{
						
    					$procolor_insert="insert into pro_color values('','".$_REQUEST["productid"]."','".$color1[$i]."')";
						
						$rescolour=$obj->insert($procolor_insert);
						
				}


				
				if (isset($_FILES['files']))
			  {
				 
					$targetPath = "uploads/products/";
					
					for($i=0;$i<count($_FILES['files']['name']);$i++)
					{
						$Subimage = $_FILES['files']['name'][$i];
						$SubImageArr = explode(".",$Subimage);
						$SubImageTemp = $_FILES["files"]["tmp_name"][$i];
						$j=0;
						$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
						
						if(file_exists($targetPath.$Subimage))						
						{
							$j++;
							$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
							while(file_exists($targetPath.$Subimage))
							{
								$j++;
								$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
							}
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);								
						}
						else
						{
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);								
						}
						
						$sub_img_pro="insert into pro_sub_images values('null','".$ProductId."' , '".$Subimage."')";					
						
						$ressub_img=$obj->insert($sub_img_pro);
						
						
					}
			
			
			
			}
				 
    											
																
				if($res==1)
				{
					
					header("location:product.php?msg=Product updated successfully");
				}
				else
				{
					
					header("location:product.php?msg1=Product already Exist..");
				}
	}
	
}

if($_REQUEST["btn_update"]<>"")
{
	$material1 = str_replace('\'', '*', $_REQUEST["dp_material"]);
	$catalog1 = str_replace('\'', '*', $_REQUEST["dp_catalog"]);
	$category1 = str_replace('\'', '*', $_REQUEST["dp_category"]);
	$color1 = str_replace('\'', '*', $_REQUEST["chk_color"]);
	$product1 = str_replace('\'', '*', $_REQUEST["txt_pname"]);
	$desc1 = str_replace('\'', '*', $_REQUEST["txta_desc"]);
	$sku_code1 = str_replace('\'', '*', $_REQUEST["txt_sku_code"]);
	$ProductId = $_REQUEST["productid"];
	$catta="";
	$matta="";
	$size = str_replace('\'', '*', $_REQUEST["txt_size"]);
	$cut = str_replace('\'', '*', $_REQUEST["txt_cut"]);
	$rad=$_REQUEST["rad"];
	$rad2=$_REQUEST["rad2"];
			
	
	
	if($_FILES["img_product"]["name"] != "") 
	{
		
				
				$pho1 = $_REQUEST["old_photo"];
				
				unlink("uploads/products/".$pho1);
				
				$MainFileName=$_FILES["img_product"]["name"];	
				$Arr = explode('.',$MainFileName);
				$MainFileName = $product1.".".$Arr[1];
				$MainFileName=str_replace(' ','',$MainFileName);
				$MainFileName=str_replace('*','',$MainFileName);	
					
				if (file_exists("uploads/products/" . $MainFileName)) 
				{				
						
						$i=0;
						$MainFileName = $product1.$i.".".$Arr[1];
						while(file_exists("uploads/products/".$MainFileName))
						{
							$i++;
							$MainFileName = $product1.$i.".".$Arr[1];
						}
						move_uploaded_file($_FILES["img_product"]["tmp_name"],"uploads/products/".$MainFileName);
					}
					else
					{
						move_uploaded_file($_FILES["img_product"]["tmp_name"], "uploads/products/" . $MainFileName);
					}
				
				 
					for($i=0;$i<sizeof($catalog1);$i++)
					{
    								 
					
					$cataList .= $catta.$catalog1[$i];					 
    				$catta = ',';
					
					}
				
					for($i=0;$i<sizeof($material1);$i++)
					{
    					
									 
						$mataList .= $matta.$material1[$i];					 
    					$matta = ',';
					
					}				 
				 
				  if($rad2=="yes")
				 {
				 $product_update="update product set name='".$product1."',img='".$MainFileName."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='featured' where id='".$_REQUEST["productid"]."'";
				 }
				 else
				 {
				 	$product_update="update product set name='".$product1."',img='".$MainFileName."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='-' where id='".$_REQUEST["productid"]."'";
				 }
			
			
			}
			
			else
			{
				
				for($i=0;$i<sizeof($catalog1);$i++)
					{
    								 
					
					$cataList .= $catta.$catalog1[$i];					 
    				$catta = ',';
					
					}
				
					for($i=0;$i<sizeof($material1);$i++)
					{
    					
								 
						$mataList .= $matta.$material1[$i];					 
    					$matta = ',';
					
					}	
				
			 	
				  if($rad2=="yes")
				 {
				 $product_update="update product set name='".$product1."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='featured' where id='".$_REQUEST["productid"]."'";
				 
				 
				 }
				 else
				 {
				 	$product_update="update product set name='".$product1."',sku_code='".$sku_code1."',category='".$category1."',description='".$desc1."',catalog='".$cataList."',material='".$mataList."',pro_size='".$size."',pro_cut='".$cut."',recommend='".$rad."',featured='-' where id='".$_REQUEST["productid"]."'";
				 }
				
			}
			
		
			$res=$obj->update($product_update);
				
				$product_delete="delete from pro_color where product_id='".$_REQUEST["productid"]."'";
				$Productres_delete=$obj->delete($product_delete);
				
				for($i=0;$i<count($color1);$i++)
				{
						
    					$procolor_insert="insert into pro_color values('','".$_REQUEST["productid"]."','".$color1[$i]."')";
						
						$rescolour=$obj->insert($procolor_insert);
						
				}


				
				if (isset($_FILES['files']))
			  {
				 
					$targetPath = "uploads/products/";
					
					for($i=0;$i<count($_FILES['files']['name']);$i++)
					{
						if(!$_FILES['files']['name'][$i]=="")
						{
						$Subimage = $_FILES['files']['name'][$i];
						$SubImageArr = explode(".",$Subimage);
						$SubImageTemp = $_FILES["files"]["tmp_name"][$i];
						$j=0;
						$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
						
						if(file_exists($targetPath.$Subimage))						
						{
							$j++;
							$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
							while(file_exists($targetPath.$Subimage))
							{
								$j++;
								$Subimage = $ProductId."_".$j.".".$SubImageArr[1];
							}
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);								
						}
						else
						{
							move_uploaded_file($SubImageTemp,$targetPath.$Subimage);								
						}
						
						$sub_img_pro="insert into pro_sub_images values('null','".$ProductId."' , '".$Subimage."')";					
						
						$ressub_img=$obj->insert($sub_img_pro);
						}
						
					}
			
			
			
			}
				 
    											
																
				if($res==1)
				{
					
					header("location:product.php?msg=Product updated successfully");
				}
				else
				{
					
					header("location:product.php?msg1=Product already Exist..");
				}

}
if($_REQUEST["flg"]=="del")
{
			$pho1 = $_REQUEST["c_img"];
			
			extract($_REQUEST);
	
			 $pro_img_sele = "select * from pro_sub_images where product_id='".$_REQUEST["c_id"]."'";
			$res_sel_pro_img=$obj->select($pro_img_sele);
			
			
			while($Row12 = mysql_fetch_array($res_sel_pro_img))
			{
				unlink("uploads/products/".$Row12[2]);
			}
			 
			 
			$dele_sub_img="delete from pro_sub_images where product_id='".$_REQUEST["c_id"]."'";
			 
			 $res_dele_sub_img=$obj->delete($dele_sub_img);
			
			 $product_col="delete from pro_color where product_id='".$_REQUEST["c_id"]."'";
			  $res_del=$obj->delete($product_col);
			  
			  
			  
			 
			 $product_del="delete from product where id ='".$_REQUEST["c_id"]."'";
				
			 $res=$obj->delete($product_del);
			 
			 unlink("uploads/products/".$pho1);
				 
			if($res==1)
			{
			 header("location:product.php?msg=Product deleted successfully");
			 }
			 else
			 {
			 header("location:product.php?msg1=You Can't delete this Product");
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
if(isset($_SESSION["ProductExcel"]))
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
                            <p><?php echo $_SESSION["ProductExcel"];?></p>
                          </div>
                          
                          </div>
                          
                          
                      </div>
                  </div>                  
              </div>
             
              
              <?php
			  unset($_SESSION["ProductExcel"]);
			  
			   } ?>
    
 <!-- function ends -->
 
 
	

   <div class="page-head">
                <h3 class="m-b-less">
					Product <a href="uploads/excel/product.xlsx"  class="btn btn-success"  style="float:right" download>Download Excel</a>
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
                                            <label for="pname" class="control-label col-lg-2">Product Name*</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_pname" name="txt_pname"type="text" required />
                                               
                                              
											</div>									
                                        </div>
                                         
                                         
                                         
                                         <div class="form-group">
      									<label for="inputText" class="col-lg-2 control-label">Fabric*</label>
     								    <div class="col-lg-9 col-md-8">
      	                                <input type="hidden" id="productid" name="productid" />
                                         <input type="hidden" id="mode" name="mode" value="insert" />
                                        
       
        				<select name="dp_material[]" id="dp_material"  required style="width:50%" class="form-control " multiple="multiple">
            							<?php
				
											$dp_material="select * from material";
											
											
											$res=$obj->select($dp_material);
			
				
											while($row1=mysql_fetch_array($res))
												{
				
													$material=str_replace('"', '\'', $row1[2]);
										?>
        
        								<option value="<?php echo $row1[0]?>"><?php echo $material?> </option>
        
        
        								<?php
			
										}
										?>
       								 </select>
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
      									<label for="inputText" class="col-lg-2 control-label">Category*</label>
     								    <div class="col-lg-9 col-md-8">
      	                               
                                        
       
        								<select name="dp_category" id="dp_category"  required style="width:50%" class="form-control " >
        								<option value="" >Select Category</option>
            							<?php
				
											$dp_category="select * from category";
											
											
											$res=$obj->select($dp_category);
			
				
											while($row3=mysql_fetch_array($res))
												{
					
													$category=str_replace('"', '\'', $row3[1]);
										?>
        
        								<option value="<?php echo $row3[0]?>"><?php echo $category?> </option>
        
        
        								<?php
			
										}
										?>
       								 </select>
      								</div>
    								</div>
                                       <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Color</label>
                                            <div class="col-lg-9 col-md-8" style="float:left" id="colorDiv"> 
                                           
                                     <!--<div style="height:50px;width:50px ;float:left"><img src="uploads/multicolor.png" style="height:50px;width:50px ;float:left ;border:double"><center><div style="width:100%; height:10px"></div><input style="height:20px;width:20px;" class="form-control" id="chk_color" title="" name="chk_color"type="checkbox"  value="Multicolour" /></center></div>-->
                                     <?php
									 	$color_select="select * from color where name='Multicolour'";
										$res_color_select=$obj->select($color_select);
										$row6=mysql_fetch_array($res_color_select);
										$color_select_id=$row6[0];
									 ?>
                                     
                                   <div style="background-image:url(uploads/multicolor1.png);height:50px;width:50px ;border:double;float:left" ><center><div style="width:100%; height:10px"></div><input style="height:20px;width:20px;" class="form-control" id="chk_color" title="<?php echo $row6[1] ?>" name="chk_color[]"type="checkbox"  value="<?php echo $color_select_id?>"/></center></div>
                                       <?php
									  	
									   	$color="select * from color where name!='Multicolour'";
										$res=$obj->select($color);
										while($row3=mysql_fetch_array($res))
										{
									  		$color=str_replace('"', '\'', $row3[2]);
									  		$colorid=$row3[0];
									  	
									   ?>
                                        
                                      <div style="background:#<?php echo $row3[2] ?>;height:50px;width:50px ;float:left ;border:double" ><center><div style="width:100%; height:10px"></div><input style="height:20px;width:20px;" class="form-control" id="chk_color" title="<?php echo $row3[1] ?>" name="chk_color[]"type="checkbox"  value="<?php echo $colorid?>" /></center></div> 
                                               
                                              
											
                                        
                                        <?php
										}
										?>
                                        
                                           
                                     
                                      </div>									
                                        </div>
                                        
                                        
                                         <div class="form-group ">
                                            <label for="pname" class="control-label col-lg-2">Size</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_size" name="txt_size"type="text"/>
                                               
                                              
											</div>									
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label for="pname" class="control-label col-lg-2">Cut</label>
                                            <div class="col-lg-9 col-md-8">
                                                <input class=" form-control" id="txt_cut" name="txt_cut"type="text"/>
                                               
                                              
											</div>									
                                        </div>

                                        
                                        
                                       
                                        
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Image*</label>
                                            <div class="col-lg-9 col-md-8">
                                               <input id="img_product" name="img_product"  class="btn btn-success" type="file" onchange="readURL(this);" >
                                               <img id='PreviewImage' name="PreviewImage" src=""  height="100" width="120" hidden="true">
                                         	<input type="hidden" id="old_photo" name="old_photo" value="" />
                                              
											</div>									
                                        </div>
                                        
                                       
                                       <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Sub Images</label>
                                            <div class="col-lg-9 col-md-8">
                                            <input type="file" name="files[]" id="upload" multiple value="" class="btn btn-success" />
                                           
                                             <div class="col-lg-9 col-md-8" id="imagepreview1">
                                            
											</div>
                                            
                                            <br/>
                                            <br/>
                                            
                                            
                                            <div class="col-lg-9 col-md-8" id="subimgdiv">
                                            

											</div>
                                            
                                           									
                                        	
                                        </div>
                                         </div>
                                       
                                       <!--<div id="imagePreview"></div>
            <input id="uploadFile" type="file" name="image" multiple class="img" />-->    
                                       
                                       
                                       
                                       
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Description*</label>
                                            <div class="col-lg-9 col-md-8">
                                       <textarea input class=" form-control" id="txta_desc" name="txta_desc" type="text"  /></textarea>
                                               
                                             
											</div>									
                                        </div>
                                       
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">SKU Code</label>
                                            <div class="col-lg-1 col-md-1">
                                                <input class=" form-control" value="D.NO.:" type="text" disabled="disabled" />
                                               
                                              
											</div>
                                            <div class="col-lg-8 col-md-7">
                                                <input class=" form-control" id="txt_sku_code" name="txt_sku_code" type="text" required="required" />
                                               
                                              
											</div>									
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Recommend*</label>
                                            <div class="col-lg-9 col-md-8">
                                                
                                                <input type="radio" name="rad" value="yes" id="rad">Yes
												<input type="radio" name="rad" value="no" id="rad1" checked>No
                                               
                                              
											</div>									
                                        </div>
                                        
                                         <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Featured*</label>
                                            <div class="col-lg-9 col-md-8">
                                                
                                                <input type="radio" name="rad2" value="yes" id="rad2">Yes
												<input type="radio" name="rad2" value="no" id="rad3" checked>No
                                               
                                              
											</div>									
                                        </div>
	                                    	 
                                        <div class="form-group">
                                            <div class="col-lg-offset-2 col-lg-10">     
                                                <button class="btn btn-success" value="btn_submit" id="btn_submit" name="btn_submit" type="submit" onclick=" return checkcolour()"> Save </button>
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
									 Product Name
                                </th>
                                
                                <th>
									 Product Image
                                </th>
                                
                                <!--<th>
									 Product Description
                                </th>
                                -->
                                <th>
									 Material
                                </th>
								 
                                 <th>
									 Category
                                </th>
                               
                                <th>
									 Catalogue
                                </th>
                                
                                 <th>
									 Colour
                                </th>
                                <th>
									 Size
                                </th>
                                <th>
									 Cut
                                </th>
								
                                
                                 <th>
									 SQU Code
                                </th>
                                
                                 <th>
									 Recommend
                                </th>
                                <th>
									 Featured
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
							
							
					$productQuery = "select p.id,p.name,p.img,p.sku_code,p.category,p.description,p.catalog,p.material,ct.name,c.cat_name,m.name,p.pro_size,p.pro_cut,p.recommend,p.featured, (select group_concat(distinct(pc.color)) as ctcolor from  pro_color as innerprocolor where find_in_set(innerprocolor.id,group_concat(pc.id))>0 group by p.id  ) as colorids,(select group_concat(distinct(color.colorcode)) as ctcolorcode from color as innercolor where find_in_set(innercolor.id,group_concat(color.id))>0 group by p.id  ) as colorcodes,(select group_concat(distinct(ct.name)) as ctnm from catalog as innercat where find_in_set(innercat.id,group_concat(ct.id))>0 group by p.id  ) from product as p,catalog as ct,category as c,material as m,pro_color as pc,color  where color.id=pc.color and pc.product_id=p.id and find_in_set(ct.id,p.catalog) and p.category = c.id and p.material = m.id group by p.id ORDER BY `p`.`id` DESC";
					
					
					//echo $productQuery; 
					
							$Productres=$obj->select($productQuery);
							
							
							
							$j=1;
							
							while($Productrow=mysql_fetch_array($Productres))
							{
						
								
							?>
                            
                            <tr>
                                <td>
								<?php echo $j ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $Productrow[1]) ?>
                                </td>
								<td>
                               
								<?php echo '<img src="uploads/products/'.$Productrow[2].'"  height="65" width="100" >'; ?>

                                </td>
                               <!-- <td>
								<?php echo str_replace('*', '\'', $Productrow[5]) ?>
                                </td>
                               -->
                                <td>
								
                                
                                <?php
								
								$myArray =explode(',',  $Productrow[7]);
								
								for($i=0;$i<sizeof($myArray);$i++)
								{				
					
									
									$get_arra="SELECT GROUP_CONCAT(t2.name) FROM product as t1 LEFT JOIN material as t2 ON find_in_set(t2.id, t1.material)where t1.material='".$Productrow[7]."'  group by t1.id ";
									
									
									$res_get_arra=$obj->select($get_arra);
									
									
								}
								 
								 $row4=mysql_fetch_array($res_get_arra);
								 echo str_replace('*', '\'', $row4[0]);
								 ?>
                                </td>
                                <td>
								<?php echo str_replace('*', '\'', $Productrow[9]) ?>
                                
                                
                                
                                
                                 

                                
                                
                                </td>
                                <td>
								
                                
                                
                                <?php
								
								
								 echo str_replace('*', '\'', $Productrow[17]);
								 ?>
                                
                                
                                
                                
                                </td>
                                <td>
								<?php
								
									$myArray2=explode(',',  $Productrow[15]);
								
								
									$myArray3=explode(',',  $Productrow[16]);
									for($i=0;$i<sizeof($myArray2);$i++)
									{				
					
											
										if($myArray2[$i]=='1')
											{?>
					
										
										<img src="uploads/multicolor1.png" style="height:20px;width:20px ;float:left;border:double">
										<?php }
										else
										{
											
											?>
											 <div style="background:#<?php echo $myArray3[$i] ?>;height:20px;width:20px ;float:left;border:double " ></div>
										<?php }
										
									}
									
							?>
							
								
							
							
                                </td>
                               
                                <td>
								<?php if($Productrow[11]=="")
								{ 
									echo"-";
								}
								else
								{
									echo str_replace('*', '\'', $Productrow[11]); 
								}
								?>
                                </td>
                               
                                 <td>
									<?php if($Productrow[12]=="")
								{ 
									echo"-";
								}
								else
								{
									echo str_replace('*', '\'', $Productrow[12]); 
								}
								
								?>
                                </td>
                               
                                <td>
                                
								<?php echo str_replace('*', '\'', $Productrow[3]) ?>
                                </td>
                                
                                <td>
								<?php echo str_replace('*', '\'', $Productrow[13]) ?>
                                </td>
                                
                                <td id="changefeatured"><a href="javascript:changefeatured('<?php echo $Productrow[0] ?>')" id="<?php echo $Productrow[0] ?>">
								
								<?php 
	  								 if($Productrow[14]=='-')
	  									 {
		  										 echo "no";
	   									}
	   									else
	  									 {
		  											echo str_replace('*', '\'', $Productrow[14]);
	   									}
										
 ?>
       </a>
							   
                                </td>
                                                  
                               <td><a href="javascript: editdata('<?php echo $Productrow[0] ?>','<?php echo $Productrow[1] ?>','<?php echo $Productrow[2] ?>','<?php echo $Productrow[3] ?>','<?php echo $Productrow[4] ?>','<?php echo $Productrow[5] ?>','<?php echo $Productrow[6] ?>','<?php echo $Productrow[7] ?>','<?php echo $Productrow[11] ?>','<?php echo $Productrow[12] ?>','<?php echo $Productrow[13] ?>','<?php echo $Productrow[14] ?>','<?php echo $Productrow[15] ?>')" >Edit</a></td>
  							   <td ><a href="javascript: deletedata('<?php echo $Productrow[0] ?>','<?php echo $Productrow[2] ?>')" >Delete</a></td>
                            </tr>
                           <?php
						   $j++;
							}
						   ?>
                           
                            </tbody>
                            </table>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
                
        <script type="text/javascript" src="jquery-1.8.0.min.js"></script>
	  <script type="text/javascript">
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
		
		
		$(function() {
    
	
	$("#upload").on("change", function()
    
	{
		document.getElementById("imagepreview1").innerHTML="";
		var inc=0;
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
       var i=0;
	
			
		for(i=0;i<files.length;i++)
		{
        	if (/^image/.test( files[i].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[i]); // read the local file
            var a='div1'+i;
           
		    reader.onloadend = function(){ // set image data as background of div
          inc++;
		       
			 
			   document.getElementById("imagepreview1").innerHTML+="<div id='a"+inc+"'style='float:left'></div>";

				    $("#a"+inc).css("background-image", "url("+this.result+")");
				  $("#a"+inc).css("height", "100px");
				   $("#a"+inc).css("width", "100px");
				   $("#a"+inc).css("padding-left", "10px");
				   $("#a"+inc).css("padding-top", "10px");
				  
				    $("#a"+inc).css("background-size", "COVER");
					
				
				
            }
		
        }
		}
		
    });
	
});
    </script>          

              <script type="text/javascript">
$(document).ready(function(e) {	
    $("form").submit(function(){
		var flagC=0;
        var idsq = document.getElementsByName('chk_color[]');
		for(var i=0;i<idsq.length;i++)
		{
			if(idsq[i].checked)
			{
				flagC=1;
			}
		}		
		if(flagC!=1)
		{
			alert("Please Select Color");
			return false;
		}
		else
		{		
			return true;
		}
		
		
    });
	
});



	function deletedata(c_id,c_img)
	{

		if(confirm("Are you sure to delete data?"))
		{	
			
			var loc="product.php?flg=del&c_id="+c_id+"&c_img="+c_img;
			
			window.location=loc;
		}
		
	}
	
	function editdata(id,name,image,sku_code,category,desc,catalog_id,material_id,pro_size,pro_cut,rad,rad2,color_id)
	{	
		
		$('#productid').val(id);
		
		
			$('#txta_desc').val(desc.replace("*", "'"));	
		$('#dp_category').val(category.replace("*", "'"));
		$('#txt_pname').val(name.replace("*", "'"));
		$('#txt_sku_code').val(sku_code.replace("*", "'"));
		$('#txt_size').val(pro_size.replace("*", "'"));
		$('#txt_cut').val(pro_cut.replace("*", "'"));
		$('#ra').val(pro_cut.replace("*", "'"));
		

		
		$("#old_photo").val(image);
		document.getElementById("PreviewImage").hidden=false;
		$('#txt_pname').focus();
		
		var i=0;
		var cata_ids=catalog_id.split(",");
		
	  $('select#dp_catalog option').removeAttr("selected");
		$.each(cata_ids, function(i,e){
	
		$("#dp_catalog option[value='"+e+"']").attr("selected", "selected");
});

		
		
		var j=0;
		var mata_ids=material_id.split(",");
		
	  $('select#dp_material option').removeAttr("selected");
		$.each(mata_ids, function(j,e){
	
		$("#dp_material option[value='"+e+"']").attr("selected", "selected");
});

	
		
		
		if(rad=="no")
		{
			
			rad=document.getElementById("rad1").checked="true";
			
			
		}
		else 
		{
			
			rad=document.getElementById("rad").checked="true";
			
		}
		
		if(rad2=="-")
		
		{
			
			
			rad2=document.getElementById("rad3").checked="true";
			
			
		}
		else 
		{
			
			
			rad2=document.getElementById("rad2").checked="true";
			
		}
		
		
		var k=0;
		
		var color_ids=color_id.split(",");
		
	  
		var colors=document.getElementsByName('chk_color[]');
		for (var i = 0, length = colors.length; i < length; i++) 
		{
 			   if (color_ids.indexOf(colors[i].value)!='-1') {
			
					colors[i].checked=true;
				}
				else
				{
					colors[i].checked=false;
				}
		}
			
	
		
		
	  $.ajax({
          type: "POST",
          url: "KalashData.php?action=Getpreviewsubimg",
          data: "pro_id="+id,
          cache: false,
          success: function(result){
			  
			
			document.getElementById("subimgdiv").innerHTML=result;         
          }
      });
	  		
		$('#mode').val('update');
		$('#btn_submit').addClass('hidden');
		$('#btn_update').removeClass('hidden');
		$('#Area_name').focus();
				 
	}
	/*function checkcolour()
	{
		alert("hello");
		var cl=document.getElementById('chk_color');
		alert(cl.length+":len");
		for (var i = 0; i < cl.length; i++) 
		{
 			  
			   alert(cl[i]+":qwe");
			   if (cl[i].checked== 1) 
			   {
			
					alert("1");
					cl[i].checked=true;
				}
				else
				{
					alert("2");
					cl[i].checked=false;
					alert("Please select Colour");
				}
		
		}
	}*/
	function deleteSubImage(ids,images)
	{
		if(confirm("Are you sure want delete image?"))
		{
		
		$.ajax({
          type: "POST",
          url: "KalashData.php?action=DeleteSubImageFromProduct",
          data: "ImageID="+ids+"&ImageName="+images,
          cache: false,
          success: function(result){
			   //alert(result);
			var arr = result.split(":");
			if(arr[0]=="yes")
			{
				document.getElementById("img_"+arr[1]).hidden = true;
				document.getElementById("del_"+arr[1]).hidden=true;
			}
			
          }
      });
		
	}
	
	}
	
function changefeatured(id)
{
	if(confirm("Do You want to change?"))
	{
		var String = 'bid='+ id;
	
	
			  $.ajax({
          type: "POST",
          url: "KalashData.php?action=change_feature",
          data: String,
          cache: false,
          success: function(result){
                
				
					window.location="product.php?msg=featured updated succesfully!";			  
				  
		  }
			  });
		
	}
}
	
	
	function resetdata()
	{
		
	window.location="product.php";
	}


			
 </script>              

<?php
include("footer.php");
?>