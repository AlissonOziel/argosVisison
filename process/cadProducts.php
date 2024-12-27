<?php
	session_start();

	include '../back/inicia.php';
	include_once("../back/conect.php");

	$name = isset($_POST['name']) ? $_POST['name'] : null;
	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $value = isset($_POST['value']) ? $_POST['value'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;

    $category = isset($_POST['category']) ? $_POST['category'] : null;

    $attribution = $quantity;

    $active = 1;

	$PDO = db_connect();


    $sql = "INSERT INTO stokes (name, 
                                quantity, 
                                value,
                                price,
                                attribution,
                                active,
                                category
                                )
						  values (:name, 
                                  :quantity, 
                                  :value,
                                  :price,
                                  :attribution,
                                  :active,
                                  :category)";

	$products = $PDO->prepare($sql);

	$products->bindParam(':name', $name);
	$products->bindParam(':quantity', $quantity);
    $products->bindParam(':value', $value);
	$products->bindParam(':price', $price);
    $products->bindParam(':attribution', $attribution);
    $products->bindParam(':active', $active);
    $products->bindParam(':category', $category);

	if($products->execute())
	{
		header("Location: ../cadProducts.php");
	}
	else
	{
		header('Location: erro/erroCad.php');
	}

?>