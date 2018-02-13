<?php
ob_start();
//$cn = mysql_connect('kalash1.db.11769512.hostedresource.com','kalash1','Creation@1');
$cn = mysql_connect('localhost','root','');
mysql_select_db('kalash1',$cn) or die("Connection Failed");
//session_save_path('/tmp');
session_start();
error_reporting(0);
?>