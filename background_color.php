<?php
include("header.php");
$obj=new DB_Connect;
if($_REQUEST["button1"]<>"")
{
	/*$color=$_REQUEST["color"];
	
	$cid=$_REQUEST["cid"];
	
	$update_color="update colormaster set  value='".$color."' where id=".$cid."";
	echo $update_color;
	$res=$obj->update($update_color);
	if($res==1)
	{
		//header("location:background_color.php?m=Color value updated successfully...!");
	}
	else
	{
		//header("location:background_color.php?m1=Color value is not updated ...!");
	}
	*/
	
	
	$id=$_REQUEST["updateid"];
	
	
	if($_FILES["timg"]["name"] != "") 
			{
				
				$pho1 = $_REQUEST["old_photo"];
				//echo $pho1;
				unlink("uploads/".$pho1);
				$newfilename=$_FILES["timg"]["name"];
				
				$newfilename=str_replace(' ','',$newfilename);
				//echo $newfilename;
				if (file_exists("uploads/" . $newfilename)) 
				{				
					$Arr = explode('.',$newfilename);
					$i=0;
					$newfilename = $Arr[0].$i.".".$Arr[1];
					while(file_exists("uploads/".$newfilename))
					{
						$i++;
						$newfilename = "upload_".$Arr[0].$i.".".$Arr[1];
					}
					move_uploaded_file($_FILES["timg"]["tmp_name"],"uploads/".$newfilename);
				}
				else
				{
					$newfilename="uploads_".$newfilename;
					move_uploaded_file($_FILES["timg"]["tmp_name"], "uploads/" . $newfilename);
				}
				
				$update_color1="update colormaster set value='".$newfilename."' where id=".$id."";
			
					
							
				
			}
		
			$res=$obj->update($update_color1);
				
				if($res==1)
				{
					
					header("location:background_color.php");
				}
				else
				{
					
					//header("location:background_color.php?msg1=".$id." Image updated successfully");
				}
				
	
	
	
	
	
}

if($_REQUEST["id"]<>"")
{
	
	
	
		
				$id=$_REQUEST["id"];
				
				
				$old_photo="select * from colormaster where id=".$_REQUEST["id"]."";
				$res_old=$obj->select($old_photo);
				$oldrow = mysql_fetch_array($res_old);
				//echo $oldrow[2];exit();
				unlink("uploads/".$oldrow[2]);
				
				
				$update_color2="update colormaster set value='' where id=".$_REQUEST["id"]."";
			
					
							$res2=$obj->update($update_color2);
				
				if($res2==1)
				{
					
					header("location:background_color.php	");
				}
				else
				{
					
					//header("location:background_color.php?msg=Image updated successfully");
				}
				
		
}


?>


<section class="white section">
			<div class="container">
                        <div class="row" >
                            <div class="col-md-12 col-sm-12">
                                <center><h2>Manage Colour</h2></center>
                               
<?php 
	$colormaster = "select * from colormaster";
	
	$res=$obj->select($colormaster);
