

  
<?php

 try {
 session_start();
 include'../conexão.php';

 if (!isset($_SESSION['email'])) {
   header("location: ..");
 }
 
  if (isset($_GET['exclui-comta'])) {
  $consulta=$conexao->prepare("DELETE FROM pessoa WHERE codigo=:codigo");
  $consulta->bindParam(':codigo',$_SESSION['codigo']);
  $consulta->execute();
  session_destroy();
  echo"<script>alert('Conta excluida com sucesso')</script>";
  echo"<script>window.location.href='..'</script>";
  }

 if (isset($_GET['sair-da-comta'])) {
  session_destroy();
  header("location:..");
 }

 if (isset($_POST['texto'])) {
  $consulta=$conexao->prepare("INSERT INTO postagem(texto,codigo_pessoa) VALUES(:texto,:codigo)");
  $consulta->bindParam(':texto',$_POST['texto']);
  $consulta->bindParam(':codigo',$_SESSION['codigo']);
  $consulta->execute();

 }

 if (isset($_GET['excluir'])) {
   $consulta=$conexao->prepare("DELETE FROM postagem WHERE codigo=:codigo_postagem AND codigo_pessoa=:codigo_pessoa");
   $consulta->bindParam(':codigo_postagem',$_GET['excluir']);
   $consulta->bindParam(':codigo_pessoa',$_SESSION['codigo']);
   $consulta->execute();
 }

 $consulta=$conexao->query("SELECT*FROM pessoa,postagem WHERE pessoa.codigo=postagem.codigo_pessoa ORDER BY postagem.codigo DESC");
 
 } catch (\Throwable $th) {
   echo'<script>alert("Erro:'.$th->getMessage().'")</script>';
 }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="../Imagem/brain.jpg">
	<link rel="stylesheet" type="text/css" href="../Imagem/img.css">
  <link rel="stylesheet" type="text/css" href="link.css">
	<title>Pensamentos</title>
</head>
<body>
  <header>
   <?php echo'<img id="imgp" src="data:image/*;base64,'.base64_encode($_SESSION['foto']).' "alt="foto de usuario">'?>
   <?php echo"<h4>$_SESSION[nome] - $_SESSION[email]</h4>"?>
   
   <div id="links-comta">
   <a class="Link"id="linksair" href="lista.php?sair-da-comta=true">Sair Da Conta</a>
   <a class="Link"id="linkescluir" href="lista.php?exclui-comta=true">Exclui Conta</a>
   </div>

   <form action="lista.php"method="POST">
     <input id="texto" type="text" name="texto"placeholder="O que Você Esta Pensando">
     <input type="submit" id="postar"value="Postar">
   </form>
  </header>

  <main>

    <?php while ($linha=$consulta->fetch()):?>
    <article>
     <?php 
     if ($_SESSION['codigo']==$linha['codigo_pessoa']) {
       
     echo"<a href='lista.php?excluir=$linha[codigo]'><img src='../Imagem/esclui.png'alt='exclui postagem'></a>";
     }
     echo'<img id="usuario" src="data:image/*;base64,'.base64_encode($linha['foto']).' "alt="foto do usuario da postagem">';
     ?>
     <div>
       <h4><?php echo $linha['nome']?></h4>
       <p><?php echo $linha['texto']?></p>
     </div> 
    </article>
    <?php endwhile?>
  </main>
  <script>
    var entrada=document.getElementById('texto');
    entrada.focus();
  </script>
</body>
</html>