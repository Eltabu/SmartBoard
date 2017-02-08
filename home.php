<?php ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
?>
<?php require_once ("Includes/header.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>SmartBord</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="css/style1.css" />
        <script src="http://code.jquery.com/jquery-1.8.0.min.js" type="text/javascript" ></script>
        <script src="js/mian.js" type="text/javascript" ></script>
	</head>
	<body>
		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<img class="image" src="images/user.png" alt="User Image" />
							<h1 id="title"><?php echo get_name();?></h1>
							<p> <?php echo get_title(); ?> </p>
						</div>

					<!-- Nav -->
						<nav id="nav">
		
							<ul>
								<li><a href="#news" id="top-link" ><span >News</span></a></li>
								<?php get_list();?>
							</ul>
						</nav>
                    <!------ Sign Out ----->
						<div>
                            <form name="logoff-form"  action="Includes/logoff.php" method="post">
                                <input type="submit" value="Sign Out" id="logoff" />
                            </form>
                        </div>
				</div>
	
			</div>

		<!-- Main -->
			<div id="main">
                <?php require_once ("Includes/main.php"); ?> 
             </div>

        				
<!-- Footer -->
<?php include ("Includes/footer.php"); ?>