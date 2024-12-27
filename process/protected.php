<?php 

	if(!function_exists("protectedAdm")){
		
		function protectedAdm()
		{
			if(!isset($_SESSION))
				session_start();

			if(!isset($_SESSION['adm']) || !is_numeric($_SESSION['adm']))
			{
				header("location: login.php");
			}
		}
	}

?>