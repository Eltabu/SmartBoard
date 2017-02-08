<?php 
    require_once  ("Includes/logsession.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SmartBoard</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="SmartBord" />
		<meta name="keywords" content="SmartBord" />
		<link rel="stylesheet" href="css/Loginstyle.css" />
        <script src="js/login.js"></script>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body> 

				<!-- Header -->
					<header id="header">
						<h1>SmartBoard</h1>
						
                        <form name="login-form" class="login-form" action="index.php" method="post" onsubmit="return check_info();" >
	                        
                            <h2>Login Form</h2>
		                    <div class="content">
		                    <input name="username" id="username" type="text" class="input username" placeholder="Username" />
		                    <div class="user-icon"></div>
		                    <input name="password" id="password" type="password" class="input password" placeholder="Password" />
		                    <div class="pass-icon"></div>		
		                    </div>

		                    <div class="footer">
		                    <input type="submit" id="login_button" name="submit" value="Login" class="button" />
                            <input type="text" id="alart_message" value="" readonly="readonly" />
  		                    </div>
	
	                    </form>
					</header>


        <?php include ("Includes/closeDB.php");  ?>      
			<!-- Footer -->
			<div id="loginfooter">
				
				<!-- Copyright -->
					<ul class="copyright">
						<li>&copy; 2015 SmartBoard. All rights reserved.</li><li>Design: <a href="http://eltabu.myweb.cs.uwindsor.ca">Moad                                       Eltabu</a></li>
					</ul>
				
			</div>
				
	</body>
</html>
