<?php
include("db_connect.php");
include("config.php");
$obj=new DB_Connect;
	
	$LoginQuery="Select * from users where uname='".str_replace('\'', '*', $_REQUEST["username"])."' and password='".str_replace('\'', '*', $_REQUEST["password"])."' and (user_typ = 'admin' or user_typ='sa') ";
	
	$Result  = $obj->select($LoginQuery);
	$Row=mysql_fetch_array($Result);
	$RowCount=mysql_num_rows($Result);

	if($RowCount>0)
	{
		$Username = $Row["uname"];
		$Password = $Row["password"];			
		session_start();
		$_SESSION["login"]="true";
		$_SESSION["user"] = $_REQUEST["username"];
		$_SESSION["desig"]= $Row["user_typ"];
		header("location:home.php");					
	}
	else
	{	
		header("location:index.php?msg=UserName/Password is WRONG...");          		
	}
?>