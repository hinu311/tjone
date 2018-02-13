<?php
include("db_connect.php");
include("config.php");
error_reporting(0);
$obj=new DB_Connect;


if($_REQUEST["action"]=="Getpreviewsubimg")
{
	$x = $_REQUEST["pro_id"];
	$echohtml="";	
    	$sql1="select * from pro_sub_images where product_id='".$x."'";
		
		$query=$obj->select($sql1);			
		while($row1=mysql_fetch_array($query))
		{
			$image1=$row1 ['2'];
			$del_id=$row1['0'];
			$echohtml.='<img src="uploads/products/'.$image1.'" width="100" height="100" id="img_'.$row1[0].'" name="img_'.$row1[0].'" style="padding-left:10px; padding-top:10px; " onclick="javascript:deleteSubImage('.$del_id.','.$image1.');">
			
			<a href="javascript:deleteSubImage(\''.$del_id.'\',\''.$image1.'\');" id="del_'.$row1[0].'" name="del_'.$row1[0].'" >Delete</a>';
      
			}
		
	echo $echohtml;	
}

if($_REQUEST["action"]=="DeleteSubImageFromProduct")
{
	$x1 = $_REQUEST["ImageName"];
	$x =  $_REQUEST["ImageID"];
	$echohtml="";
	unlink("uploads/products/".$x1);
	$DeleteSubImageQuery = "delete from pro_sub_images where id = ".$x;
	
	
	
	if($obj->delete($DeleteSubImageQuery))
	{
		$echohtml="yes:".$x;
	}
	else
	{
		$echohtml="no:0";
	}
	echo $echohtml;
}

if(mysql_real_escape_string($_GET['action'])=='change_status')
	{
			 $id=mysql_real_escape_string($_POST['bid']);
			
			 $query="select status from users where id=$id";
			 
			
			$query_res=$obj->select($query);
		    $row=mysql_fetch_array($query_res);
			
			if($row[0]=="1")
			{
				$str="update users set status='0' where id=$id";
				   
				  
				   $query_str=$obj->update($str);
			       echo "1";
				
			}
			else
			{
				
				  $str="update users set status='1' where id=$id";
				  
				 
				   $query_str=$obj->update($str);
			       echo "0";
				
			}
		
	
	}
	
	
	if(mysql_real_escape_string($_GET['action'])=='change_feature')
	{
			 $id=mysql_real_escape_string($_POST['bid']);
			
			 $query2="select featured from product where id=$id";
			 
			$query_res2=$obj->select($query2);
		    $row2=mysql_fetch_array($query_res2);
			
			if($row2[0]=="featured")
			{
				$str2="update product set featured='-' where id=$id";
				 
				   $query_feature=$obj->update($str2);
			       echo "-";
				
			}
			else
			{
				
				  $str2="update product set featured='featured' where id=$id";
				  // mysql_query($str1);
				    $query_feature=$obj->update($str2);
			       echo "featured";
				
			}
		
	
	}


if(mysql_real_escape_string($_GET['action'])=='forgot_pass')
	{
		
		$b_user= $_REQUEST['state'];
	  
  
	
	
		 $query_pass="Select password from users where uname='".$b_user."' ";
		
	  $res_query_pass=$obj->update($query_pass);
$check=mysql_num_rows($res_query_pass);
if($check > 0){
	$row=mysql_fetch_array($res_query_pass);
	
	echo "Your Password is : ".$row[0];
}
else
{
	echo " Sorry, Please Enter Valid User Name... ";
}
				
}
if(mysql_real_escape_string($_GET['action']=="color_edit"))
{
	$id=$_REQUEST["id"];
	$cvalue=$_REQUEST["cval"];
	$HTML="";
	$update_color="update colormaster set  value='".$cvalue."' where id=".$id."";
	$res_updt_color=$obj->update($update_color);
	if($res_updt_color==1)
	{
		$HTML=1;
		//header("location:color.php?m=Color value updated successfully...!");
	}
	else
	{
		$HTML=2;
		//header("location:color.php?m1=Color value is not updated ...!");
	}
	echo $HTML;
		
}

?>