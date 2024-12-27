<?php
	session_start();

	include '../back/inicia.php';
	include_once("../back/conect.php");

	$user = isset($_POST['user']) ? $_POST['user'] : null;
	$value = isset($_POST['value']) ? $_POST['value'] : null;
    
	$date = date('Y-m-d H:i:s');

	$PDO = db_connect();

	$pay = filter_var($value, FILTER_VALIDATE_FLOAT);

    $sql = "INSERT INTO accounts (	created_at, 
                                  	value, 
                                	user
                                )
						  values (:date, 
                                  :pay, 
                                  :user)";

	$products = $PDO->prepare($sql);

	$products->bindParam(':date', $date);
	$products->bindParam(':pay', $pay);
    $products->bindParam(':user', $user);

	if($products->execute())
	{
		header("Location: ../finances.php");
	}
	else
	{
		header('Location: erro/erroCad.php');
	}

?>