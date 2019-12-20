<?php
    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';

    //verificando se está logado
	session_start();

	$id = $_GET["id"];
	$id_fisica = $_SESSION["id"];

	if(!isset($_SESSION["email"])){
        echo "<script language='javascript' type='text/javascript'>alert('Para solicitar um orçamento você precisa estar logado.');window.location.href='../login.php';</script>";
        exit;       
    }
    if($_SESSION["FJ"] == 'J'){
        echo "<script language='javascript' type='text/javascript'>alert('Você não possui permissão para acessar essa página. Somente cadastros de pessoa física podem solicitar orçamentos');window.location.href='../oficina.php?id=".$id."';</script>";
        exit;       
    }

    $oficina = $mysqli->query("SELECT * FROM pessoa_juridica WHERE ID = '$id'");
    while ($row = $oficina->fetch_array(MYSQLI_ASSOC)){
        $oficina_id = $row["ID"];
        $oficina_nome = $row["NOME_FANTASIA"];
        $oficina_cidade = $row["CIDADE"];
        $oficina_telefone = $row["TELEFONE"];
        $oficina_email = $row["EMAIL"];
        $oficina_uf = $row["UF"];
        $oficina_descricao = $row["DESCRICAO"];
    }

	$enviar = $_POST['f_submit'];
	$post_orcamento = $_POST['f_orcamento'];
	$post_veiculo = $_POST['f_veiculo'];
	$status = 'Aguardando retorno da oficina';

	if (isset($enviar)){        
	//verificando se todos os campos estão preenchidos
	if($post_veiculo == 0){
		echo"<script language='javascript' type='text/javascript'>alert('Por favor, preencha todos os campos. Acesse seu perfil para cadastrar veículos');window.location.href='../orcamento.php?id=".$id."';</script>";
	}
	
	//caso esteja tudo ok, insere os dados no banco
	else{
		$sql = "INSERT INTO orcamento (ID_FISICA, ID_JURIDICA, ID_VEICULO, DESCRICAO, STATUS, DATA_ORCAMENTO) VALUES('$id_fisica', '$id', '$post_veiculo', '$post_orcamento', '$status', NOW())";
		if($mysqli->query($sql)){
			$msg = '<div class="alert alert-success" style="margin-top: 50px" role="alert">Orçamento enviado com sucesso!</div>';
		}
		else{
			$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro ao cadastrar o usuário: '.$mysqli->error.'</div>';
		}
	}
	}	

?>

      <div class="jumbotron">
        <div class="container text-center">
          <h2 class="display-3">Solicitar orçamento para <?php echo $oficina_nome ?></h2>

          <?php echo $msg ?>
		  
			<div class="form-bottom">
			  <form action="orcamento.php?id=<?php echo $id ?>" method="POST" class="form-login">		  	
				<select name="f_veiculo" class="form-control" required>
					<option value="0" selected disabled>(Selecione um veículo)</option>
				    <?php
				    $veiculo = $mysqli->query("SELECT * FROM veiculo_pessoa WHERE ID_PESSOA = '$id_fisica'");
				    while ($row = $veiculo->fetch_array(MYSQLI_ASSOC)){
				        $veiculo_id = $row["ID"];
				        $veiculo_modelo = $row["MODELO_VEICULO"];
				        $veiculo_marca = $row["MARCA_VEICULO"];
				        $veiculo_ano = $row["ANO_VEICULO"];
				        echo "<option value='".$veiculo_id."'>".$veiculo_marca." ".$veiculo_modelo." - ".$veiculo_ano."</option>";
				    }
				    ?>
				</select>
				<small class="caracteres"></small>				
				<div class="form-group"><textarea type="text" rows="8" id="orcamento" name="f_orcamento" class="form-control" placeholder="Descreva seu problema para abrir uma solicitação de orçamento. O texto deve ter entre 100 e 850 caracteres" minlength="100" maxlength="850" required autofocus=""></textarea></div>
				
				<input class="btn btn-primary btn-block" type="submit" name="f_submit" value="Enviar" />
			  </form>
			</div>
			
        </div>
      </div>

<?php
    include 'includes/footer.php';
?>
