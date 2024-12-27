<?php
	session_start();

	include '../back/inicia.php';
	include_once("../back/conect.php");

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$email = isset($_POST['email']) ? $_POST['email'] : null;
    $type = isset($_POST['type']) ? $_POST['type'] : null;

    $code = "acess01";
    
    $password = md5($code);

    $active = 1;

	$PDO = db_connect();


    $sql = "INSERT INTO users (name, 
                                email, 
                                password,
                                active,
                                type
                                )
						  values (:name, 
                                  :email, 
                                  :password,
                                  :active,
                                  :type)";

	$products = $PDO->prepare($sql);

	$products->bindParam(':name', $name);
	$products->bindParam(':email', $email);
    $products->bindParam(':password', $password);
    $products->bindParam(':active', $active);
    $products->bindParam(':type', $type);

	if($products->execute())
	{
		header("Location: ../cadUser.php");
	}
	else
	{
		header('Location: erro/erroCad.php');
	}

?>