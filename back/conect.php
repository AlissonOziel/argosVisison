<?php

$servidor =  "localhost";   
$bd       =  "agorsVision";    
$usuario  =  "root";        
$senha    =  "";          

$conexao = mysqli_connect($servidor, $usuario, $senha) or die ("ERRO NA CONEXÃO");

$db= mysqli_select_db($conexao,$bd) or die ("ERRO NA SELEÇÃO DO DATABASE");

?>