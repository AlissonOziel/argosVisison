<?php 

    session_start();

    include '../back/inicia.php';
    require_once("../back/conect.php");

    $id = isset($_POST['id']) ? $_POST['id'] : null;

	$active = 0;


	$PDO = db_connect(); 

	$sql = "UPDATE stokes 
				SET active = :active
					WHERE id = :id"; 

	$products = $PDO->prepare($sql);
	$products->bindParam(':id', $id, PDO::PARAM_INT); 
	$products->bindParam(':active', $active);
	

	if($products->execute())
	{
		header("Location: ../products.php");
	}
	else
	{
		header('Location: erro/erroCad.php');
	}

	

	if ($stmt->execute()) 
	{
		header('Location: ../index.php'); 
	}
	else 
	{
		echo "Erro ao alterar"; print_r($stmt->errorInfo()); 

	}

?>