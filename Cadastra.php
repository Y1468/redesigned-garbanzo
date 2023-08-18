
<?php
 include'../conexão.php';

 try{
 session_start();

 if (isset($_SESSION['email'])) {
   header("location: ../Postagem/lista.php");
 }

 if (isset($_POST['nome'],$_POST['email'],$_POST['senha'])) {
   
 if (strlen($_POST['senha'])<6 ) {
   throw new Exception(' Senha muito fraca! Insira uma senha de pelo menos 6 caracteres');
   }
 if (strlen($_POST['nome'])==0) {
   throw new Exception (' O nome não pode ser vazio');  
   }
 if (strlen($_POST['email'])==0) {
   throw new Exception (' O e_mail não pode ser vazio');
 }
 
 
 if (!str_contains($_FILES['foto']['type'],'image')) {
   throw new Exception (' Arquivo invalido! selecione uma imagem');
 }

 if ($_FILES['foto']['size']>(1024*1024*2)) {
   throw new Exception(' Imagem muito grande! Reduza o tamanho da imagem ou escolha outra');
 }
   
 $foto=file_get_contents($_FILES['foto']['tmp_name']);
 
 $consulta=$conexao->prepare("INSERT INTO pessoa(nome,email,senha,foto)VALUES(:nome,:email,:senha,:foto)");  
 $consulta->bindParam(':nome',$_POST['nome']);
 $consulta->bindParam(':email',$_POST['email']);
 $consulta->bindParam(':senha',sha1($_POST['senha']));
 $consulta->bindParam(':foto',$foto);
 $consulta->execute();
 $_SESSION['nome']=$_POST['nome'];
 $_SESSION['email']=$_POST['email'];
 $_SESSION['codigo']=$conexao->lastInsertId();
 $_SESSION['foto']=$foto;
 header("location: ../Postagem/lista.php");
 
  }
  

 }catch(\Throwable $th){
   if ($th->getCode()==23000) {
     echo'<script>alert("Falha ao cadastrar: o e_mail \"' .$_POST['email'].'\" ja esta cadastrado!")</script>';
   }else{
   echo'<script>alert("Erro'.$th->getMessage().' ")</script>';
 }
 
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
  	 <form name="form"action="Cadastra.php"method="POST"enctype="multipart/form-data">
      <h4>Cadastre Sua Conta</h4>
      <input type="text"name="nome" placeholder="Nome"required><br>
  	 	<input type="email"name="email" placeholder="E-mail"required><br>
  	 	<input type="password"name="senha" placeholder="Senha"required><br>
      <input type="file" name="foto"accept="image/*"required><br>
      <input class="btn"id="cadastrar" type="submit" value="Cadastrar Conta">
  	 </form>

  	 <a href="..">Vouta Para o Inicio</a>
  </div>
</body>
</html>