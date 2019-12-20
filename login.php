<?php
  include 'includes/conexao.php';
  include 'includes/head.php';
  include 'includes/navbar.php';

	//iniciando a sessão
  session_start();
	
	//TRATAMENTO LOGIN	
	//jogando os dados do formulário de login em variáveis
  $l_email = $_POST['l_email'];
  $l_senha = md5($_POST['l_senha']);
  $l_entrar = $_POST['l_entrar'];
	
	if (isset($l_entrar)) {
    $l_verifica = $mysqli->query("SELECT * FROM pessoa_fisica WHERE EMAIL = '$l_email' AND SENHA = '$l_senha'");      
    $l_verifica2 = $mysqli->query("SELECT * FROM pessoa_juridica WHERE EMAIL = '$l_email' AND SENHA = '$l_senha'");
    //verificando se o resultado da consulta é menor ou igual a 0, ou seja, não encontrou os dados no banco
    if (mysqli_num_rows($l_verifica)<=0 && mysqli_num_rows($l_verifica2)<=0){
      echo"<script language='javascript' type='text/javascript'>alert('Login e/ou Senha incorretos. Tente novamente');window.location.href='../login.php';</script>";
    }
		
		//caso tenha encontrado os dados, prossegue... jogando os dados na sessão
    else{
      $_SESSION['email'] = $l_email;			
      $_SESSION['senha'] = $l_senha;
	
			//pegando os outros dados e jogando na sessão
      if (mysqli_num_rows($l_verifica)>0){
        $result = $mysqli->query("SELECT * FROM pessoa_fisica WHERE EMAIL = '$l_email' AND SENHA = '$l_senha'");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)){
          $sessao_FJ = "F";
          $sessao_id = $row["ID"];
          $sessao_nome = $row["NOME"];
          $sessao_sobrenome = $row["SOBRENOME"];
          $sessao_email = $row["EMAIL"];
          $sessao_telefone = $row["TELEFONE"];
          $sessao_sexo = $row["SEXO"];
          $sessao_data = $row["DATA_CADASTRO"];
        }
      }

      //pegando os outros dados e jogando na sessão
      if (mysqli_num_rows($l_verifica2)>0){
        $result = $mysqli->query("SELECT * FROM pessoa_juridica WHERE EMAIL = '$l_email' AND SENHA = '$l_senha'");
        while ($row = $result->fetch_array(MYSQLI_ASSOC)){
          $sessao_FJ = "J";
          $sessao_id = $row["ID"];
          $sessao_nome = $row["NOME_FANTASIA"];
          $sessao_sobrenome = $row["RAZAO_SOCIAL"];
          $sessao_email = $row["PROPRIETARIO"];
          $sessao_telefone = $row["CNPJ"];
          $sessao_sexo = $row["SEXO"];
          $sessao_data = $row["DATA_CADASTRO"];
        }
      }
			
      $_SESSION['FJ'] = $sessao_FJ;
      $_SESSION['id'] = $sessao_id;
      $_SESSION['nome'] = $sessao_nome;
      $_SESSION['sobrenome'] = $sessao_sobrenome;
      $_SESSION['telefone'] = $sessao_telefone;
      $_SESSION['sexo'] = $sessao_sexo;
      $_SESSION['data_cadastro'] = $sessao_data;            
			
      echo"<script language='javascript' type='text/javascript'>window.location.href='../';</script>";
		}
	}
	
	//TRATAMENTO CADASTRO
  //jogando os dados do formulário de cadastro em variáveis
  $nome = $_POST['f_nome'];
  $sobrenome = $_POST['f_sobrenome'];  	
  $email = $_POST['f_email'];
	$telefone = $_POST['f_telefone'];
  $senha = md5($_POST['f_senha']);
	$sexo = $_POST['f_sexo'];
  $entrar = $_POST['f_submit'];

  $msg = '';

  if (isset($entrar)) {        
      //verificando se já existe o e-mail cadastrado no banco
      $verifica = $mysqli->query("SELECT * FROM pessoa_fisica WHERE EMAIL = '$email'");
      if (mysqli_num_rows($verifica)>0){
          $msg = '<div class="alert alert-danger" role="alert">Erro: Este e-mail já está cadastrado em nossa base de dados.</div>';
      }

      //verificando se todos os campos estão preenchidos
      elseif($nome == '' || $sobrenome == '' || $email == '' || $telefone == '' || $senha == '' || $sexo == ''){
          $msg = '<div class="alert alert-danger" role="alert">Por favor, preencha todos os campos.</div>';
      }
      
      //caso esteja tudo ok, insere os dados no banco
      else{
          $sql = "INSERT INTO pessoa_fisica (NOME, SOBRENOME, EMAIL, TELEFONE, SENHA, SEXO, DATA_CADASTRO) VALUES ('$nome', '$sobrenome', '$email', '$telefone', '$senha', '$sexo', NOW())";
          if($mysqli->query($sql)){
              $msg = '<div class="alert alert-success" role="alert">Usuário cadastrado com sucesso! Por favor, efetue login.</div>';
          }
          else{
              $msg = '<div class="alert alert-danger" role="alert">Erro ao cadastrar o usuário: '.$mysqli->error.'</div>';
          }
      }
  }

