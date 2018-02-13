<?php 

//This page is for webservice of Kalash android application
include("db_connect.php");
if($_REQUEST['action']=='getcategory'){
     getjson("select * from category");
  }
  else if($_REQUEST['action']=='getcatalog')
  {
	  if($_REQUEST['id']=="no")
	  {
		   getjson("SELECT catalog.* FROM catalog,level where level.id=1 and FIND_IN_SET(catalog.id,level.catalog_id )>0");
	  
	  }
	  else
	  {
		  getjson("SELECT catalog.* FROM catalog,users,level where users.level=level.id  and  users.id='".$_REQUEST['id']."'and FIND_IN_SET(catalog.id,level.catalog_id )>0");
	  }
	   
	   
  }
   else if($_REQUEST['action']=='getprocolor')
  {
	   getjson("SELECT pro_color.id, pro_color.product_id, color.name as colorname,color.colorcode as colorcode FROM pro_color,color where color.id=pro_color.color");
  }
   else if($_REQUEST['action']=='getproduct_catalog')
  {
	   getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname,GROUP_CONCAT(distinct(color.colorcode)) as colorcode ,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category WHERE color.id=pro_color.color and category.id=product.category and pro_color.product_id=product.id and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 and FIND_IN_SET('".$_REQUEST["cid"]."',product.catalog)>0 group by product.id");
  }
  else if($_REQUEST['action']=='getproduct_catalog_category')
  {
	   getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname,GROUP_CONCAT(distinct(color.colorcode)) as colorcode ,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category WHERE color.id=pro_color.color and category.id=product.category and pro_color.product_id=product.id and product.category='".$_REQUEST['ct_id']."' and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 and FIND_IN_SET('".$_REQUEST["cid"]."',product.catalog)>0 group by product.id");
  }
   else if($_REQUEST['action']=='getprosubimage')
  {
	   getjson("SELECT * FROM `pro_sub_images` WHERE product_id='".$_REQUEST["pid"]."'");
  }
   else if($_REQUEST['action']=='getusers')
  {
	   getjson("SELECT * FROM users");
  }
  else if($_REQUEST['action']=='getuserdetail')
  {
	   getjson("SELECT * FROM users where id='".$_REQUEST['id']."'");
  }
   else if($_REQUEST['action']=='getbanners')
  {
	   getjson("SELECT * FROM banner");
  }
   else if($_REQUEST['action']=='facebook_login')
  {	 ob_start();
  		
		$obj=new DB_Connect;
  		$check_insert="select * from users where uname='".$_REQUEST['uid']."'";
		
		$result1=$obj->select($check_insert);
	  	$fields_num1 = mysql_num_rows($result1);
	
	
		
	  	if($fields_num1>0)
		{
		getinsertjson("update users set fname='".$_REQUEST['fname']."',lname='".$_REQUEST['lname']."',emailid='".$_REQUEST['email']."' where uname='".$_REQUEST['uid']."'");	
		
	  
		}
		else
		{
		 getinsertjson("INSERT INTO `users` (`id`, `fname`, `lname`, `emailid`,uname, `user_typ`, `level`, `status`) VALUES (NULL, '".$_REQUEST['fname']."', '".$_REQUEST['lname']."', '".$_REQUEST['email']."', '".$_REQUEST['uid']."', 'facebook', '1', '1')");
		}
	ob_end_clean();
	 getjson("SELECT * FROM `users` WHERE uname='".$_REQUEST['uid']."' and `user_typ`='facebook' and status=1");  
  }
 
  else if($_REQUEST['action']=='register')
  {
	   getinsertjson("INSERT INTO `users` (`id`, `fname`, `lname`, `emailid`, `uname`, `password`, `mb_no`, `user_typ`, `level`, `status`) VALUES (NULL, '".$_REQUEST['fname']."', '".$_REQUEST['lname']."', '".$_REQUEST['email']."', '".$_REQUEST['uid']."', '".$_REQUEST['pwd']."', '".$_REQUEST['mb_no']."', 'user', '1', '1');");
  }
  else if($_REQUEST['action']=='edit_profile')
  {
	   getinsertjson("update `users` set fname='".$_REQUEST['fname']."' ,`lname`='".$_REQUEST['lname']."',`emailid`='".$_REQUEST['email']."',`password`='".$_REQUEST['pwd']."', `mb_no`='".$_REQUEST['mb_no']."' where id='".$_REQUEST['id']."'");
  }
  else if($_REQUEST['action']=='order_inquiry1')
  {
	echo "aaa";	 

  }
    
  else if($_REQUEST['action']=='getcategory_catalog')
  {
	if($_REQUEST['id']=="no") 
	{ 
	getjson("select catalog.* from catalog,level where FIND_IN_SET(catalog.id,(SELECT GROUP_CONCAT(distinct(`catalog`)) FROM `product` WHERE `category` ='".$_REQUEST['cid']."'))>0 AND level.id=1 and FIND_IN_SET(catalog.id,level.catalog_id )>0
");
}
	else
	{
		getjson("select catalog.* from catalog,users,level where FIND_IN_SET(catalog.id,(SELECT GROUP_CONCAT(distinct(`catalog`)) FROM `product` WHERE `category` ='".$_REQUEST['cid']."'))>0 AND users.id='".$_REQUEST['id']."' and users.level=level.id and FIND_IN_SET(catalog.id,level.catalog_id )>0
");
	}
  }
   else if($_REQUEST['action']=='get_recomm_product')
  {
	if($_REQUEST['id']=="no") 
	{
		
		
	getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname ,GROUP_CONCAT(distinct(color.colorcode)) as colorcode,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category,level WHERE color.id=pro_color.color and category.id=product.category  and level.id=1 and FIND_IN_SET(catalog.id,level.catalog_id )>0 and pro_color.product_id=product.id and product.recommend='yes' and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 group by product.id
");
}
	else
	{
		getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname ,GROUP_CONCAT(distinct(color.colorcode)) as colorcode,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category,users,level WHERE color.id=pro_color.color and category.id=product.category and users.level=level.id and users.id='".$_REQUEST['id']."' and FIND_IN_SET(catalog.id,level.catalog_id )>0 and pro_color.product_id=product.id and product.recommend='yes' and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 group by product.id");
	}
  }
  
  else if($_REQUEST['action']=='get_featured_product')
  {
    if($_REQUEST['id']=="no") 
	{
		
		
	getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname ,GROUP_CONCAT(distinct(color.colorcode)) as colorcode,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category,level WHERE color.id=pro_color.color and category.id=product.category  and level.id=1 and FIND_IN_SET(catalog.id,level.catalog_id )>0 and pro_color.product_id=product.id and product.featured='featured' and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 group by product.id
");
}
	else
	{
		getjson("SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname ,GROUP_CONCAT(distinct(color.colorcode)) as colorcode,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category,users,level WHERE color.id=pro_color.color and category.id=product.category and users.level=level.id and users.id='".$_REQUEST['id']."' and FIND_IN_SET(catalog.id,level.catalog_id )>0 and pro_color.product_id=product.id and product.featured='featured' and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 group by product.id");
	}
  }
  
  else if($_REQUEST['action']=='order_inquiry')
  {

	 date_default_timezone_set('Asia/Calcutta');
	  $date=date("d/m/Y");
	  $tym=date("H:s");
	  $uid=$_REQUEST['uid'];
	  $unm=$_REQUEST['unm'];
	  $email=$_REQUEST['email'];
	  $contact=$_REQUEST['contact'];
  	  $remark=$_REQUEST['remark'];
	  $pids=$_REQUEST['pid'];
	  $quans=$_REQUEST['quan'];
	  $types=$_REQUEST['type'];
	  if($uid=='guest'){
	 $query="INSERT INTO `ordr` (`id` ,`userid` ,`fname` ,`emailid` ,`contact` ,`dt` ,`tym` ,`typ` ,`remark`)VALUES (NULL ,  '".$uid."',  '".$uid."',  '".$email."',  '".$contact."',  '".$date."',  '".$tym."',  'guest', '".$remark."');"; 
	  }else
	  {
	 $query="INSERT INTO `ordr` (`id` ,`userid` ,`fname` ,`emailid` ,`contact` ,`dt` ,`tym` ,`typ` ,`remark`)VALUES (NULL ,  '".$uid."',  '".$unm."',  '".$email."',  '".$contact."',  '".$date."',  '".$tym."',  'registered', '".$remark."');"; 
	  }
	  	ob_start();
  		
		$obj=new DB_Connect;
  		
		$id=$obj->insert_id($query);
		//$id=mysql_insert_id();
		
		$pid=explode(",",$pids);
		$quan=explode(",",$quans);
		$type=explode(",",$types);				
		
		for($i=0;$i<sizeof($pid);$i++)
		{
		$query="INSERT INTO `order_details` (`id` ,`order_id` ,`product_id` ,`quantity` ,`type`)VALUES(NULL ,  '".$id."',  '".$pid[$i]."',  '".$quan[$i]."',  '".$type[$i]."');";
		
		$result1=$obj->select($query);
		}
		$fromname="Kalash Creations";
		  $to=$email;
		   	$from="info@kalashcreations.com";
			
			$subject_cust=$unm.",Thank you for your Order enquiry to Kalash Creations";
			$subject = "Customer order enquiry From Kalash Creations"; 			
	
	
	$message="You have received an order enquiry from ".$unm." The order is as follows:<br/>";
	$message_cust="You have sent order enquiry to Kalash Creations.We will contact you soon. The order is as follows:<br/>";
	
	$message_order='hi';
            
			for($i=0;$i<sizeof($pid);$i++)
				{
						$pid1=$pid[$i];
						if($type[$i]=='Catalouge'){
						$q="select name from catalog where id=".$pid1;
						}else{
						$q="select name from product where id=".$pid1;
						}
						
						//echo $q;
						
						$res=$obj->select($q);
						if($row=mysql_fetch_array($res))
						{
						$nm=$row[0];	
					//echo $nm;
						}
						$quan1=$quan[$i];
						$type1=$type[$i];	
					
					
				
           			$message_order.= '<tr style="font-size: 16px;line-height: 24px;color: #555;"><td style="border-bottom: 1px solid #eee;">'.$nm.'</td><td style="border-bottom: 1px solid #eee;">'.$quan1.'</td><td style="border-bottom: 1px solid #eee;">'.$type1.'</td></tr>';
				}
				if($remark==""){
	$message_order.='</table></div></body></html>';
		
				}else
				{
	$message_order.='</table><br><br><strong>Remarks:</strong><br>'.$remark.'</div></body></html>';
				}

	$message.=$message_order;
	$message_cust.=$message_order;




//order mail to kalash
	 
			$fields_string=array();
			$fields_string['msg']=urlencode($message);
			$fields_string['name']=urlencode($fromname);
			$fields_string['subject']=urlencode($subject);
			$fields_string['to']=urlencode("pragmatestmail@gmail.com");
			$fields_string['from']=urlencode($email);
			
			$poststr = http_build_query($fields_string);

		
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL,"http://kalashcreations.com/Mail/index.php");
					curl_setopt($ch, CURLOPT_POST, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $poststr);
					curl_setopt($ch,CURL_RETURNTRANSFER,true);		
					
					$result = curl_exec($ch);
					
					//echo $result;
					curl_close($ch);
					
					
					
	
		if($result=="1"){
		
		$response["value"]="success";
		}
		else
		{$response["value"]="fail";
		}
		
		//customer order mail
			$fields_string=array();
			$fields_string['msg']=urlencode($message_cust);
			$fields_string['name']=urlencode($fromname);
			$fields_string['subject']=urlencode($subject_cust);
			$fields_string['from']=urlencode($from);
			$fields_string['to']=urlencode($email);
			
			$poststr = http_build_query($fields_string);

		
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL,"http://kalashcreations.com/Mail/index.php");
					curl_setopt($ch, CURLOPT_POST, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $poststr);
					curl_setopt($ch,CURL_RETURNTRANSFER,true);		
					
					$result = curl_exec($ch);
					
					//echo $result;
					curl_close($ch);
					
					
					
	
		
		
		
		echo str_replace('\/','/',json_encode($response));
  }
   else if($_REQUEST['action']=='login')
  {
	   getjson("SELECT * FROM `users` WHERE uname='".$_REQUEST['uid']."' and password='".$_REQUEST['pwd']."' and status=1 and `user_typ`!='facebook'");
  }
  
     else if($_REQUEST['action']=='single_catalog')
  {
	  $cids=$_REQUEST['cid'];
	//  echo $cids;
	  $cid=explode(",",$cids);	
	//  print_r($pid);  
	  $response=array();
	  $product = array();
	  $response["data"]= array();
	  $obj=new DB_Connect;
	  for($j=0;$j<sizeof($cid);$j++)
	  {
		  
		 
	  $query="SELECT * FROM `catalog`where id=".$cid[$j];
	   
	     $result=$obj->select($query);
	  $fields_num = mysql_num_fields($result);
	  while($row=mysql_fetch_array($result))
	  {
		  for($i=0;$i<$fields_num;$i++)
		  {
			  $product[mysql_field_name($result,$i)]= htmlspecialchars(str_replace("*","'",$row[$i]));
		  }
		   
		 array_push($response["data"], $product);
	  }
	  
	   
	  }
	  
	 echo str_replace('\/','/',json_encode($response)); 
	  
  }

   else if($_REQUEST['action']=='single_product')
  {
	  $pids=$_REQUEST['pid'];
	 // echo $pids;
	  $pid=explode(",",$pids);	
	//  print_r($pid);  
	  $response=array();
	  $product = array();
	  $response["data"]= array();
	  $obj=new DB_Connect;
	  for($j=0;$j<sizeof($pid);$j++)
	  {
		  
		 
	  $query="SELECT product.id, product.name, product.pro_cut,product.pro_size,product.img, product.sku_code, category.cat_name as categoryname,GROUP_CONCAT(distinct(color.name )) as colorname ,GROUP_CONCAT(distinct(color.colorcode)) as colorcode,product.description,GROUP_CONCAT(distinct(catalog.name)) as catname, GROUP_CONCAT(distinct(material.name ))as materialname FROM pro_color,color, product,material,catalog,category WHERE color.id=pro_color.color and category.id=product.category and product.id=".$pid[$j]."  and pro_color.product_id=product.id and FIND_IN_SET(catalog.id,product.catalog)>0 and FIND_IN_SET(material.id,product.material)>0 group by product.id";
	   
	     $result=$obj->select($query);
	  $fields_num = mysql_num_fields($result);
	  while($row=mysql_fetch_array($result))
	  {
		  for($i=0;$i<$fields_num;$i++)
		  {
			  $product[mysql_field_name($result,$i)]= htmlspecialchars(str_replace("*","'",$row[$i]));
		  }
		   
		 array_push($response["data"], $product);
	  }
	  
	   
	  }
	  
	 echo str_replace('\/','/',json_encode($response)); 
	  
  }

  function getjson($query)
  {//include("db_connect.php");
		//echo $query;
	
  $response=array();
	  $product = array();
	  $response["data"]= array();
	  $obj=new DB_Connect;
	  $result=$obj->select($query);
	  $fields_num = mysql_num_fields($result);
	  while($row=mysql_fetch_array($result))
	  {
		  for($i=0;$i<$fields_num;$i++)
		  {
			  $product[mysql_field_name($result,$i)]= htmlspecialchars(str_replace("*","'",$row[$i]));
		  }
		   
		  array_push($response["data"], $product);
	  }
	  
	  
	echo str_replace('\/','/',json_encode($response));
  }
  
   function getinsertjson($query)
  {
	  //include("db_connect.php");
	
	  $response=array();
	  $obj=new DB_Connect;
  		
	  $result=$obj->insert($query);
	 
	  if($result)
		{
			 $response["value"]="success";

			
		}
		else
		{
			 $response["value"]="error";

		
		}
	  
	echo str_replace('\/','/',json_encode($response));
  }
  ?>