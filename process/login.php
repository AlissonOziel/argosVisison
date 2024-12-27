<?php

include_once("../back/conect.php");
require_once '../back/inicia.php';

session_start();

$email= addslashes($_POST["email"]);
$password = addslashes($_POST['password']);


if (!empty($email) && !empty($password)):
 
	$PDO = db_connect();

	$password = md5($password);

	$sql = "SELECT id, name, email, password, active, type
				FROM users 
					WHERE email = :email
						AND password = :password";

	$stm = $PDO->prepare($sql);

	$stm->bindValue(':email', $email);
	$stm->bindValue(':password', $password);
	
	$stm->execute();

	$dados = $stm->fetch(PDO::FETCH_OBJ);

	if(!empty($dados)):

		$_SESSION['adm'] = $dados->id;
		$_SESSION['name'] = $dados->name;
    	$_SESSION['email'] = $dados->email;
    	$_SESSION['password'] =  $dados->password;
		$_SESSION['active'] = $dados->active;
        $_SESSION['type'] = $dados->type;

		if($_SESSION['type'] == 1):

 			header('Location: ../index.php');

		else:

			header('Location: ../saller/index.php');

		endif;

		
 			
	else:
 	
 		header('Location: ../login.php');
 
	endif;
 
endif;

?>