?>

<div class="container">
  <div class="row" style="margin-top:50px">

    <?php echo $msg ?>

    <div class="col-sm-6">
      <center>
      <div class="form-box">
        <div class="form-top">
          <div class="form-top-left">
            <h3>Faça login</h3>
              <p>Digite seu e-mail e senha para entrar:</p>
          </div>
          <div class="form-top-right">
            <i class="fa fa-key"></i>
          </div>
          </div>
          <div class="form-bottom">
          <form action="login.php" method="POST" class="form-login">
            <div class="form-group"><input type="email" name="l_email" placeholder="Digite seu e-mail" class="form-username form-control" id="form-username" autofocus="" /></div>
            <div class="form-group"><input type="password" name="l_senha" placeholder="Digite sua senha" class="form-username form-control" id="form-username" /></div>
            <input class="btn btn-primary btn-block" type="submit" name="l_entrar" value="Login" />
          </form>
        </div>
      </div>

      <div class="social-login">
        <h4 class="text-center">...ou entre com:</h4>
        <div class="social-login-buttons">          
          <a class="btn btn-link-1 btn-link-1-facebook" href="#">
            <i class="fa fa-facebook"></i> Facebook
          </a>
          <a class="btn btn-link-1 btn-link-1-twitter" href="#">
            <i class="fa fa-twitter"></i> Twitter
          </a>
          <a class="btn btn-link-1 btn-link-1-google-plus" href="#">
            <i class="fa fa-google-plus"></i> Google Plus
          </a>        
        </div>
      </div>
      </center>
    </div>

    <div class="col-sm-6">
      <center>
      <div class="form-box">
        <div class="form-top">
          <div class="form-top-left">
            <h3>Cadastre-se agora</h3>
              <p>Preencha os campos para ter acesso ao CarIn:</p>
          </div>
          <div class="form-top-right">
            <i class="fa fa-pencil"></i>
          </div>
		</div>
          <div class="form-bottom">
          <form action="login.php" method="POST" class="form-login">		  	
			<div class="form-group col-md-6" style="padding:0 5px 0 0;"><input type="text" id="nome" name="f_nome" class="form-control" placeholder="Nome" required /></div>
			<div class="form-group col-md-6" style="padding:0"><input type="text" id="sobrenome" name="f_sobrenome" class="form-control" placeholder="Sobrenome" required /></div>
			<div class="form-group"><input type="email" id="email" name="f_email" class="form-control" placeholder="Endereço de e-mail" required /></div>
			<div class="form-group"><input type="text" id="telefone" name="f_telefone" onkeyup="mascara( this, mtel );" class="form-control" placeholder="Telefone com DDD" maxlength="15" required /></div>
			<div class="form-group"><input type="password" id="senha" name="f_senha" class="form-control" placeholder="Senha com no mínimo 6 caracteres" minlength="6" required /></div>
			<div class="form-group"><b>Sexo: </b><input type="radio" name="f_sexo" value="M" required /> Masculino <input type="radio" name="f_sexo" value="F" /> Feminino</div>

			<input class="btn btn-primary btn-block" type="submit" name="f_submit" value="Cadastrar" />
		  </form>
          </div>
		  <p><a href="cadastro-oficina.php">Deseja cadastrar seu estabelecimento? Clique aqui</a></p>			
      </div>
      </center>
    </div>
  </div>
</div>



  <div id="logreg-forms">
             
             
  </div>

<?php
    include 'includes/footer.php';
?>