<?php
    //verificando se está logado
	session_start();
    if(!isset($_SESSION["email"])){
        header("Location: ../login.php");
        exit;        
    }

    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';

    $id = $_SESSION['id'];
    $nome = $_SESSION['nome'];
    $sobrenome = $_SESSION['sobrenome'];
    $email = $_SESSION['email'];
    $telefone = $_SESSION['telefone'];
    $sexo = $_SESSION['sexo'];

    $post_nome = $_POST['f_nome'];
	$post_sobrenome = $_POST['f_sobrenome'];  	
	$post_telefone = $_POST['f_telefone'];
    $post_senha = md5($_POST['f_senha']);
	$post_sexo = $_POST['f_sexo'];
    $post_salvar = $_POST['f_submit'];

    $post_marca = $_POST['f_marca'];
    $post_modelo = $_POST['f_modelo'];
    $post_ano = $_POST['f_ano'];
    $post_incluir = $_POST['f_incluir'];
    

    if(isset($post_salvar)){
        //update no banco de dados
        $update = $mysqli->query("UPDATE pessoa_fisica SET NOME = '$post_nome', SOBRENOME = '$post_sobrenome', TELEFONE = '$post_telefone', SENHA = '$post_senha', SEXO = '$post_sexo' WHERE ID = '$id'");            
        if(!$update){
            $msg = '<div class="alert alert-danger" role="alert">Erro ao gravar os dados no banco de dados.</div>';
        }
        $msg = '<div class="alert alert-success" role="alert">Dados alterados com sucesso.</div>';

        $_SESSION['nome'] = $post_nome;
	    $_SESSION['sobrenome'] = $post_sobrenome;
	    $_SESSION['telefone'] = $post_telefone;
	    $_SESSION['sexo'] = $post_sexo;
	    echo"<script language='javascript' type='text/javascript'>alert('Dados alterados com sucesso!');window.location.href='../minha-conta.php';</script>";
    }

    if(isset($post_incluir)){
        //insert no banco de dados
        $insert = $mysqli->query("INSERT INTO veiculo_pessoa(ID_PESSOA, MODELO_VEICULO, MARCA_VEICULO, ANO_VEICULO, DATA_CADASTRO) VALUES ('$id', '$post_modelo', '$post_marca', '$post_ano', NOW())");            
        if(!$insert){
            $msg = '<div class="alert alert-danger" role="alert">Erro ao gravar os dados no banco de dados.</div>';
        }
        $msg = '<div class="alert alert-success" role="alert">Veículo incluído com sucesso!</div>';
    }
