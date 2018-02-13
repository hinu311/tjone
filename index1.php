<?php

include("header.php");
$obj=new DB_Connect;
//error_Reporting(0);

?>


<?php
if($_REQUEST["btnsubmit"]<>"")
{
	
	$cb_type=$_REQUEST["cb_type"];
	echo $cb_type."<br>";
	$x_file=$_FILES["x_file"]["tmp_name"];
	echo $x_file."<br>";
	set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
	include 'Classes/PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
//$inputFileName = 'discussdesk.xlsx';

	$inputFileName = $x_file; 
	//echo $inputFileName.":infil<br>";
	try 
	{
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		
	} 
	catch(Exception $e) 
	{

		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		
	}
	$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	print_r($allDataInSheet);


	$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
	echo $arrayCount."<br>";


if ($cb_type == "banner")
{	
	echo "<br>"."before unset";
	unset($_SESSION["bannerExcel"]);
	$_SESSSION["bannerExcel"]="";
	echo "<br>"."after unset";
	echo $_SESSSION["bannerExcel"];
	print_r($_SESSION["bannerExcel"]);
	$flag=0;
	$msg2="";
	$msg3="";
	$msg4="";
	$count=0;
//------------------- for loop for each row ------------
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
		
		$bannername = trim($allDataInSheet[$i]["A"]);
		$image = trim($allDataInSheet[$i]["B"]);
		//echo "Image no:".$image;
		if($bannername!='' || $image!='')
		{
		$query = "SELECT * FROM banner WHERE banner_name = '".$bannername."'";
		$bsql =$obj->select($query);
		$recResult = mysql_fetch_array($bsql);
		$existName = $recResult["banner_name"];
		$Mainimage="";
		$msg="";
		if($bannername!='' && $image!='')
		{

			if($existName=="") 
			{
	//--------------- Banner Main image insertion -----
					if (isset($_FILES['files']))
					{
						$targetPath = "uploads/banner/";
						for($i1=0;$i1<count($_FILES['files']['name']);$i1++)
						{
							if($_FILES['files']['name'][$i1]==$image)
							{
								$Mainimage = $_FILES['files']['name'][$i1];
								$MainImageArr = explode(".",$Mainimage);
								$MainImageTemp = $_FILES["files"]["tmp_name"][$i1];
								$MainImageName = str_replace(" ","",$bannername);
								$Mainimage = $MainImageName.".".$MainImageArr[1];
								if(file_exists($targetPath.$Mainimage))						
								{
									$j=0;
									$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
									while(file_exists($targetPath.$Mainimage))
									{
										$j++;
										$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
									}
									copy($MainImageTemp,$targetPath.$Mainimage);								
								}
								else
								{
									copy($MainImageTemp,$targetPath.$Mainimage);								
								}
								
								$insertbanner= "insert into banner(banner_name, img) values('".$bannername."', '".$Mainimage."')";
								if ($obj->insert($insertbanner))
								{
									$flag=1;
									$count++;
								}
								break;	
							}
						}
					}
		//--------------- Banner Main Image completion  -----
			}
			else 
			{
				$msg = 'Record no. '.$i.": ".$bannername."".' Banner name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["bannerExcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";
				
			}
		}
		else
		{
			if($bannername == '')
			{
				$msg2='Banner Name';
			}
			if($image == '')
			{
				$msg2.=',Banner image';
			}
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
$_SESSION["bannerExcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			
			$msg2="";
		} //Banner name check completion
		}//checking null data in excel if completed
	}// for loop of excel file ends
	
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["bannerExcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4."</div>";
	}
	else
	{
		
		echo "<div style='font: bold 18px arial,verdana;padding: 20px 0 0 20px;'>No Records added in Database. <div style='Padding:20px 0 0 0;color:rgb(256,0,0)'></div></div>";		
		$_SESSION["bannerExcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";
	}
	header("location:banner.php");
	//echo "<br>"."last";
	//print_r($_SESSION["bannerExcel"]);
}

//--------------- CATALOG INSERTION  ------------
else if ($cb_type == "catalog")
{
	$_SESSSION["Catalogexcel"]="";
	$msg1="";
	$flag=0;
	$msg2="";
	$msg3="";
	$msg4="";
	$msg5="";
	$count=0;
	$targetPath = "uploads/catalog/";
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
		$name = trim($allDataInSheet[$i]["A"]);
		$image = trim($allDataInSheet[$i]["B"]);
		$Mainimage="";
		if($name!='' || $image!='')
		{
		$query = "SELECT * FROM catalog WHERE name = '".$name."'";
		//echo $query;
		$csql = $obj->select($query);
		$recResult = mysql_fetch_array($csql);
		$existName = $recResult["name"];
		if($name!=""&& $image!='')
		{
			if($existName=="") 
			{
					//--------------- Catalog Main image insertion -----
					if (isset($_FILES['files']))
					{
						for($c=0;$c<count($_FILES['files']['name']);$c++)
						{
							if($_FILES['files']['name'][$c]==$image)
							{
								$Mainimage = $_FILES['files']['name'][$c];
								$MainImageArr = explode(".",$Mainimage);
								$MainImageTemp = $_FILES["files"]["tmp_name"][$c];
								$MainImageName = str_replace(" ","",$name);
								$Mainimage = $MainImageName.".".$MainImageArr[1];
								if(file_exists($targetPath.$Mainimage))						
									{
										$j=0;
										//echo "file exists targetpath check";
										$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
										while(file_exists($targetPath.$Mainimage))
										{
											$j++;
											$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
										}
										copy($MainImageTemp,$targetPath.$Mainimage);								
									}
								else
									{
										copy($MainImageTemp,$targetPath.$Mainimage);								
									}
									$insert_catalog= "insert into catalog(name, img) values('".$name."', '".$Mainimage."')";
									if($obj->insert($insert_catalog))
									{
										$flag=1;
										$count++;
									}
									break;
							}
						}
					}
	//--------------- Catalog Main Image completion  -----	
				} 
			else 
			{
				$msg = 'Record no. '.$i.": ".$name."".' Catalog name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["Catalogexcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";
						
			}
		}
		else
		{
			if($name == '')
			{
				$msg2='Catalog Name';
			}
			if($image == '')
			{
				$msg2.='Catalog image';
			}
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
$_SESSION["Catalogexcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			$msg2="";
		
		}// Catalog name in excel file checked
		}
	}// for loop of excel file completed
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["Catalogexcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	
	
	}
	else
	{
		$_SESSION["Catalogexcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";
	
	}
	header("location:catalog.php");
}

//--------------- CATEGORY INSERTION  -----

else if ($cb_type == "category")
{
	$_SESSSION["Categoryexcel"]="";
	$msg="";
	$flag=0;
	$msg2="";
	$msg1="";
	$msg3="";
	$msg4="";
	$msg5="";
	$count="";
	$targetPath = "uploads/category/";
	$Mainimage="";	
	for($i=2;$i<=$arrayCount;$i++)
	{
 //--------------- take each field of table -----
		$cat_name = trim($allDataInSheet[$i]["A"]);
		$image = trim($allDataInSheet[$i]["B"]);
		if($cat_name!='' || $image!='')
		{
		
		$catquery = "SELECT * FROM category WHERE cat_name = '".$cat_name."'";
		$casql = $obj->select($catquery);
		$recResult = mysql_fetch_array($casql);
		$existName = $recResult["cat_name"];
		
		if($cat_name!="" && $image!="")
		{
				if($existName=="")
				{
	//--------------- Category Main image insertion -----
				
					if (isset($_FILES['files']))
					{
						for($ct=0;$ct<count($_FILES['files']['name']);$ct++)
						{
							if($_FILES['files']['name'][$ct]==$image)
							{
								$Mainimage = $_FILES['files']['name'][$ct];
								$MainImageArr = explode(".",$Mainimage);
								$MainImageTemp = $_FILES["files"]["tmp_name"][$ct];
								$MainImageName = str_replace(" ","",$cat_name);
								$Mainimage = $MainImageName.".".$MainImageArr[1];
								if(file_exists($targetPath.$Mainimage))						
								{
									$j=0;
									$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
									while(file_exists($targetPath.$Mainimage))
									{
										$j++;
										$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
									}
									copy($MainImageTemp,$targetPath.$Mainimage);								
								}
								else
								{
									copy($MainImageTemp,$targetPath.$Mainimage);								
								}
								$insertcategory= "insert into category(cat_name, img) values('".$cat_name."', '".$Mainimage."')";
								if($obj->insert($insertcategory))
								{
									$flag=1;
									$count++;
								}
								break;
							}
						}
				}
		//--------------- Category Main Image completion  -----	
			}
			else 
			{
				$msg = 'Record no. '.$i.": ".$cat_name."".' Category name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["Categoryexcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";			
			}
		}
		else
		{
			if($name == '')
			{
				$msg2='Category Name ';
			}
			if($image == '')
			{
				$msg2.='Category image';
			}
			
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
$_SESSION["Categoryexcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			$msg2="";
		}// Catergory name checked in excel file
		}
	}//for loop for excel file completed
	if ($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["Categoryexcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	
	}
	else
	{
		$_SESSION["Categoryexcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";	
	}
	header("location:category.php");
}

//--------------- Color Data Insertion  -----	
else if ($cb_type == "color")
{
	$_SESSION["Colorexcel"]="";
	$flag=0;
	$msg3="";
	$msg4="";
	$msg2="";
	$msg1="";
	$msg="";
	$count=0;
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
		$name = trim($allDataInSheet[$i]["A"]);
		$colorcode = trim($allDataInSheet[$i]["B"]);
		if($name!='' || $colorcode!='')
		{
		$colquery = "SELECT * FROM color WHERE name = '".$name."' ";
		$csql = $obj->select($colquery);
		$recResult = mysql_fetch_array($csql);
		$existName = $recResult["name"];
		$msg="";
		if($name!="" && $colorcode!="")
		{
			if($existName=="") 
			{
				$insert_color= "insert into color(name, colorcode) values('".$name."', '".$colorcode."')";
				if($obj->insert($insert_color))
				{
					$flag=1;
					$count++;
				}
			} 
			else 
			{
				$msg = 'Record no. '.$i.": ".$name."".' Color name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["Colorexcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";	
			
			}
		}
		else
		{
			//$msg2=1;
			if($name == '')
			{
				$msg2='Color Name ';
			}
			if($colorcode == '')
			{
				$msg2.='Color code';
			}
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
			$_SESSION["Colorexcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			$msg2="";
		}
		}
	}// for loop for excel file completed
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["Colorexcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	

	}
	else
	{
		$_SESSION["Colorexcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";	
	}
	header("location:color.php");
	
}

//--------------- Level Data Insertion  -----	

else if ($cb_type == "level")
{
	$_SESSION["Levelexcel"]="";
	$flag=0;
	$msg4="";
	$msg3="";
	$msg="";
	$msg2="";
	$msg1="";
	$count=0;
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
		$user_level = trim($allDataInSheet[$i]["A"]);
		$catalog_id = trim($allDataInSheet[$i]["B"]);
		if($user_level!='' || $catalog_id!='')
		{
		
		$catalog_query="select group_concat(id) FROM catalog  WHERE fiND_in_set (upper(name),upper('".$catalog_id."'))>0";
		$catalog_exe=$obj->select($catalog_query);
		$catalog_fetch=mysql_fetch_array($catalog_exe);
		$query = "SELECT * FROM level WHERE user_level = '".$user_level."'";
		$lsql = $obj->select($query);
		$recResult = mysql_fetch_array($lsql);
		$existName = $recResult["user_level"];
		
		if($user_level!="" && $catalog_fetch[0])
		{
			if($existName=="") 
			{
				$insertTable= "insert into level(user_level, catalog_id) values('".$user_level."', '".$catalog_fetch[0]."')";
				if($obj->insert($insertTable))
				{
					$flag=1;
					$count++;
				}
				
			} 
			else 
			{
				$msg = 'Record no. '.$i.": ".$user_level."".' Level name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["Levelexcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";	

			}
		}
		else
		{
			//$msg2=1;
			if($user_level == '')
			{
				$msg2='Level Name';
			}
			if($catalog_fetch[0] == '')
			{
				$msg2.='Catalog Name';
			}
			
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
			$_SESSION["Levelexcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			$msg2="";
		}
		}
	}//for loop for excel file completed
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["Levelexcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	

	}
	else
	{
				$_SESSION["Levelexcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";	
	}
	header("location:level1.php");
	
}


//--------------- Material Data Insertion  -----	
else if ($cb_type == "material")
{	
	$_SESSION["Materialexcel"];
	$msg3="";
	$msg4="";
	$msg5="";
	$flag=0;
	$msg="";
	$msg2="";
	$msg1="";
	$count="0";
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
//		$category_id = trim($allDataInSheet[$i]["A"]);
		$name = trim($allDataInSheet[$i]["A"]);
		/*$category_query="select group_concat(id) FROM category  WHERE fiND_in_set (cat_name,'".$category_id."')>0";
		$category_exe=mysql_query($category_query,$link);
		$category_fetch=mysql_fetch_array($category_exe);*/
		if($name!='')
		{
		
		$query = "SELECT * FROM material WHERE name = '".$name."'";
		$msql = $obj->select($query);
		$recResult = mysql_fetch_array($msql);
		$existName = $recResult["name"];
		
		if($name!="")
		{
			if($existName=="")
			{
				$insertTable= "insert into material(category_id, name) values('', '".$name."')";
				if($obj->insert($insertTable))
				{
					$flag=1;
					$count++;
				}
			} 
			else 
			{
				$msg = 'Record no. '.$i.": ".$name."".' Material name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["Materialexcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";	
				
			}
		}
		else
		{
			//$msg2=1;
			if($name == '')
			{
				$msg2='Material Name';
			}
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
			$_SESSION["Materialexcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			$msg2="";
		}
		}
	}// for loop for excel file completion
	
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["Materialexcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	
	}
	else
	{
		$_SESSION["Materialexcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";	
	}
		header("location:fabric.php");
	}



//--------------- Product Data Insertion  -----	
else if ($cb_type == "product")
{
	$_SESSION["ProductExcel"]="";
	$flag=0;
	$msg6="";
	$msg3="";
	$msg4="";
	$msg5="";
	$msg="";
	$msg1="";
	$msg2="";
	$count=0;
	for($i=2;$i<=$arrayCount;$i++)
	{
//--------------- take each field of table -----
		$name = trim($allDataInSheet[$i]["A"]);
		$img = trim($allDataInSheet[$i]["B"]);
		//$price = trim($allDataInSheet[$i]["C"]);
		$squcode = trim($allDataInSheet[$i]["C"]);

		$category = trim($allDataInSheet[$i]["D"]);
		$description = trim($allDataInSheet[$i]["E"]);
		$catalog = trim($allDataInSheet[$i]["F"]);
		$material = trim($allDataInSheet[$i]["G"]);
		$pro_size = trim($allDataInSheet[$i]["H"]);
		$pro_cut = trim($allDataInSheet[$i]["I"]);
		$recommend = trim($allDataInSheet[$i]["J"]);
		$featured = trim($allDataInSheet[$i]["K"]);
		
		$procolor = trim($allDataInSheet[$i]["L"]);
		$proimage = trim($allDataInSheet[$i]["M"]);
		$Mainimage="";
		$MAinFlag=0;
		if($name!='' || $img!='' || $squcode!='' ||$category!=''|| $description!=''||$catalog!=''|| $material!=''|| $pro_size!=''|| $pro_cut!=''|| $recommend !=''|| $featured!=''|| $procolor!=''|| $proimage !='' )
		{
		$category_query="select group_concat(id) FROM category  WHERE fiND_in_set (upper(cat_name),upper('".$category."'))>0";
		$category_exe=$obj->select($category_query);
		$category_fetch=mysql_fetch_array($category_exe);
		
		$catalog_query="select group_concat(id) FROM catalog  WHERE fiND_in_set (upper(name),upper('".$catalog."'))>0";
		$catalog_exe=$obj->select($catalog_query);
		$catalog_fetch=mysql_fetch_array($catalog_exe);
		
		$material_query="select group_concat(id) FROM material  WHERE fiND_in_set (upper(name),upper('".$material."'))>0";
		$material_exe=$obj->select($material_query);
		$material_fetch=mysql_fetch_array($material_exe);
		//----------get commasaprated color id 
		$color_query="select group_concat(id) FROM color  WHERE fiND_in_set (upper(name),upper('".$procolor."'))>0";
		$color_exe=$obj->select($color_query);
		$color_fetch=mysql_fetch_array($color_exe);
		$query = "SELECT * FROM product WHERE name = '".$name."'";
		$sql = $obj->select($query);
		$recResult = mysql_fetch_array($sql);
		$existName = $recResult["name"];
		if($name!="" && $img!="" && $category!="" && $catalog!="" && $material!="" && $procolor!="")
		{
			if($existName=="") 
			{
				if (isset($_FILES['files']))
				{
					$targetPath = "uploads/products/";
					for($p=0;$p<count($_FILES['files']['name']);$p++)
					{
						if($_FILES['files']['name'][$p]==$img)
						{
							$Mainimage = $_FILES['files']['name'][$p];
							$MainImageArr = explode(".",$Mainimage);
							$MainImageTemp = $_FILES["files"]["tmp_name"][$p];
							$MainImageName = str_replace(" ","",$name);
							$Mainimage = $MainImageName.".".$MainImageArr[1];
							if(file_exists($targetPath.$Mainimage))						
							{
								$j=0;
								$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
								while(file_exists($targetPath.$Mainimage))
								{
									$j++;
									$Mainimage = $MainImageName."_".$j.".".$MainImageArr[1];
								}
								copy($MainImageTemp,$targetPath.$Mainimage);							
							}
							else
							{
								copy($MainImageTemp,$targetPath.$Mainimage);								
							}	
							$MAinFlag=1;
							break;
						}
					}
				}
				
				
				if($catalog_fetch[0]!="" &&$material_fetch[0]!="" &&$category_fetch[0]!="")
				{
				if($MAinFlag==1)
				{
					$insert_product= "insert into product(`name`,`img`,`sku_code`,`category`,`description`,`catalog`,`material`,`pro_size`,`pro_cut`,`recommend`,`featured`) values('".$name."', '".$Mainimage."','".$squcode."','".$category_fetch[0]."','".$description."','".$catalog_fetch[0]."','".$material_fetch[0]."','".$pro_size."','".$pro_cut."','".$recommend."','".$featured."')";
				
					if($obj->insert($insert_product))
					{
						$flag=1;
						$count++;
						$arr=explode(',',$color_fetch[0]);
						$productid=mysql_insert_id();
						for($i1=0;$i1<sizeof($arr);$i1++)
						{
							$product_color="insert into pro_color(`product_id`,`color`) values('".$productid."','".$arr[$i1]."')";
							$obj->insert($product_color,$link);
						}

						$arr1=explode(',',$proimage);
						for($i2=0;$i2<sizeof($arr1);$i2++)
						{
							if (isset($_FILES['files']))
							{
								$targetPath = "uploads/products/";
								for($sub=0;$sub<count($_FILES['files']['name']);$sub++)
								{
									if($_FILES['files']['name'][$sub]==$arr1[$i2])
									{
											$Subimage = $_FILES['files']['name'][$sub];
											$SubImageArr = explode(".",$Subimage);
											$SubImageTemp = $_FILES["files"]["tmp_name"][$sub];
											$Subimage = $productid."_".$i2.".".$SubImageArr[1];;
											if(file_exists($targetPath.$Subimage))						
											{
												$j=0;
												$Subimage = $productid."_".$i2.$j.".".$SubImageArr[1];								
												while(file_exists($targetPath.$Subimage))
												{
													$j++;
													$Subimage = $productid."_".$i2.$j.".".$SubImageArr[1];
												}
												copy($SubImageTemp,$targetPath.$Subimage);							
											}
											else
											{
												copy($SubImageTemp,$targetPath.$Subimage);								
											}	
											$product_image="insert into pro_sub_images(`product_id`,`img`) values('".$productid."','".$Subimage."')";
											$obj->insert($product_image,$link);
											break;
									}
								}
							}
						}
					 }
					else
					{
							$msg6 = 'Record no. '.$i.": ".$name."".' SKU code already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["ProductExcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg6."</div>";
								
					}
				}
				
				
				else
				{
					$msg5 = 'Record no. '.$i.": '".$name.' Record Main Image not selected. <div style="Padding:0px 0 0 0;"></div>';
					$_SESSION["ProductExcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg5."</div>";
				}
				}
				else
				{
					if($category_fetch[0]=="")
					{
						$ms='Category' ;
					}
					if($material_fetch[0]=="")
					{
						$ms.=' Material';
					}
					if($catalog_fetch[0]=="")
					{
						$ms.='Catalogue';
					}
					
					$msg3='Record no. '.$i.": ".trim($ms,',').' not present in database';
				$_SESSION["ProductExcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
				$ms="";
				
				}
			}	 
			else 
			{
				$msg = 'Record no. '.$i.": ".$name."".' Product name already exists in database. <div style="Padding:0px 0 0 0;"></div>';
				$_SESSION["ProductExcel"].="<div style='font-family:serif;font-size:18px;color:rgb(0,128,0);padding: 10px 0 0 20px;'>".$msg."</div>";	

			}
//--------------- Exist Name checking completed  -----				
			
		}
		else
		{
			if($name == '')
			{
				$msg2='Product Name ';
			}
			if($img == '')
			{
				$msg2.='Product Main Image ';
			}
			if($category == '')
			{
				$msg2.='Category Name ';
			}
			if($catalog == '')
			{
				$msg2.='Catalog ';
			}
			if($material == '')
			{
				$msg2.='Material ';
			}
			if($procolor == '')
			{
				$msg2.='Color Name ';
			}
			$msg3='Record no. '.$i.": ".trim($msg2,',').' not present in Excel file';
			$_SESSION["ProductExcel"].= "<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;color:rgb(256,0,0);'>".$msg3."</div>";
			
			
			$msg2="";
			
		}
		//--------------- Product Name check in excel file completed  -----	
		}
	}
	//--------------- for loop of excel file file completed  -----	
	if($flag==1)
	{
		$msg4=$count.' Records added to Database.';
		$_SESSION["ProductExcel"].="<div style='font-family:serif;font-size:18px;padding:10px 0 0 20px;'>".$msg4." </div>";	
	}
	else
	{
		$_SESSION["ProductExcel"].= "<div style='font-family:serif;font-size:18px;padding: 10px 0 0 20px;'>No Records added in Database. </div>";
	}
		header("location:product.php");
	}
}

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>
</head>
<body>
	<div class="page-head">
    	<h3 class="m-b-less">
			Excel File 
        </h3>
   	</div>

 							 <div class="wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                          
                            <div class="panel-body">
                                <div class=" form">

<!--<form class="cmxform form-horizontal tasi-form" enctype="multipart/form-data" method="post" role="form">-->
<form class="cmxform form-horizontal tasi-form" id="commentForm" method="post" action="" enctype="multipart/form-data">
                        
                                 
                                 <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Select Data*</label>
                                            <div class="col-lg-9 col-md-8">	
                               
                                
                                 
                                 <select id="cb_type" name="cb_type" onChange="showimage(this.value)" style="width:50%" class="form-control " name="cb_type" required>
                                  <option value=""> Select type</option>
                                 <option value="banner"> Banner</option>
                                  <option value="catalog"> Catalogue</option>
                                  <option value="category">Category</option>
                                  <option value="color">Color</option>
                                  <option value="level">Level</option>
                                  <option value="material">Fabric</option>
                                  <option value="product">Product</option>
                                </select>
                               </div>
                               </div>
                                 
                                 
                                <div class="form-group ">
                                            <label for="cname" class="control-label col-lg-2">Excel File Upload*</label>
                                            <div class="col-lg-9 col-md-8">
                                 
                                 <input type="file"class="btn btn-success" name="x_file" id="x_file"  required>
                                </div>
                                </div> 
                                 
                                 
                                <div id="images" class="form-group" hidden="true">
                                	<label for="cname" class="control-label col-lg-2">Images*</label>
                                    	<div class="col-lg-9 col-md-8">
      		                         <input type="file" class="btn btn-success"  name="files[]" id="upload" multiple value=""  />
                                        </div>
                                </div>
								
                                 
                               
                                
                        <div class="form-group ">
                                            
                                           <div class="col-lg-offset-2 col-lg-10">  
                         <button type="submit" class="btn btn-default" name="btnsubmit" type="submit" value="submit">Upload</button>
                         </div>
                         </div>
                    </form>
                    </div>
                    </div>
                    </section>
                    </div>
                    </div>
                    </div>

</body>
</html>
<script type="text/javascript">

 function showimage(val)
{
		//alert(val);
	if(val == "banner" || val == "catalog" || val == "category" || val == "product")
	{
		document.getElementById("upload").setAttribute("required","true");		
		document.getElementById("images").hidden = false;
	}
	else
	{
		//alert ("1");
		document.getElementById("upload").removeAttribute("required");
		document.getElementById("images").hidden = true;
	}
	 
}

</script>
<?php
include("footer.php");
?>