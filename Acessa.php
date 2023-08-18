<?php
 include'../conexão.php';
 
 try {
  session_start();
 
 if (isset($_SESSION['email'])) {
   header("location: ../Postagem/lista.php");
 }

 if (isset($_POST['email'],$_POST['senha'])) {
 $consulta=$conexao->prepare("SELECT*FROM pessoa WHERE email=:email AND senha=:senha");
 $consulta->bindParam(':email',$_POST['email']);
 $consulta->bindParam(':senha',sha1($_POST['senha']));
 $consulta->execute();

 $resultado=$consulta->fetch();
 if (isset($resultado['email'])) {
   $_SESSION['nome']=$resultado['nome'];
   $_SESSION['email']=$resultado['email'];
   $_SESSION['codigo']=$resultado['codigo'];
   $_SESSION['foto']=$resultado['foto'];

   header("location:../Postagem/lista.php");


 }else{
  throw new Exception('Email ou senha invalidos');
  }
  
 }

 } catch (Throwable $th) {
  echo'<script>alert("erro:'.$th->getMessage().'")</script>';
 }
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet"type="text/css"href="style.css">
	<link rel="shortcut icon" type="image/x-icon" href="../Imagem/brain.jpg">
	<link rel="stylesheet" type="text/css" href="../Imagem/img.css">
	<title></title>
</head>
<body>
   <img src="../Imagem/brain.jpg"alt="pensamentos"/>
   <h2>#Pensamentos</h2>
  <div>
  	 <form action="Acessa.php"method="POST">
      <h4>Acesse Sua Conta</h4>
    
  	 	<input type="email"name="email" placeholder="E-mail"required><br>
  	 	<input type="password"name="senha" placeholder="Senha"required><br>
  	 	<input class="btn"id="acessar" type="submit" value="Acessar Minha Conta">
  	 </form>

  	 <a href="..">Vouta Para o Inicio</a>
  </div>
</body>
</html>