?>
<table class='table table-bordered'>
			<thead>
				<tr>
					<th>Sr.No.</th>
                    <th>Name</th>
					<th>Default Value</th>					
					<th>Value</th>			
					<th>Edit</th>
					
				</tr>
			</thead>
			<tbody>
	<?php		
	$i=0;	
	while($colorrow = mysql_fetch_array($res))           
	{
		$i++;
		?>
				<tr>
					<td style="vertical-align: middle !important;"><?php echo $i;?></td>
					
                    <?php if($colorrow[0]=="14")
                    {
						
						?>
                   		
					 <td style="vertical-align: middle !important;"><?php echo str_replace( '*','\'', $colorrow[1]); ?></td>	
		<td style="padding:0px;height:50px;width:150px;vertical-align: middle !important;"><form id="Form" method="post" action="" enctype="multipart/form-data">

<input type="button" id="button" name="button" value="Reset" onclick="window.location.href='background_color.php?id=<?php echo $colorrow[0]?>';">		
	</td>
   <td style="vertical-align: middle !important;"> 
   
   	<?php
		if($colorrow[2]=='')
		{
			
			
	?>
   			
        <img id='PreviewImage' name="PreviewImage" src=""  height="60" width="80" hidden="true"><br/><br/>
    <?php
		}else
		{
			
	?> <img id='PreviewImage' name="PreviewImage" src="uploads/<?php echo $colorrow[2]?>"  height="100" width="120"><input type="hidden" id="old_photo" name="old_photo" value="<?php echo $colorrow[2]?>" /><br/><br/>
   
   <?php
		}
		?>
  <input type="file" id="timg" name="timg" value="" onchange="readURL(this);" style="margin-left:30%;margin-bottom:10%"/>
  <?php echo "(Resolution must be 200x150px)"?>
    <input type="hidden" id="updateid" name="updateid" value="<?php echo $colorrow[0]; ?>" />	
    </td>
					
					<td style="vertical-align: middle !important;"><center><input type="submit" id="button1" name="button1" value="Submit" disabled="disabled"></form>		
                    
      <a href="javascript:updatecolor('<?php echo $colorrow[0]; ?>','<?php echo $colorrow[1]; ?>','<?php echo $colorrow[2]; ?>','<?php echo $i ?>','<?php echo "color_".$colorrow[0]; ?>','<?php echo "colortd_".$colorrow[0]; ?>');" id="updatecolorbtn[<?php echo $i ?>]" style="display:none"><img src='uploads/picture/save.png' height='50px' width='50px'></img></a>
                    
                    <center></td>
					
					
					
					
					<?php }
					else
					{?>

	                
					 <td style="vertical-align: middle !important;"><?php echo str_replace( '*','\'', $colorrow[1]); ?></td>	
<td style="padding:0px;height:50px;width:150px;vertical-align: middle !important;">  <a href="javascript: defaultcolor('<?php echo $colorrow[0]; ?>','<?php echo $colorrow[3]; ?>','<?php echo "colortd_".$colorrow[0]; ?>');" id="defaultcolorbtn[<?php echo $i ?>]" > Default Colour</a>				
	</td>
    
    
      <td id="colortd_<?php echo $colorrow[0]?>" style="background:#<?php echo str_replace( '*','\'', $colorrow[2]); ?>; padding:0px; height:50px;width:150px" > 
   <input style="height:100%" maxlength="20" class="jscolor" type="text" hidden="true"  id="color_<?php echo $colorrow[0]?>" name="color_<?php echo $colorrow[0]?>"  value="<?php echo str_replace( '*','\'', $colorrow[2]); ?>"> </td>
					
					<td style="vertical-align: middle !important;"><center><a id="editcolorbtn[<?php echo $i ?>]" href="javascript:editcolor('<?php echo "color_".$colorrow[0]; ?>','<?php echo $i ?>');"><img src='uploads/picture/edit.png' height='50px' width='50px'></img></a>
                    
      <a href="javascript:updatecolor('<?php echo $colorrow[0]; ?>','<?php echo $colorrow[1]; ?>','<?php echo $colorrow[2]; ?>','<?php echo $i ?>','<?php echo "color_".$colorrow[0]; ?>','<?php echo "colortd_".$colorrow[0]; ?>');" id="updatecolorbtn[<?php echo $i ?>]" style="display:none"><img src='uploads/picture/save.png' height='50px' width='50px'></img></a>
                    
                    <center></td>
					
					
					<?php }?>
                    </tr>
                <?php
	}                     
	echo "</tbody></table>";
?>
        </div><!-- end col -->
                        </div><!-- end row -->
			</div><!-- end container -->
		</section>

	



 
             
<script src="jscolor.js"></script>
<script>




        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
					$('#PreviewImage').html('');
                    $('#PreviewImage').attr('src', e.target.result);
					document.getElementById("PreviewImage").hidden=false;
					document.getElementById("button1").disabled=false;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

function editcolor(id,no)
{
	//alert(id);
	document.getElementById(id).hidden = false;
	document.getElementById("editcolorbtn["+no+"]").style.display="none";
	document.getElementById("updatecolorbtn["+no+"]").style.display="inline";
	
	
	
	//$("#"+id).addClass(jscolor);	
	//document.getElementById(id).v=false;
	

	//$("#color1").removeClass([jscolor]);
	/*$("#color").val(color);
	$("#color").css("background-color",'#'+color);
	$("#color").css("color",'#FFFFFF');
	$("#cid").val(id);
	$("#label").val(name);
	document.getElementById("editcolorbtn["+no+"]").style.display="none";
		document.getElementById("updatecolorbtn["+no+"]").style.display="inline";
*/
	//window.location="#Form13";
}

function updatecolor(id,name,color,no,colorvalue,colortd)
{
	//alert(id);
	document.getElementById("editcolorbtn["+no+"]").style.display="inline";
		document.getElementById("updatecolorbtn["+no+"]").style.display="none";
	var cval=document.getElementById(colorvalue).value;
	//alert(cval);
	changecolor(id,cval);
	document.getElementById(colorvalue).hidden = true;
	$("#"+colortd).attr("style","background:#"+cval);
		
}

function defaultcolor(id,dvalue,colortd)
{
	changecolor(id,dvalue);
	$("#"+colortd).attr("style","background:#"+dvalue);
}


</script>



<script type="text/javascript">

function changecolor(id,cval)
{

//alert(id);
//alert(cval);

$.ajax({
		type: "POST",
		url: "kalashdata.php?action=color_edit",
		data: "id="+id+"&cval="+cval,
		cache: false,
		success: function(resu)
		{
			
				
						
		}
	});
		

}

</script>
<?php include("footer.php");?>