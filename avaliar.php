<?php

    //verificando se está logado
	session_start();

	$id = $_GET["id"];
	$id_fisica = $_SESSION["id"];

	if(!isset($_SESSION["email"])){
        echo "<script language='javascript' type='text/javascript'>alert('Para enviar uma avaliação você precisa estar logado.');window.location.href='../login.php';</script>";
        exit;       
    }
    if($_SESSION["FJ"] == 'J'){
        echo "<script language='javascript' type='text/javascript'>alert('Você não possui permissão para acessar essa página. Somente cadastros de pessoa física podem enviar avaliações');window.location.href='../oficina.php?id=".$id."';</script>";
        exit;       
    }
	
    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';

	
	$enviar = $_POST['f_submit'];
	$comentario = $_POST['f_comentario'];
	$nota = $_POST['f_nota'];
	
	$oficina = $mysqli->query("SELECT * FROM pessoa_juridica WHERE ID = '$id'");
    while ($row = $oficina->fetch_array(MYSQLI_ASSOC)){
        $oficina_id = $row["ID"];
        $oficina_nome = $row["NOME_FANTASIA"];
    }

	if (isset($enviar)){        
	//verificando se todos os campos estão preenchidos
	if($comentario == ''){
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos.');window.location.href='../avaliar.php?id=".$oficina_id."';</script>";
	}
	
	//caso esteja tudo ok, insere os dados no banco
	else{
		$sql = "INSERT INTO avaliacao (COMENTARIO, NOTA, ID_FISICA, ID_JURIDICA, DATA_AVALIACAO) VALUES('$comentario', '$nota', '$id_fisica', '$oficina_id', NOW())";
		if($mysqli->query($sql)){
			echo"<script language='javascript' type='text/javascript'>alert('Avaliação enviada com sucesso!');window.location.href='../oficina.php?id=".$oficina_id."';</script>";
		}
		else{
			echo"<script language='javascript' type='text/javascript'>alert('Erro ao enviar avaliação. Tente novamente.');window.location.href='../avaliar.php?id=".$oficina_id."';</script>";
		}
		
		
		$esp_jur1 = $mysqli->query("SELECT E2.ID FROM especialidade_juridica E1, especialidade E2 WHERE E1.ID_ESPECIALIDADE=E2.ID AND ID_JURIDICA = '$id'");
			while ($row = $esp_jur1->fetch_array(MYSQLI_ASSOC)){
				$esp_jur_id1 = $row["ID"];
				$nota_esp = $_POST['f_nota'.$esp_jur_id1.''];
				$sql2 = "INSERT INTO avaliacao_especialidade_juridica (NOTA, ID_ESPECIALIDADE, ID_JURIDICA, ID_FISICA) VALUES('$nota_esp', '$esp_jur_id1', '$id', '$id_fisica')";				
				if($mysqli->query($sql2)){
					echo"<script language='javascript' type='text/javascript'>alert('Avaliação enviada com sucesso!');window.location.href='../oficina.php?id=".$oficina_id."';</script>";
				}
				else{
					echo"<script language='javascript' type='text/javascript'>alert('Erro ao enviar avaliação. Tente novamente.');window.location.href='../avaliar.php?id=".$oficina_id."';</script>";
				}
			}
	}
	}	
?>

    <main role="main">
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container text-center">
          <h2 class="display-3">Avaliar <?php echo $oficina_nome ?></h2>
		  
			<div class="form-bottom">
			<div class="row">
			  <form action="avaliar.php?id=<?php echo $id ?>" method="POST" class="form-login">	
			  <?php
				$esp_jur = $mysqli->query("SELECT E2.ID, E2.NOME FROM especialidade_juridica E1, especialidade E2 WHERE E1.ID_ESPECIALIDADE=E2.ID AND ID_JURIDICA = '$id'");
				while ($row = $esp_jur->fetch_array(MYSQLI_ASSOC)){
					$esp_jur_id = $row["ID"];
					$esp_jur_nome = $row["NOME"];
					echo '<div class="col-sm-2" style="padding: 0 5px 0 0"><b>'.$esp_jur_nome.':</b><input type="number" name="f_nota'.$esp_jur_id.'" class="form-control" placeholder="Nota de 1 a 10" min="1" max="10" required autofocus="" /></div>';
				}
			  ?>
				<div class="col-sm-2" style="padding: 0 5px 0 0"><b>Nota geral:</b><input type="number" id="nota" name="f_nota" class="form-control" placeholder="Nota de 1 a 10" min="1" max="10" required autofocus="" /></div>
				<small class="caracteres"></small>				
				<div class="form-group"><textarea type="text" rows="8" id="comentario" name="f_comentario" class="form-control" placeholder="Deixe seu comentário sobre a oficina. O texto deve ter entre 100 e 850 caracteres" minlength="100" maxlength="850" required autofocus=""></textarea></div>
				
				<input class="btn btn-primary btn-block" type="submit" name="f_submit" value="Enviar" />
			  </form>
			</div>
			</div>
		  </div>
      </div>

<?php
    include 'includes/footer.php';
?>