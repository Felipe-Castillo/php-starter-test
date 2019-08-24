<?php


// Show PHP errors
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 
require_once 'classes/Post.php';

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Head metas, css, and title -->
        <?php require_once 'includes/head.php';?>
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/css/login.css">

    </head>
    <body>
        <!-- Header banner -->
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
&nbsp;
</nav>
        <div class="container-fluid">
            <div class="row">

            	<div class="col-md-12">
            		<h1>&nbsp;</h1>
  	<?php

		

			if (func::checkLoginState()) 
			{
				header("location:index.php");
			}


				if (isset($_GET['email'])&& isset($_GET['password'])) 
				{
			
					//authenticate here
						$ch = curl_init();
						curl_setopt_array($ch, array(
						CURLOPT_URL => 'https://auth.dev.graphs.social/v3/login?email='.$_GET['email'].'&password='.$_GET['password'].'&application_id=5b51eb29303935456453d09a',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_POST => false,
						CURLOPT_FOLLOWLOCATION => true
						));

						$output = curl_exec($ch);
						$query=json_decode($output,true);

					if (!empty($query)) 
					{

						func::createRecord($query["data"]["access_token"]);
						header("location:index.php");
					}
			     	}
					else
					{	

						include_once("forms/login.php");
					}



		?>

            	</div>
            
            </div>
        </div>
        <!-- Footer scripts, and functions -->
        <?php require_once 'includes/footer.php'; ?>
       
    </body>
</html>
