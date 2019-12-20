<?php
    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';
?>

    <main role="main">
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container text-center">
          <h1 class="display-3">CarIn: Busca de serviços veiculares</h1>
          <p>Descubra oficinas perto de você</p>
          <p><a class="btn btn-danger btn-lg" href="sobre.php" role="button">Leia Mais »</a></p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2 class="text-center">Melhores avaliadas</h2>
            <p class="text-center">Oficinas com as melhores médias do CarIn:</p>
              <?php
              $oficinas = $mysqli->query("SELECT P.ID, P.NOME_FANTASIA, ROUND(AVG(A.NOTA),2) AS NOTA FROM pessoa_juridica P, avaliacao A WHERE P.ID=A.ID_JURIDICA GROUP BY P.ID, P.NOME_FANTASIA ORDER BY AVG(NOTA) DESC LIMIT 5");
              while ($row = $oficinas->fetch_array(MYSQLI_ASSOC)){
                $oficina_id = $row["ID"];
                $oficina_nome = $row["NOME_FANTASIA"];
                $oficina_nota = $row["NOTA"];
                echo "<a class='btn btn-warning btn-lg btn-block' style='text-align:left' href='oficina.php?id=".$oficina_id."'>".$oficina_nome."<small><span class='glyphicon glyphicon-star pull-right'></span><span class='pull-right'>".$oficina_nota."&nbsp;</span></small></a>";
              }
              ?>
          </div>

          <div class="col-md-4">
            <h2 class="text-center">Mais populares</h2>
            <p class="text-center">Oficinas com mais comentários no CarIn:</p>
              <?php
              $oficinas = $mysqli->query("SELECT P.ID, P.NOME_FANTASIA, COUNT(A.COMENTARIO) AS COMENTARIOS FROM pessoa_juridica P, avaliacao A WHERE P.ID=A.ID_JURIDICA GROUP BY P.ID, P.NOME_FANTASIA ORDER BY COUNT(A.COMENTARIO) DESC LIMIT 5");
              while ($row = $oficinas->fetch_array(MYSQLI_ASSOC)){
                $oficina_id = $row["ID"];
                $oficina_nome = $row["NOME_FANTASIA"];
                $oficina_comentarios = $row["COMENTARIOS"];
                echo "<a class='btn btn-success btn-lg btn-block' style='text-align:left' href='oficina.php?id=".$oficina_id."'>".$oficina_nome."<small><span class='glyphicon glyphicon-comment pull-right'></span><span class='pull-right'>".$oficina_comentarios."&nbsp;</span></small></a>";
              }
              ?>
          </div>

          <div class="col-md-4">
            <h2 class="text-center">Mais recentes</h2>
            <p class="text-center">Últimas oficinas cadastradas no CarIn:</p>
              <?php
              $oficinas = $mysqli->query("SELECT ID, NOME_FANTASIA, DATA_CADASTRO FROM pessoa_juridica ORDER BY DATA_CADASTRO DESC LIMIT 5");
              while ($row = $oficinas->fetch_array(MYSQLI_ASSOC)){
                $oficina_id = $row["ID"];
                $oficina_nome = $row["NOME_FANTASIA"];
                $oficina_cadastro = $row["DATA_CADASTRO"];
                echo "<a class='btn btn-info btn-lg btn-block' style='text-align:left' href='oficina.php?id=".$oficina_id."'>".$oficina_nome."<small><span class='glyphicon glyphicon-calendar pull-right'></span><span class='pull-right'>".date('d/m', strtotime($oficina_cadastro))."&nbsp;</span></small></a>";
              }
              ?>
          </div>

        </div>

        <hr>

		<div class="jumbotron">
		  <h1 class="display-4">Cadastre sua oficina</h1>
		  <p class="lead">Aumente a visibilidade do seu estabelecimento realizando um cadastro conosco, totalmente gratuito.</p>
		  <hr class="my-4">
		  <p class="lead">
		    <a class="btn btn-danger btn-lg" href="cadastro-oficina.php" role="button">Cadastre-se aqui</a>
		  </p>
		</div>

      </div> <!-- /container -->
    </main>

<?php
    include 'includes/footer.php';
?>
