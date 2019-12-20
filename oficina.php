<?php
    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';

    $id = $_GET["id"];

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

    $avaliacao = $mysqli->query("SELECT ROUND(AVG(NOTA),2) AS NOTA FROM avaliacao WHERE ID_JURIDICA= '$id'");
    while ($row = $avaliacao->fetch_array(MYSQLI_ASSOC)){
        $nota_media = $row["NOTA"];
    }

?>

    <main role="main">
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container text-center">
          <h1 class="display-3"><?php echo $oficina_nome ?></h1>
          <p>Localizada em <?php echo $oficina_cidade .", ". $oficina_uf ?></p>
          <p>Telefone: <?php echo $oficina_telefone ." | E-mail: ". $oficina_email ?></p>                    
          <a data-fancybox data-src='#selectableModal' href='javascript:;' class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-map-marker"></span> Ver localização</a>
          <a href="orcamento.php?id=<?php echo $id ?>" class="btn btn-danger btn-lg">Solicitar orçamento <span class="glyphicon glyphicon-list-alt"></span></a>
        </div>
      </div>
	  
	  <div style="display:none;min-width: 70%;max-width:70%" id="selectableModal">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7347110960573!2d-46.41438638496813!3d-24.005143384015174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce1db2e586da8d%3A0x271ae3e10bdc671e!2sFATEC!5e0!3m2!1spt-BR!2sbr!4v1572368683874!5m2!1spt-BR!2sbr" width="100%" height="400px" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
	  </div>
	  
      <div class="container">

        <div class="row">        	
          <div class="col-md-8">
            <h2>Sobre esta oficina</h2>
            <p><?php echo $oficina_descricao ?></p>
          </div>

          <div class="col-md-4">
          	<a class="thumbnail"><img src="https://dummyimage.com/400x250/666/ffffff&text=(Foto+Principal)"></a>
          </div>          
        </div>

        <hr />

        <div class="row">
          <div class="col-md-6">
              <h3>Média de avaliações: <?php echo $nota_media ?> <small>/ 10</small></h3>
              	<div class="star-ratings-sprite"><span style="width:<?php echo $nota_media*10 ?>%" class="star-ratings-sprite-rating"></span></div>
                <div class="text-center" style="margin: 20px;"><a href="avaliar.php?id=<?php echo $id ?>" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-align-left"></span> Conhece esta oficina? Avalie!</a></div>
          </div>

          <div class="col-md-6">			  
              
              	<?php
              		$avaliacao_esp = $mysqli->query("SELECT E1.NOME, ROUND(AVG(NOTA),2) AS NOTA FROM avaliacao_especialidade_juridica A1, especialidade E1 WHERE A1.ID_ESPECIALIDADE=E1.ID AND ID_JURIDICA='$id' GROUP BY E1.NOME ORDER BY AVG(NOTA) DESC");
    				while ($row = $avaliacao_esp->fetch_array(MYSQLI_ASSOC)){
       				$avaliacao_esp_nome = $row["NOME"];
					$avaliacao_esp_nota = $row["NOTA"];
					echo '<div class="col-xs-4" style="padding:0px; text-align: right;">';
						echo '<p class="avaliacoes">'.$avaliacao_esp_nome.'</p>';
					echo '</div>';
					echo '<div class="col-xs-6" style="padding-right:0px">';
						echo '<div class="progress avaliacoes"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: '. 10*$avaliacao_esp_nota.'%"></div></div>';
					echo '</div>';
					echo '<div class="col-xs-2" style="padding: 0px 0px 0px 10px">';
						echo '<div class="avaliacoes">'.$avaliacao_esp_nota.' <span class="glyphicon glyphicon-star"></span></div>';
					echo '</div>';
   					}
              	?>
		  </div>
      	</div> 

      	<hr/>
		
		<div class="row">
      		<div class="col-md-12">

          <h2 style="margin-bottom: 30px;">Perguntas e respostas:</h2>  			           
		              
	        <?php
		  		$forum = $mysqli->query("SELECT F.ID, F.PERGUNTA, F.RESPOSTA, F.DATA_PERGUNTA, F.DATA_RESPOSTA FROM forum F WHERE F.ID_JURIDICA='$id' AND F.RESPOSTA IS NOT NULL AND DESTAQUE='S' ORDER BY DATA_PERGUNTA DESC LIMIT 10");
				  while ($row = $forum->fetch_array(MYSQLI_ASSOC)){
					  $forum_id = $row["ID"];
					  $forum_pergunta = $row["PERGUNTA"];
					  $forum_resposta = $row["RESPOSTA"];
					  $forum_datapergunta = $row["DATA_PERGUNTA"];
					  $forum_dataresposta = $row["DATA_RESPOSTA"];
					  $forum_nomejuridica = $row["NOME_FANTASIA"];
					  
					echo '<div class="row">';
						echo '<div class="col-md-12">';
							echo '<div><b>Pergunta:</b> '.$forum_pergunta.'</div>';
							echo '<div><b>Resposta:</b> '.$forum_resposta.'</div>';
							echo '<div class="review-block-name" style="padding:0">Pergunta enviada em: '.date('d/m/Y', strtotime($forum_datapergunta)).' e respondida em: '.date('d/m/Y', strtotime($forum_dataresposta)).'.</div>';
						echo '</div>';
					echo '</div><hr />';
					
				  }
		  	?>
			
			<div class="text-center" style="margin: 20px;">
				<a data-fancybox data-src='#pergunta<?php echo $id ?>' href='javascript:;' class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-question-sign"></span> Está com dúvidas sobre a oficina? Envie uma pergunta</a>
			</div>

			<div style="display:none;min-width: 70%;max-width:70%" id="pergunta<?php echo $id ?>">
			  <form action="oficina.php?id=<?php echo $id ?>" method="POST" class="form-login">				
				<div class="form-group"><textarea type="text" rows="8" name="f_pergunta" class="form-control" placeholder="Digite sua pergunta sobre a oficina." maxlength="850" required autofocus=""></textarea></div>				
				<input class="btn btn-primary btn-block" type="submit" name="f_submit" value="Enviar" />

				<?php
				$post_pergunta = $_POST['f_pergunta'];
				if (isset($_POST['f_submit'])){   
						$sql = "INSERT INTO forum (ID_JURIDICA, PERGUNTA, DATA_PERGUNTA) VALUES('$id', '$post_pergunta', NOW())";
						if($mysqli->query($sql)){
							echo"<script language='javascript' type='text/javascript'>alert('Pergunta enviada com sucesso! Em breve será respondida.');window.location.href='../oficina.php?id=".$id."';</script>";
						}
						else{
							echo"<script language='javascript' type='text/javascript'>alert('Erro ao enviar pergunta. Tente novamente.');window.location.href='../oficina.php?id=".$id."';</script>";
						}					
				}	
				?>
			  </form>
			</div>

          </div>
        </div>
		
		<hr/>
    
    	<div class="row">
      		<div class="col-md-12">

          <h2>Avaliações desta oficina:</h2>  			           
		              
	        <?php
		  		$avaliacoes = $mysqli->query("SELECT * FROM avaliacao A, pessoa_fisica P WHERE A.ID_FISICA=P.ID AND ID_JURIDICA='$id' ORDER BY DATA_AVALIACAO DESC LIMIT 5");
				  while ($row = $avaliacoes->fetch_array(MYSQLI_ASSOC)){
					$avaliacao_nota = $row["NOTA"];
					$avaliacao_comentario = $row["COMENTARIO"];
					$avaliacao_data = $row["DATA_AVALIACAO"];
					$avaliacao_nome = $row["NOME"];
					echo '<div class="review-block">';
					echo '<div class="row">';
						echo '<div class="col-sm-10">';
						echo '<div class="review-block-rate">';
							echo '<div class="star-ratings-sprite"><span style="width:'. 10*$avaliacao_nota.'%" class="star-ratings-sprite-rating"></span></div>';
							echo '<div class="review-block-description">'.$avaliacao_comentario.'</div>';
							echo '<div class="review-block-name">Avaliação enviada por '.$avaliacao_nome.' em '.date('d/m/Y', strtotime($avaliacao_data)).'.</div>';
						echo '</div>';					
						echo '</div>';
						echo '<div class="col-sm-2 text-center">';
							echo '<img src="http://dummyimage.com/80x80/666/ffffff&text=(Sem+foto)" class="img-rounded">';
						echo '</div>';
					echo '</div>';
					echo '</div><hr />';
					}
		  	?>

          </div>
        </div>
		       
      </div><!-- /container -->
    </main>

<?php
    include 'includes/footer.php';
?>

