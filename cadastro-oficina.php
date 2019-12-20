<?php

	//verificando se está logado
	session_start();
    if(isset($_SESSION["email"])){
        echo "<script language='javascript' type='text/javascript'>alert('Para acessar o cadastro de oficinas você precisa fazer logoff.');window.location.href='../';</script>";
        exit;        
    }

	include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';
	
	//TRATAMENTO CADASTRO
    //jogando os dados do formulário de cadastro em variáveis
    $razao = $_POST['f_razao'];
	$nome = $_POST['f_nome'];
	$proprietario = $_POST['f_proprietario'];  	
    $cnpj = $_POST['f_cnpj'];
	$telefone = $_POST['f_telefone'];
	$email = $_POST['f_email'];
	$cep = $_POST['f_cep'];
	$logradouro = $_POST['f_logradouro'];
	$numero = $_POST['f_numero'];
	$bairro = $_POST['f_bairro'];
	$cidade = $_POST['f_cidade'];
	$uf = $_POST['f_uf'];
	$descricao = $_POST['f_descricao'];
    $senha = md5($_POST['f_senha']);
    $entrar = $_POST['f_submit'];

    $msg = '';
	
	if (isset($entrar)) {        
	//verificando se já existe o e-mail ou o CNPJ cadastrado no banco
	$verifica = $mysqli->query("SELECT * FROM pessoa_juridica WHERE CNPJ = '$cnpj'");
	$verifica2 = $mysqli->query("SELECT * FROM pessoa_fisica WHERE EMAIL = '$email'");
	$verifica3 = $mysqli->query("SELECT * FROM pessoa_juridica WHERE EMAIL = '$email'");
	if (mysqli_num_rows($verifica2)>0){
		$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro: Este e-mail já está cadastrado em nossa base de dados.</div>';
	}        
	elseif (mysqli_num_rows($verifica)>0){
		$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro: Este CNPJ já está cadastrado em nossa base de dados.</div>';
	}
	elseif (mysqli_num_rows($verifica3)>0){
		$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro: Este e-mail já está cadastrado em nossa base de dados.</div>';
	}

	//validando o checkbox
	/*elseif(){
		$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Por favor, selecione no mínimo 1 e no máximo 5 especialidades.</div>';
	}*/
	
	//caso esteja tudo ok, insere os dados no banco
	else{
		$sql = "INSERT INTO pessoa_juridica (RAZAO_SOCIAL, NOME_FANTASIA, PROPRIETARIO, CNPJ, TELEFONE, EMAIL, CEP, LOGRADOURO, NUMERO, BAIRRO, CIDADE, UF, DESCRICAO, SENHA, DATA_CADASTRO) VALUES ('$razao', '$nome', '$proprietario', '$cnpj', '$telefone', '$email', '$cep', '$logradouro', '$numero', '$bairro', '$cidade', '$uf', '$descricao', '$senha', NOW())";
		if($mysqli->query($sql)){
			$msg = '<div class="alert alert-success" style="margin-top: 50px" role="alert">Usuário cadastrado com sucesso! Por favor, <a href="login.php">efetue login</a>.</div>';
		}
		else{
			$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro ao cadastrar o usuário: '.$mysqli->error.'</div>';
		}

	    $verificaid = $mysqli->query("SELECT ID FROM pessoa_juridica WHERE CNPJ = '$cnpj'");
	    while ($row = $verificaid->fetch_array(MYSQLI_ASSOC)){
	        $idcadastrado = $row["ID"];
	    }

		foreach ($_POST['f_especialidade'] as $value) {
			$sql2 = "INSERT INTO especialidade_juridica (ID_ESPECIALIDADE, ID_JURIDICA) VALUES ('$value', '$idcadastrado')";
			if($mysqli->query($sql2)){$msg = '<div class="alert alert-success" style="margin-top: 50px" role="alert">Usuário cadastrado com sucesso! Por favor, <a href="login.php">efetue login</a>.</div>';}
			else{$msg = '<div class="alert alert-danger" style="margin-top: 50px" role="alert">Erro ao cadastrar o usuário: '.$mysqli->error.'</div>';}
		}
	}

	}
?>

