<?php
	session_start();
	
	$conexao=mysql_connect("localhost", "root", "bcd127");
mysql_select_db("dblivraria");

$modo="";
$titulo="";
$nome="";
$descricao="";
$foto="";
$botao="Enviar";

	if(isset($_POST['btnenviar'])){
		$diretorio="imagens/";
		
		$nome=$_POST["txtnome"];
		$descricao=$_POST["txtdescricao"];
		$operacao=$_POST["btnenviar"];
		
		
		if ($operacao=="Editar" and $_FILES["autor_file"]["name"] == null)
		{
			$file=$_POST["txtfoto"];
			$sql="update tblautor set tituloautor='".$nome."', descricaoautor='".$descricao."', fotoautor='".$file."' where codautor='".$_SESSION["cod"]."'";
			mysql_query($sql);
			header("location:adm_all_autor.php");
		}
		else
		{	
		
		
		
			$nome_arq=basename($_FILES["autor_file"]["name"]);
			
			$file= $diretorio.$nome_arq;
			//echo("teste!!");
			if(strstr($nome_arq, '.jpg') || strstr($nome_arq, '.png')){
			if(move_uploaded_file($_FILES["autor_file"]["tmp_name"],$file)){
				if($operacao=="Enviar"){
				$sql="insert into tblautor(tituloautor, descricaoautor, fotoautor)
				values('".$nome."','".$descricao."','".$file."')";
				}elseif($operacao=="Editar"){
				$sql="update tblautor set tituloautor='".$nome."', descricaoautor='".$descricao."', fotoautor='".$file."' where codautor='".$_SESSION["cod"]."'";
				}
				//echo($sql);
				mysql_query($sql);
				header("location:adm_all_autor.php");
			}
			}else{
						echo'<script> alert ("Extensão Inválida."); </script>';
					}
		}
	}
	if(isset($_GET["modo"])){
		$modo=$_GET["modo"];
	if($modo=="editar"){

			$_SESSION["cod"]=$_GET["codautor"];
			$sql="select * from tblautor where codautor=".$_SESSION["cod"];

			//echo($sql);
			
			$select=mysql_query($sql);
	
			$rsconsulta=mysql_fetch_array($select);
			
			$titulo=$rsconsulta["tituloautor"];
			$descricao=$rsconsulta["descricaoautor"];
			$foto=$rsconsulta["fotoautor"];
			$botao="Editar";
		}
	} 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Livraria Woody Woodpecker SA</title>
<link rel="icon" type="image/jpg" href="imagens/s.png" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<script src="js/jquery11.js"></script>
</head>
<body>
	<header>
		<div>
			<img src="imagens/construcao.png" class="slide1"/>
        </div>
	</header>
    <div class="principal">
    	<div class="cabecalho">
			<div class="adm">
				<a href="adm_conteudo.php"><img src="imagens/320x320xdefault-avatar_0.png,qitok=0jZKd6f2.pagespeed.ic.M1QG-KQ9bS (1).png" class="imgadm"/></a>
					<div class="titulo">
						<a href="adm_conteudo.php">Adm. Conteúdo</a>
					</div>
			</div>
			<div class="adm">
				<a href="adm_faleconosco.php"><img src="imagens/operator_support_girl-128.png" class="imgadm"/></a>
					<div class="titulo">
						<a href="adm_faleconosco.php">Adm. Fale Conosco</a>
					</div>
			</div>
			<div class="adm">
				<a href="adm_produto.php"><img src="imagens/44322.png" class="imgadm"/></a>
					<div class="titulo">
						<a href="adm_produto.php">Adm. Produtos</a>
					</div>
			</div>
			<div class="adm">
				<a href="adm_user.php"><img src="imagens/advisors1.png" class="imgadm"/></a>
				<div class="titulo">
						<a href="adm_user.php">Adm. Usuários</a>
					</div>
			</div>
			<div class="bv">
				Bem vindo, <?php echo $_SESSION['nomeuser']; ?>
			</div>
			<div class="logout">
					<a href="home.php">Logout</a>
			</div>
		</div>
		<div class="fita">
		</div>
		<div class="consulta">
			<div>
				<a href="adm_autor.php"><img src="imagens/a-vector-illustration-of-a-wooden-sign-455498.jpg" class="img_voltar"/></a>
			</div>
			<div class="cad_user">
				<form name="frmautor" method="post" enctype="multipart/form-data" action="adm_cad_autor.php">
					Autor:</br>
					<input type="text" name="txtnome" value="<?php echo($titulo) ?>" size="50" required class="form"></br>
					Descrição:</br>
					<textarea name="txtdescricao" rows="5" cols="48" name="txtinfo" class="form2"><?php echo($descricao) ?> </textarea></br></br>
					<?php 
						if($modo=="editar"){
							?>
							<input type="hidden" name="txtfoto" value="<?php echo($foto) ?>" size="50" class="form"></br>
						<?php } ?>
					Escolha a foto:</br>
					<input type="file" name="autor_file" <?php if($modo=="") echo("required")?>></br></br>
					<input type="submit" name="btnenviar" value="<?php echo($botao) ?>" class="btn">
				</form>
			</div>
		</div>
    </div>
	<footer class="rodape1">
       Desenvolvido por Amanda Rafaela Barreto de Melo
    </footer>
</body>
</html>