?>

	<div class="container" style="margin-top: 50px">

		<?php echo $msg ?>
		
		<div class="col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1primary" data-toggle="tab">Meus dados</a></li>
						<li><a href="#tab2primary" data-toggle="tab">Meus veículos</a></li>
						<li><a href="#tab3primary" data-toggle="tab">Meus orçamentos</a></li>
					</ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
							<form action="minha-conta.php" method="POST" class="form-login">	  	
								<div class="form-group col-md-6" style="padding:0 5px 0 0;"><b>Nome:</b><input type="text" id="nome" name="f_nome" class="form-control" placeholder="Nome" required autofocus="" value="<?php echo $nome ?>" /></div>
								<div class="form-group col-md-6" style="padding:0"><b>Sobrenome:</b><input type="text" id="sobrenome" name="f_sobrenome" class="form-control" placeholder="Sobrenome" required autofocus="" value="<?php echo $sobrenome ?>" /></div>
								<div class="form-group col-md-6" style="padding:0 5px 0 0;"><b>E-mail:</b><input type="email" id="email" name="f_email" class="form-control" placeholder="Endereço de e-mail" required autofocus="" disabled value="<?php echo $email ?>" /></div>
								<div class="form-group col-md-6" style="padding:0"><b>Telefone:</b><input type="text" id="telefone" name="f_telefone" onkeyup="mascara( this, mtel );" class="form-control" placeholder="Telefone com DDD" maxlength="15" required autofocus="" value="<?php echo $telefone ?>" /></div>
								<div class="form-group"><b>Senha:</b><input type="password" id="senha" name="f_senha" class="form-control" placeholder="Senha com no mínimo 6 caracteres" minlength="6" required autofocus="" value="" /></div>
								<div class="form-group"><b>Sexo: </b><input type="radio" name="f_sexo" value="M" required <?php if($sexo=='M'){echo 'checked';} ?>/> Masculino <input type="radio" name="f_sexo" value="F" <?php if($sexo=='F'){echo 'checked';} ?>/> Feminino</div>

								<input class="btn btn-primary btn-block" type="submit" name="f_submit" value="Salvar alterações" />
							</form>
						</div>
                        <div class="tab-pane fade" id="tab2primary">
						  <form action="minha-conta.php" method="POST" class="form-login">
								<?php
								  $veiculos = $mysqli->query("SELECT V.ID, V.MODELO_VEICULO, V.MARCA_VEICULO, V.ANO_VEICULO FROM veiculo_pessoa V, pessoa_fisica P WHERE V.ID_PESSOA=P.ID AND P.ID='$id'");
								  while ($row = $veiculos->fetch_array(MYSQLI_ASSOC)){
									$veiculo_pessoa_id = $row["ID"];
									$veiculo_nome = $row["MODELO_VEICULO"];
									$veiculo_fabricante = $row ["MARCA_VEICULO"];
									$veiculo_ano = $row ["ANO_VEICULO"];
									echo "<div class='form-group col-md-5' style='padding:5px 5px 0 0;''><b>Marca: </b>".$veiculo_fabricante."</div> <div class='form-group col-md-5' style='padding:0 5px 0 0;''><b>Modelo: </b>".$veiculo_nome."</div>";
									echo "<div class='form-group col-md-1' style='padding:5px 5px 0 0;''><b>Ano: </b>".$veiculo_ano."</div>";
									echo "<div class='form-group col-md-1 text-right' style='padding:0'><input class='btn btn-danger btn-sm' type='submit' name='f_apagar' value='Apagar'></div>";
									echo "<hr style='border: 1px solid #ddd' />";
									}

									$post_apagar = $_POST['f_apagar'];

									if(isset($post_apagar)){
										//delete no banco de dados
										$delete = $mysqli->query("DELETE FROM veiculo_pessoa WHERE ID='$veiculo_pessoa_id'");            
										if(!$delete){
											$msg = '<div class="alert alert-danger" role="alert">Erro ao gravar os dados no banco de dados.</div>';
										}
										echo"<script language='javascript' type='text/javascript'>alert('Veículo apagado com sucesso!');window.location.href='../minha-conta.php';</script>";

								  }                          
								?> 

								  <div class="form-group col-md-5" style="padding:0 5px 0 0;"><b>Marca:</b><input type="text" name="f_marca" class="form-control" placeholder="Digite a marca do seu veículo..."></div>
								  <div class="form-group col-md-5" style="padding:0 5px 0 0;"><b>Modelo:</b><input type="text" name="f_modelo" class="form-control" placeholder="Digite o modelo do seu veículo..."></div>
								  <div class="form-group col-md-1" style="padding:0 5px 0 0;"><b>Ano:</b><input type="number" name="f_ano" value="2019" class="form-control" placeholder="Ano"></div>
								  <div class="form-group col-md-1 text-right" style="padding:20px 0 0 0"><button class="btn btn-success" type="submit" name="f_incluir">Incluir <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></div>                      							
						  </form>
						</div>
                        <div class="tab-pane fade" id="tab3primary">
							<?php
							  $orcamentos = $mysqli->query("SELECT O.ID, O.ID_JURIDICA, P.NOME_FANTASIA, O.STATUS, O.DESCRICAO, O.RETORNO, O.DATA_ORCAMENTO, O.DATA_RETORNO, O.VALOR, V.MARCA_VEICULO, V.MODELO_VEICULO, V.ANO_VEICULO FROM orcamento O, pessoa_juridica P, veiculo_pessoa V WHERE P.ID=O.ID_JURIDICA AND V.ID=O.ID_VEICULO AND O.ID_FISICA='$id'");
							  while ($row = $orcamentos->fetch_array(MYSQLI_ASSOC)){
								$orcamento_id = $row["ID"];
								$orcamento_idjuridica = $row["ID_JURIDICA"];
								$orcamento_oficina = $row["NOME_FANTASIA"];
								$orcamento_status = $row["STATUS"];
								$orcamento_descricao = $row["DESCRICAO"];
								$orcamento_retorno = $row["RETORNO"];
								$orcamento_data = $row["DATA_ORCAMENTO"];
								$orcamento_dataretorno = $row["DATA_RETORNO"];
								$orcamento_valor = $row["VALOR"];
								$orcamento_marca = $row["MARCA_VEICULO"];
								$orcamento_modelo = $row["MODELO_VEICULO"];
								$orcamento_ano = $row["ANO_VEICULO"];
								echo "<div class='form-group col-md-2' style='padding:5px 5px 0 0;'><b>Orçamento: </b>".$orcamento_id."</div>";
								echo "<div class='form-group col-md-3' style='padding:5px 5px 0 0;''><b>Oficina: </b>".$orcamento_oficina."</div>";
								echo "<div class='form-group col-md-5' style='padding:5px 5px 0 0;'><b>Status: </b>".$orcamento_status."</div>";
								echo "<div class='form-group col-md-2 text-right' style='padding:0;'>";
										if($orcamento_status == 'Aguardando aprovacao do usuario'){echo"<a data-fancybox data-src='#aprovarorcamento".$orcamento_id."' href='javascript:;' class='btn btn-success'>Aprovar orçamento <span class='glyphicon glyphicon-check' aria-hidden='true'></span></a>";}
										else{echo"<a data-fancybox data-src='#verorcamento".$orcamento_id."' href='javascript:;' class='btn btn-primary'>Ver orçamento <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a>";}
									  echo"</div>";
								echo "<hr style='border: 1px solid #ddd' />";

								echo '<div style="display:none;max-width:70%" id="verorcamento'.$orcamento_id.'">
										<h2 data-selectable="true" class="text-center">Orçamento '.$orcamento_id.' - '.date('d/m/Y', strtotime($orcamento_data)).'</h2><br>
										<p data-selectable="true"><b>Solicitado: </b>'.$orcamento_descricao.'</p>
										<p data-selectable="true"><b>Veículo: </b>'.$orcamento_marca.' '.$orcamento_modelo.' - '.$orcamento_ano.'</p>';
										if($orcamento_status == 'Aprovado' || $orcamento_status == 'Recusado'){echo'<hr>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Retorno da oficina: </b>'.$orcamento_retorno.'</p>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Valor do orçamento: </b>R$ '.$orcamento_valor.'</p>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Retorno enviado em: </b>'.date('d/m/Y', strtotime($orcamento_dataretorno)).'</p>';}
										echo '<h3 data-selectable="true"><b>Status: </b>'.$orcamento_status.'</h3>
										<p class="text-center"><a class="btn btn-primary btn-lg" href="avaliar.php?id='.$orcamento_idjuridica.'">Avaliar oficina <span class="glyphicon glyphicon-star" aria-hidden="true"></a></p>
									 </div>';

								echo '<div style="display:none;max-width:70%" id="aprovarorcamento'.$orcamento_id.'">
										<h2 data-selectable="true" class="text-center">Orçamento '.$orcamento_id.' - '.date('d/m/Y', strtotime($orcamento_data)).'</h2><br>
										<p data-selectable="true"><b>Solicitado: </b>'.$orcamento_descricao.'</p>
										<p data-selectable="true"><b>Veículo: </b>'.$orcamento_marca.' '.$orcamento_modelo.' - '.$orcamento_ano.'</p>
										<hr>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Retorno da oficina: </b>'.$orcamento_retorno.'</p>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Valor do orçamento: </b>R$ '.$orcamento_valor.'</p>
										<p data-selectable="true" style="color: green; font-size: 16px;"><b>Retorno enviado em: </b>'.date('d/m/Y', strtotime($orcamento_dataretorno)).'</p>
										<div class="text-center">
											<form action="minha-conta.php" method="POST">
											<button class="btn btn-success btn-lg" type="submit" name="f_aprovar'.$orcamento_id.'">Aprovar orçamento <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
											<button class="btn btn-danger btn-lg" type="submit" name="f_recusar'.$orcamento_id.'">Recusar orçamento <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
											</form>
										</div>
									 </div>';

								    if(isset($_POST['f_aprovar'.$orcamento_id.''])){
								        //update no banco de dados
							    		$aprovado = 'Aprovado';
								        $update2 = $mysqli->query("UPDATE orcamento SET STATUS = '$aprovado' WHERE ID = '$orcamento_id'");            
								        if($update2){
								            echo"<script language='javascript' type='text/javascript'>alert('Orçamento aprovado com sucesso! Um representante da oficina entrará em contato para combinar os detalhes.');window.location.href='../minha-conta.php';</script>";
								            exit;
								        }
								        else{
								        	echo"<script language='javascript' type='text/javascript'>alert('Erro ao enviar sua solicitação!');window.location.href='../minha-conta.php';</script>";
								        	exit;
								        }
								    }
							    	if(isset($_POST['f_recusar'.$orcamento_id.''])){
								        //update no banco de dados
							    		$recusado = 'Recusado';
								        $update3 = $mysqli->query("UPDATE orcamento SET STATUS = '$recusado' WHERE ID = '$orcamento_id'");            
								        if($update3){
								            echo"<script language='javascript' type='text/javascript'>alert('Orçamento recusado com sucesso!');window.location.href='../minha-conta.php';</script>";
								            exit;
								        }
								        else{
								        	echo"<script language='javascript' type='text/javascript'>alert('Erro ao enviar sua solicitação!');window.location.href='../minha-conta.php';</script>";
								        	exit;
								        }
							    	}
								}                          
							?> 
							
						<nav aria-label="Page navigation example">
						  <ul class="pagination justify-content-center">
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
							  <a class="page-link" href="#">Próxima</a>
							</li>
						  </ul>
						</nav>
						</div>
                    </div>
                </div>
            </div>
        </div>
	</div>

<?php
    include 'includes/footer.php';
?>