<?php
 error_reporting(0);
 session_start();
 if (isset($_SESSION['email'])) {
 	header("location:Postagem/lista.php");
 }

 
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="Imagem/brain.jpg">
	<link rel="stylesheet" type="text/css" href="Imagem/img.css">
	<title></title>
</head>
<body>
   <img src="Imagem/brain.jpg"alt="pensamentos"/>
   <h2>#Pensamentos</h2>
   <a class="link"id="link-acessar"href="./Pessoa/Acessa.php">Acessar Minha Conta</a>
   <a class="link"id="link-cadastrar"href="./Pessoa/Cadastra.php">Cadastra Conta</a>
</body>
</html>