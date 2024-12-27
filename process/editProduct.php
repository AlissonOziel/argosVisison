<?php 

    session_start();

    include '../back/inicia.php';
    require_once("../back/conect.php");

    $id = isset($_POST['id']) ? $_POST['id'] : null;

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $value = isset($_POST['value']) ? $_POST['value'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    $category = isset($_POST['category']) ? $_POST['category'] : null;


	$PDO = db_connect(); 

	$sql = "UPDATE stokes 
				SET name = :name,
					quantity = :quantity,
                    value = :value,
                    price = :price,
                    category = :category
						WHERE id = :id"; 

	$products = $PDO->prepare($sql);
	$products->bindParam(':id', $id, PDO::PARAM_INT); 
	$products->bindParam(':name', $name);
	$products->bindParam(':quantity', $quantity);
    $products->bindParam(':value', $value);
	$products->bindParam(':price', $price);
    $products->bindParam(':category', $category);

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