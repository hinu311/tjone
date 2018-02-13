<?php
ob_start();
include("db_connect.php");
include("config.php");
session_start();
	if(!isset($_SESSION["login"]) || !isset($_SESSION["user"]) || !isset($_SESSION["desig"]))
	{
		header("location:index.php");
	}	
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="Mosaddek" />
    <meta name="keyword" content="slick, flat, dashboard, bootstrap, admin, template, theme, responsive, fluid, retina" />
    <meta name="description" content="" />

<style>
table
{
	text-align:center;
}
thead th
{
	text-align:center;
}
</style>

	<link rel="shortcut icon" href="img/ico/favicon3.png">
    <title>TJ ONE CONSTRUCTION</title>
	<link href="js/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/vector-map/jquery-jvectormap-1.1.1.css">
    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css"/>    
    <link href="css/slidebars.css" rel="stylesheet">
	<link href="js/switchery/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet" />
	<link href="js/icheck/skins/all.css" rel="stylesheet">
	<link href="css/owl.carousel.css" rel="stylesheet">
	<link href="css/select2.css" rel="stylesheet">
    <link href="css/select2-bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="css/style-responsive.css" rel="stylesheet">
    <link href="js/data-table/css/jquery.dataTables.css" rel="stylesheet">
    <link href="js/data-table/css/dataTables.tableTools.css" rel="stylesheet">
    <link href="js/data-table/css/dataTables.colVis.min.css" rel="stylesheet">
    <link href="js/data-table/css/dataTables.responsive.css" rel="stylesheet">
    <link href="js/data-table/css/dataTables.scroller.css" rel="stylesheet">
</head>

<body class="sticky-header">
    <section>
        <div class="sidebar-left sticky-sidebar">
            <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="brand-name">TJ ONE </span>
                </a>
            </div>
            <div class="sidebar-left-info">
                <div class=" search-field">  </div>
                <ul class="nav nav-pills nav-stacked side-navigation">
               		<li class="active"><a href="home.php"> <center><span style="font-size:16px">Dashboard</span></center></a></li>
               		<li><h3 class="navigation-title"></h3></li>
					<li><a href='catalog.php'><i class="fa fa-upload"></i><span>Category</span></a></li>
				     <li><a href='category.php'><i class="fa fa-paint-brush"></i><span>Category Image</span></a></li>
                    </ul>                      
                   
            </div>
            </div>
        <div class="body-content" >
            <div class="header-section">
                <div class="logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="home.php">
                        <i class="fa fa-home"></i>
                        <span class="brand-name">TJ ONE </span>
                    </a>
                </div>
                <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="home.php">                       
                        <i class="fa fa-home"></i>
                    </a>
                </div>
                <a class="toggle-btn"><i class="fa fa-outdent"></i></a>
				<div class="notification-wrap">
               	<div class='right-notification'>
					<ul class='notification-menu'>
						<li>
							<a href='' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
								<img src='img/icon-leader.png' alt=''><span class=' fa fa-angle-down'></span>
							</a>
							<ul class='dropdown-menu dropdown-usermenu purple pull-right'>
								<li><a href='ChangePD.php'>Change Password</a></li>
								<li><a href='logout.php'><i class='fa fa-sign-out pull-right'></i>Log Out</a></li>
							</ul>
						</li>                       
					</ul>
				</div>
                </div>
            </div>
<?php
if($_REQUEST["msg"]<>"")
{

?>
	<div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="fa fa-times"></i></button>
	    <strong>
			Message : 
    	</strong>
			<?php echo $_REQUEST["msg"] ?>
	</div>
<?php
}
?>

<?php
if($_REQUEST["msg1"]<>"")
{
?>
	<div class="alert alert-dismissable alert-danger fade in">
    	<button class="close close-sm" type="button" data-dismiss="alert"><i class="fa fa-times"></i></button>
    	<strong>
			Message : 
    	</strong>
			<?php echo $_REQUEST["msg1"] ?>
	</div>
<?php
}
ob_start();
?>
<script type="text/javascript">
function changeAC()
{
	var acyr = document.getElementById("acy").value;
	document.getElementById("forgotPass").style.display="none";
	var dataString = 'accyear='+acyr ;
	$.ajax({
		type: "POST",
		url: "Action.php?action=changeyr",
		data: dataString,
		cache: false,
		success: function(result){
		}
	});
}
</script>