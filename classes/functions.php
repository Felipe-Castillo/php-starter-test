<?php


class func 
{
	

	public static function logout($access_token)
	{

		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => 'https://auth.dev.graphs.social/v4/login/logout?access_token='.$access_token,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => false,
		CURLOPT_FOLLOWLOCATION => true
		));
		$output = curl_exec($ch);
	    $query=json_decode($output,true);
	    return $query;
	}

	public static function checkLoginState()
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		if (isset($_COOKIE['access_token'])) 
		{

			if ($_COOKIE['access_token']==$_SESSION['access_token']) 
			{
				return true;
			}
			else
		   {
			func::createSession($_COOKIE['access_token']);

			return true;
		}
     
		}

	}

	public static function createRecord($access_token)
	{
		func::createCookie($access_token);
		func::createSession($access_token);
	}

	public static function createSession($access_token)
	{

		if (!isset($_SESSION))
	    {
			session_start();
		}

		$_SESSION['username']="beta_tester";
		$_SESSION['access_token']=$access_token;

	}


	public static function createCookie($access_token)
	{

		setcookie('access_token',$access_token,time()+(86400)*30,"/");

	}

	public static function deleteCookies()
	{
		 $_l=self::logout($_SESSION['access_token']);
		if ($_l["status"]=="ok") 
		{

		setcookie('access_token','',time()-1,"/");
		session_destroy();
		}
		
	}




}