<div class="container">
  <div class="row">
  
	<?php echo $msg ?>
	
    <div class="col-sm-12">
      <center>
      <div class="form-box">
        <div class="form-top">
          <div class="form-top-left">
            <h3>Cadastre seu estabelecimento</h3>
              <p>Preencha os campos para ter acesso ao CarIn:</p>
          </div>
          <div class="form-top-right">
            <i class="fa fa-pencil"></i>
          </div>
		</div>
          <div class="form-bottom">
          <form action="cadastro-oficina.php" method="POST" class="form-login">		  	
			<div class="form-group col-md-6" style="padding:0 5px 0 0;"><input type="text" id="razao" name="f_razao" class="form-control" placeholder="Razão Social" required autofocus="" /></div>
			<div class="form-group col-md-6" style="padding:0"><input type="text" id="nome" name="f_nome" class="form-control" placeholder="Nome Fantasia" required autofocus="" /></div>
			<div class="form-group col-md-6" style="padding:0 5px 0 0;"><input type="text" id="proprietario" name="f_proprietario" class="form-control" placeholder="Nome do proprietário" required autofocus="" /></div>
			<div class="form-group col-md-6" style="padding:0"><input type="text" id="cnpj" name="f_cnpj" class="form-control" placeholder="CNPJ" onblur="if(!validarCNPJ(this.value)){alert('CNPJ Informado é inválido'); this.value='';}" required autofocus="" /></div>
			<div class="form-group col-md-6" style="padding:0 5px 0 0;"><input type="text" id="telefone" maxlength="15" name="f_telefone" onkeyup="mascara(this, mtel);" class="form-control" placeholder="Telefone com DDD (somente números)" required autofocus="" /></div>
			<div class="form-group col-md-6" style="padding:0"><input type="text" id="email" name="f_email" class="form-control" placeholder="Endereço de e-mail" required autofocus="" /></div>
			<div class="form-group col-md-2" style="padding:0 5px 0 0;"><input type="text" id="cep" name="f_cep" size="9" class="form-control" placeholder="CEP (sem hífen)" maxlength="8" onblur="pesquisacep(this.value);" required autofocus="" /></div>
			<div class="form-group col-md-4" style="padding:0 5px 0 0;"><input type="text" id="logradouro" name="f_logradouro" class="form-control" placeholder="Logradouro" required autofocus="" readonly="readonly" /></div>
			<div class="form-group col-md-1" style="padding:0 5px 0 0;"><input type="number" id="numero" name="f_numero" class="form-control" placeholder="Número" required autofocus="" /></div>
			<div class="form-group col-md-2" style="padding:0 5px 0 0;"><input type="text" id="bairro" name="f_bairro" class="form-control" placeholder="Bairro" required autofocus="" readonly="readonly" /></div>
			<div class="form-group col-md-2" style="padding:0 5px 0 0;"><input type="text" id="cidade" name="f_cidade" class="form-control" placeholder="Cidade" required autofocus="" readonly="readonly" /></div>
			<div class="form-group col-md-1" style="padding:0;"><input type="text" id="uf" name="f_uf" class="form-control" placeholder="UF" required autofocus="" readonly="readonly" /></div>
			<div class="form-group"><input type="password" id="senha" name="f_senha" class="form-control" placeholder="Senha com no mínimo 6 caracteres" minlength="6" required autofocus="" /></div>			
			<div class="form-group col-md-8" style="padding:0 5px 0 0;"><small class="caracteres"></small><textarea type="text" rows="12" id="descricao" name="f_descricao" class="form-control" placeholder="Descrição da oficina. Digite um texto de apresentação entre 100 e 850 caracteres" minlength="100" maxlength="850" required autofocus=""></textarea></div>
			<div class="form-check col-md-4"><p style="font-weight: bold; margin-top:15px;">Escolha 5 melhores especialidades:</p>				
		        <?php
		  		$especialidades = $mysqli->query("SELECT * FROM especialidade ORDER BY NOME LIMIT 20");
				while ($row = $especialidades->fetch_array(MYSQLI_ASSOC)){
					$especialidade_id = $row["ID"];
					$especialidade_nome = $row["NOME"];
					echo '<div class="col-sm-6" style="padding:0"><input class="single-checkbox" type="checkbox" name="f_especialidade[]" value="'.$especialidade_id.'"> '.$especialidade_nome.'</div>';
				}
		  		?>		  		
		  	</div>
			<input class="btn btn-primary btn-block" style="margin-bottom: 10px;" type="submit" name="f_submit" value="Cadastrar" />
			<small>Atenção: Todos os campos são de preenchimento obrigatório.</small>
		  </form>
          </div>		
      </div>
      </center>
    </div>	
  </div>
 </div>

<?php
    include 'includes/footer.php';
?>