<?php

	session_start();

	unset($_SESSION['adm']);

	header("Location: ../login.php");

?>