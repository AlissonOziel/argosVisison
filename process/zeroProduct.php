<?php 

    session_start();

    include '../back/inicia.php';
    require_once("../back/conect.php");

	$PDO = db_connect(); 

    $id = isset($_GET['id']) ? $_GET['id'] : null;

	$quantity = 0;

	$sql = "UPDATE stokes 
				SET quantity = :quantity
						WHERE id = :id"; 

	$products = $PDO->prepare($sql);
	$products->bindParam(':id', $id, PDO::PARAM_INT);
	$products->bindParam(':quantity', $quantity);

	if($products->execute())
	{
		header("Location: ../detailProduct.php?id=".$id);
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