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
	$oficina = $mysqli->query("SELECT * FROM pessoa_juridica WHERE ID = '$id'");
    while ($row = $oficina->fetch_array(MYSQLI_ASSOC)){
        $oficina_id = $row["ID"];
		$oficina_razao = $row["RAZAO_SOCIAL"];
        $oficina_nome = $row["NOME_FANTASIA"];
		$oficina_proprietario = $row["PROPRIETARIO"];
		$oficina_cnpj = $row["CNPJ"];
		$oficina_telefone = $row["TELEFONE"];
		$oficina_email = $row["EMAIL"];
		$oficina_cep = $row["CEP"];
		$oficina_logradouro = $row["LOGRADOURO"];
		$oficina_numero = $row["NUMERO"];
		$oficina_bairro = $row["BAIRRO"];
		$oficina_cidade = $row["CIDADE"];
		$oficina_uf = $row["UF"];
		$oficina_descricao = $row["DESCRICAO"];
    }

	//jogando os dados do formulário de cadastro em variáveis
    $post_razao = $_POST['f_razao'];
	$post_nome = $_POST['f_nome'];
	$post_proprietario = $_POST['f_proprietario'];  	
    $post_cnpj = $_POST['f_cnpj'];
	$post_telefone = $_POST['f_telefone'];
	$post_email = $_POST['f_email'];
	$post_cep = $_POST['f_cep'];
	$post_logradouro = $_POST['f_logradouro'];
	$post_numero = $_POST['f_numero'];
	$post_bairro = $_POST['f_bairro'];
	$post_cidade = $_POST['f_cidade'];
	$post_uf = $_POST['f_uf'];
	$post_descricao = $_POST['f_descricao'];
    $post_senha = md5($_POST['f_senha']);
    $post_salvar = $_POST['f_submit'];
	$post_salvar_esp = $_POST['f_submit_esp'];

    if(isset($post_salvar)){
        //update no banco de dados
        $update = $mysqli->query("UPDATE pessoa_juridica SET RAZAO_SOCIAL = '$post_razao', NOME_FANTASIA = '$post_nome', PROPRIETARIO = '$post_proprietario', CNPJ = '$post_cnpj', TELEFONE = '$post_telefone', EMAIL = '$post_email', CEP = '$post_cep', LOGRADOURO = '$post_logradouro', NUMERO = '$post_numero', BAIRRO = '$post_bairro', CIDADE = '$post_cidade', UF = '$post_uf', DESCRICAO = '$post_descricao', SENHA = '$post_senha' WHERE ID = '$id'");
        if(!$update){
            $msg = '<div class="alert alert-danger" role="alert">Erro ao gravar os dados no banco de dados.</div>';
        }
        $msg = '<div class="alert alert-success" role="alert">Dados alterados com sucesso.</div>';
		
		$_SESSION['nome'] = $post_nome;
	    $_SESSION['sobrenome'] = $post_sobrenome;
	    $_SESSION['telefone'] = $post_telefone;
		
	    echo"<script language='javascript' type='text/javascript'>alert('Dados alterados com sucesso!');window.location.href='../minha-oficina.php';</script>";
	}
	
	if(isset($post_salvar_esp)){
		$esp_jur = $mysqli->query("DELETE FROM especialidade_juridica WHERE ID_JURIDICA='$id'");
		foreach ($_POST['f_especialidade'] as $value){
			$sql = "INSERT INTO especialidade_juridica (ID_ESPECIALIDADE, ID_JURIDICA) VALUES ('$value', '$id')";
			if($mysqli->query($sql)){echo"<script language='javascript' type='text/javascript'>alert('Dados alterados com sucesso!');window.location.href='../minha-oficina.php';</script>";}
			else{echo"<script language='javascript' type='text/javascript'>alert('Erro: ".$mysqli->error."');window.location.href='../minha-oficina.php';</script>";}
		}
    }
?>

	<div class="container" style="margin-top: 50px">

		<?php echo $msg ?>

		<?php

		$contadores = $mysqli->query("SELECT COUNT(DESCRICAO) AS ORCAMENTO, COUNT(PERGUNTA) AS FORUM FROM orcamento O, forum F WHERE O.ID_JURIDICA='$oficina_id' AND F.ID_JURIDICA='$oficina_id' AND RETORNO IS NULL AND RESPOSTA IS NULL");
	    while ($row = $contadores->fetch_array(MYSQLI_ASSOC)){
	        $cont_orcamento = $row["ORCAMENTO"];
	        $cont_forum = $row["FORUM"];
	    }		

		?>
		
		<div class="col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1primary" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> Dados gerais</a></li>
						<li><a href="#tab2primary" data-toggle="tab"><span class="glyphicon glyphicon-tasks"></span> Especialidades</a></li>
						<li><a href="#tab3primary" data-toggle="tab"><span class="glyphicon glyphicon-usd"></span> Orçamentos (<?php echo $cont_orcamento ?>)</a></li>
						<li><a href="#tab4primary" data-toggle="tab"><span class="glyphicon glyphicon-question-sign"></span> Perguntas (<?php echo $cont_forum ?>)</a></li>
						<li class="pull-right"><a href="oficina.php?id=<?php echo $oficina_id ?>">Página da oficina <span class="glyphicon glyphicon-wrench"></span></a></li>
					</ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
							<form action="minha-oficina.php" method="POST" class="form-login">		  	
							<div class="form-group col-md-6" style="padding:0 5px 0 0;"><b>Razão Social:</b><input type="text" id="razao" name="f_razao" class="form-control" placeholder="Razão Social" value="<?php echo $oficina_razao ?>" required autofocus="" /></div>
							<div class="form-group col-md-6" style="padding:0"><b>Nome fantasia:</b><input type="text" id="nome" name="f_nome" class="form-control" placeholder="Nome Fantasia" value="<?php echo $oficina_nome ?>" required /></div>
							<div class="form-group col-md-6" style="padding:0 5px 0 0;"><b>Nome do proprietário:</b><input type="text" id="proprietario" name="f_proprietario" class="form-control" placeholder="Nome do proprietário" value="<?php echo $oficina_proprietario ?>" required /></div>
							<div class="form-group col-md-6" style="padding:0"><b>CNPJ:</b><input type="text" id="cnpj" name="f_cnpj" class="form-control" placeholder="CNPJ" onblur="if(!validarCNPJ(this.value)){alert('CNPJ Informado é inválido'); this.value='';}" value="<?php echo $oficina_cnpj ?>" required /></div>
							<div class="form-group col-md-6" style="padding:0 5px 0 0;"><b>Telefone:</b><input type="text" id="telefone" maxlength="15" name="f_telefone" onkeyup="mascara(this, mtel);" class="form-control" placeholder="Telefone com DDD (somente números)" value="<?php echo $oficina_telefone ?>" required /></div>
							<div class="form-group col-md-6" style="padding:0"><b>E-mail:</b><input type="text" id="email" name="f_email" class="form-control" placeholder="Endereço de e-mail" value="<?php echo $oficina_email ?>" required /></div>
							<div class="form-group col-md-2" style="padding:0 5px 0 0;"><b>CEP:</b><input type="text" id="cep" name="f_cep" size="9" class="form-control" placeholder="CEP (sem hífen)" maxlength="8" onblur="pesquisacep(this.value);" value="<?php echo $oficina_cep ?>" required /></div>
							<div class="form-group col-md-4" style="padding:0 5px 0 0;"><b>Logradouro:</b><input type="text" id="logradouro" name="f_logradouro" class="form-control" placeholder="Logradouro" required readonly="readonly" value="<?php echo $oficina_logradouro ?>" /></div>
							<div class="form-group col-md-1" style="padding:0 5px 0 0;"><b>Núm:</b><input type="number" id="numero" name="f_numero" class="form-control" placeholder="Número" required value="<?php echo $oficina_numero ?>" /></div>
							<div class="form-group col-md-2" style="padding:0 5px 0 0;"><b>Bairro:</b><input type="text" id="bairro" name="f_bairro" class="form-control" placeholder="Bairro" required readonly="readonly" value="<?php echo $oficina_bairro ?>" /></div>
							<div class="form-group col-md-2" style="padding:0 5px 0 0;"><b>Cidade:</b><input type="text" id="cidade" name="f_cidade" class="form-control" placeholder="Cidade" required readonly="readonly" value="<?php echo $oficina_cidade ?>" /></div>
							<div class="form-group col-md-1" style="padding:0;"><b>UF:</b><input type="text" id="uf" name="f_uf" class="form-control" placeholder="UF" required readonly="readonly" value="<?php echo $oficina_uf ?>" /></div>
							<div class="form-group"><b>Senha:</b><input type="password" id="senha" name="f_senha" class="form-control" placeholder="Senha com no mínimo 6 caracteres" minlength="6" required /></div>

							<div class="form-group col-md-12" style="padding:0 5px 0 0;"><b>Descrição da oficina:</b><small class="caracteres"></small><textarea type="text" rows="8" id="descricao" name="f_descricao" class="form-control" minlength="100" maxlength="850" required autofocus=""><?php echo $oficina_descricao ?></textarea></div>

							<input class="btn btn-primary btn-block" style="margin-bottom: 10px;" type="submit" name="f_submit" value="Salvar Alterações" />
							<small>Atenção: Todos os campos são de preenchimento obrigatório.</small>
						  </form>
						</div>
                        <div class="tab-pane fade" id="tab2primary">
							<div class="form-check col-md-12"><p style="font-weight: bold; margin-top:15px; font-size: 14px">Especialidades:</p>
								<form action="minha-oficina.php" method="POST" class="form-login">
								<?php
								$especialidades = $mysqli->query("SELECT DISTINCT E1.ID, E1.NOME, CASE WHEN P.ID='$id' THEN 'checked' ELSE 'N' END AS SELECTED FROM especialidade E1 LEFT JOIN especialidade_juridica E2 ON E1.ID=E2.ID_ESPECIALIDADE AND E2.ID_JURIDICA='$id' LEFT JOIN pessoa_juridica P ON E2.ID_JURIDICA=P.ID ORDER BY E1.NOME");
								while ($row = $especialidades->fetch_array(MYSQLI_ASSOC)){
									$especialidade_id = $row["ID"];
									$especialidade_nome = $row["NOME"];
									$especialidade_checked = $row["SELECTED"];
									echo "<div class='col-sm-3' style='padding:0'><input name='f_especialidade[]' class='single-checkbox' type='checkbox' value='".$especialidade_id."' ".$especialidade_checked."> ".$especialidade_nome."</div>";		
								}
								?>
								<input class="btn btn-primary btn-block" type="submit" name="f_submit_esp" value="Salvar Alterações" />
								</form>
							</div>
						</div>
                        <div class="tab-pane fade" id="tab3primary">
						<?php
						  $orcamentos = $mysqli->query("SELECT O.ID, P.NOME, O.STATUS, O.DESCRICAO, O.RETORNO, O.DATA_ORCAMENTO, V.MARCA_VEICULO, V.MODELO_VEICULO, V.ANO_VEICULO FROM orcamento O, pessoa_fisica P, veiculo_pessoa V WHERE P.ID=O.ID_FISICA AND V.ID=O.ID_VEICULO AND O.ID_JURIDICA='$id'");
						  while ($row = $orcamentos->fetch_array(MYSQLI_ASSOC)){
							$orcamento_id = $row["ID"];
							$orcamento_pessoa = $row["NOME"];
							$orcamento_status = $row["STATUS"];
							$orcamento_descricao = $row["DESCRICAO"];
							$orcamento_retorno = $row["RETORNO"];
							$orcamento_data = $row["DATA_ORCAMENTO"];
							$orcamento_marca = $row["MARCA_VEICULO"];
							$orcamento_modelo = $row["MODELO_VEICULO"];
							$orcamento_ano = $row["ANO_VEICULO"];
							echo "<div class='form-group col-md-2' style='padding:5px 5px 0 0;'><b>Orçamento: </b>".$orcamento_id."</div> <div class='form-group col-md-2' style='padding:5px 5px 0 0;''><b>Solicitado por: </b>".$orcamento_pessoa."</div>";
							if($orcamento_status == 'Aguardando retorno da oficina'){echo "<div class='form-group col-md-4' style='padding:5px 5px 0 0;'><b>Status: </b><span style='color:red'>".$orcamento_status."</span></div>";}elseif($orcamento_status == 'Aprovado'){echo "<div class='form-group col-md-4' style='padding:5px 5px 0 0;'><b>Status: </b><span style='color:green'>".$orcamento_status."</span></div>";}else{echo "<div class='form-group col-md-4' style='padding:5px 5px 0 0;'><b>Status: </b>".$orcamento_status."</div>";}
							if($orcamento_status == 'Aguardando retorno da oficina'){echo "<div class='form-group col-md-2 text-right' style='padding:0;'><a data-fancybox data-src='#enviarretorno".$orcamento_id."' href='javascript:;' class='btn btn-success'>Enviar retorno <span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></div>";}
							if($orcamento_status == 'Aguardando retorno da oficina'){echo "<div class='form-group col-md-2 text-right' style='padding:0;'><a data-fancybox data-src='#verorcamento".$orcamento_id."' href='javascript:;' class='btn btn-primary'>Ver orçamento <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></div>";} else {echo "<div class='form-group col-md-4 text-right' style='padding:0;'><a data-fancybox data-src='#verorcamento".$orcamento_id."' href='javascript:;' class='btn btn-primary'>Ver orçamento <span class='glyphicon glyphicon-list-alt' aria-hidden='true'></span></a></div>";}
							echo "<hr style='border: 1px solid #ddd' />";

							echo '<div style="display:none;min-width:70%;max-width:70%" id="verorcamento'.$orcamento_id.'">
									<h2 data-selectable="true" class="text-center">Orçamento '.$orcamento_id.' - '.date('d/m/Y', strtotime($orcamento_data)).'</h2><br>
									<p data-selectable="true"><b>Descrição do usuário: </b>'.$orcamento_descricao.'</p>
									<p data-selectable="true"><b>Veículo: </b>'.$orcamento_marca.' '.$orcamento_modelo.' - '.$orcamento_ano.'</p> <hr>';
									if($orcamento_retorno <> ''){echo'<p data-selectable="true" style="color:green; font-size:16px"><b>Retorno enviado para o cliente: </b>'.$orcamento_retorno.'</p>';}
									echo '<h3 data-selectable="true"><b>Status: </b>'.$orcamento_status.'</h3>
								 </div>';   

							echo '<div style="display:none;min-width:70%;max-width:70%" id="enviarretorno'.$orcamento_id.'">
									<h2 data-selectable="true" class="text-center">Orçamento '.$orcamento_id.' - '.date('d/m/Y', strtotime($orcamento_data)).'</h2><br>
									<p data-selectable="true"><b>Descrição do usuário: </b>'.$orcamento_descricao.'</p>
									<p data-selectable="true"><b>Veículo: </b>'.$orcamento_marca.' '.$orcamento_modelo.' - '.$orcamento_ano.'</p>
									<form action="minha-oficina.php" method="POST" class="form-login">
									<b>Retorno:</b><textarea type="text" rows="8" name="f_retorno" class="form-control" maxlength="850" placeholder="Digite o retorno. O texto deve conter no máximo 850 caracteres" required></textarea>
									<div class="form-group col-xs-6" style="padding:5px 5px 0 0;"><input type="number" name="f_valor" class="form-control" placeholder="Valor do orçamento" required /></div>
									<div class="form-group col-xs-6" style="padding:5px 5px 0 0;"><input class="btn btn-primary btn-block" style="margin-bottom: 10px;" type="submit" name="f_submit_ret'.$orcamento_id.'" value="Enviar retorno" /></div>
									</form>
								 </div>';
								
								$post_retorno = $_POST['f_retorno'];
								$post_valor = $_POST['f_valor'];
								$post_salvar_ret = $_POST['f_submit_ret'.$orcamento_id.''];
								if(isset($post_salvar_ret)){
									$update_orc = $mysqli->query("UPDATE orcamento SET RETORNO='$post_retorno', STATUS='Aguardando aprovacao do usuario', VALOR='$post_valor', DATA_RETORNO=NOW() WHERE ID='$orcamento_id'");
									if($update_orc){
										echo "<script language='javascript' type='text/javascript'>alert('Orçamento retornado com sucesso!');window.location.href='../minha-oficina.php';</script>";
										exit;
									}
									else{
										echo"<script language='javascript' type='text/javascript'>alert('Erro!!!');window.location.href='../minha-oficina.php';</script>";
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

                        <div class="tab-pane fade" id="tab4primary">
							<div class="form-check col-md-12">
								<?php
								$forum = $mysqli->query("SELECT * FROM forum WHERE ID_JURIDICA='$id'");
								while ($row = $forum->fetch_array(MYSQLI_ASSOC)){
									$forum_id = $row["ID"];
									$forum_pergunta = $row["PERGUNTA"];
									$forum_resposta = $row["RESPOSTA"];
									$forum_datapergunta = $row["DATA_PERGUNTA"];
									$forum_destaque = $row["DESTAQUE"];

									echo '<div class="row" style="margin-top: 20px">';
									echo '<div class="col-md-9"><b>Pergunta: </b>'.$forum_pergunta.'<br><b>Resposta:</b> '.$forum_resposta.'</b></div>';
									echo '<div class="col-md-3 pull-right text-right">
											<form action="minha-oficina.php" method="POST">';
											if($forum_destaque <> 'S'){echo '<button name="f_destaque'.$forum_id.'" title="Colocar pergunta em destaque. Ela aparecerá na página da sua oficina" class="btn btn-success"><span class="glyphicon glyphicon-star" style="font-size: 20px;"></span></button> ';}
											else{echo '<button name="f_rdestaque'.$forum_id.'" title="Remover a pergunta do destaque. Ela não aparecerá mais na página da sua oficina" class="btn btn-danger"><span class="glyphicon glyphicon-remove" style="font-size: 20px;"></span></button> ';}	

											$post_destaque = $_POST['f_destaque'.$forum_id.''];
											if(isset($post_destaque)){
												$update_fd1 = $mysqli->query("UPDATE forum SET DESTAQUE='S' WHERE ID='$forum_id'");
												if($update_fd1){
													echo "<script language='javascript' type='text/javascript'>alert('Pergunta adicionada aos destaques com sucesso!');window.location.href='../minha-oficina.php';</script>";
													exit;
												}
												else{
													echo"<script language='javascript' type='text/javascript'>alert('Erro!!!');window.location.href='../minha-oficina.php';</script>";
												}									
											}

											$post_rdestaque = $_POST['f_rdestaque'.$forum_id.''];
											if(isset($post_rdestaque)){
												$update_fd2 = $mysqli->query("UPDATE forum SET DESTAQUE='N' WHERE ID='$forum_id'");
												if($update_fd2){
													echo "<script language='javascript' type='text/javascript'>alert('Pergunta removida dos destaques com sucesso!');window.location.href='../minha-oficina.php';</script>";
													exit;
												}
												else{
													echo"<script language='javascript' type='text/javascript'>alert('Erro!!!');window.location.href='../minha-oficina.php';</script>";
												}									
											}

											if($forum_resposta == NULL){echo '<a data-fancybox="" data-src="#respondepergunta'.$forum_id.'" href="javascript:;" class="btn btn-primary">Responder <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';}
											else{echo '<a data-fancybox=""  data-src="#editaresposta'.$forum_id.'"href="javascript:;" class="btn btn-primary">Editar resposta <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';}
											
											echo '</form>';
									echo '</div>';								
									echo '</div>';
									echo '<hr style="border: 1px solid #ddd">';

									echo '<div style="display:none;min-width:70%;max-width:70%" id="respondepergunta'.$forum_id.'">
										<p data-selectable="true"><b>Pergunta: </b> '.$forum_pergunta.'</p>
										<form action="minha-oficina.php" method="POST" class="form-login">
										<textarea type="text" rows="8" name="f_resposta" class="form-control" maxlength="850" placeholder="Digite a resposta. O texto deve conter no máximo 850 caracteres" required></textarea><br>
										<input class="btn btn-primary btn-block" style="margin-bottom: 10px;" type="submit" name="f_submit_resp'.$forum_id.'" value="Enviar resposta" />
										</form>
								 	</div>';

									$post_resposta = $_POST['f_resposta'];
									$post_enviar_resposta = $_POST['f_submit_resp'.$forum_id.''];
									if(isset($post_enviar_resposta)){
										$update_forum = $mysqli->query("UPDATE forum SET RESPOSTA='$post_resposta', DATA_RESPOSTA=NOW() WHERE ID='$forum_id'");
										if($update_forum){
											echo "<script language='javascript' type='text/javascript'>alert('Pergunta respondida com sucesso!');window.location.href='../minha-oficina.php';</script>";
											exit;
										}
										else{
											echo"<script language='javascript' type='text/javascript'>alert('Erro!!!');window.location.href='../minha-oficina.php';</script>";
										}									
									}

									echo '<div style="display:none;min-width:70%;max-width:70%" id="editaresposta'.$forum_id.'">
										<p data-selectable="true"><b>Pergunta: </b> '.$forum_pergunta.'</p>
										<form action="minha-oficina.php" method="POST" class="form-login">
										<textarea type="text" rows="8" name="f_e_resposta" class="form-control" maxlength="850" placeholder="Digite a resposta. O texto deve conter no máximo 850 caracteres" required>'.$forum_resposta.'</textarea><br>
										<input class="btn btn-primary btn-block" style="margin-bottom: 10px;" type="submit" name="f_e_submit_resp'.$forum_id.'" value="Enviar resposta" />
										</form>
								 	</div>';

									$post_e_resposta = $_POST['f_e_resposta'];
									$post_e_enviar_resposta = $_POST['f_e_submit_resp'.$forum_id.''];
									if(isset($post_e_enviar_resposta)){
										$update_e_forum = $mysqli->query("UPDATE forum SET RESPOSTA='$post_e_resposta', DATA_RESPOSTA=NOW() WHERE ID='$forum_id'");
										if($update_e_forum){
											echo "<script language='javascript' type='text/javascript'>alert('Resposta alterada com sucesso!');window.location.href='../minha-oficina.php';</script>";
											exit;
										}
										else{
											echo"<script language='javascript' type='text/javascript'>alert('Erro!!!');window.location.href='../minha-oficina.php';</script>";
										}									
									}
								}
								?>

								<small>Atenção: Serão exibidas na página da sua oficina apenas 10 perguntas. Escolha as melhores para irem para lá.</small>

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


    </div>

<?php
    include 'includes/footer.php';
?>