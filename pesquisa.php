<?php
    include 'includes/conexao.php';
    include 'includes/head.php';
    include 'includes/navbar.php';

    $get = $_GET["q"];
?>

    <main role="main">
      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <div class="container text-center">
          <h1 class="display-3">Busca: <?php echo $get ?></h1>
          <p>Exibindo resultados da busca para o termo digitado</p>
        </div>
      </div>

      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-3">
            <h2>Filtros</h2>
            <b>Cidades</b>
            <?php
            $pesquisa2 = $mysqli->query("SELECT DISTINCT CIDADE FROM pessoa_juridica");
              while ($row = $pesquisa2->fetch_array(MYSQLI_ASSOC)){
                $cidade_nome = $row["CIDADE"];
                echo "<li>".$cidade_nome."</li>";
              }
            ?>

            <hr />

            <b>Especialidades</b>
            <?php
            $pesquisa2 = $mysqli->query("SELECT DISTINCT NOME FROM especialidade");
              while ($row = $pesquisa2->fetch_array(MYSQLI_ASSOC)){
                $especialidade_nome = $row["NOME"];
                echo "<li>".$especialidade_nome."</li>";
              }
            ?> 

            <hr />

            <b>Avaliações</b>
            	<div class="star-ratings-sprite"><span style="width:100%" class="star-ratings-sprite-rating"></span></div>
            	<div class="star-ratings-sprite"><span style="width:80%" class="star-ratings-sprite-rating"></span></div>
            	<div class="star-ratings-sprite"><span style="width:60%" class="star-ratings-sprite-rating"></span></div>
            	<div class="star-ratings-sprite"><span style="width:40%" class="star-ratings-sprite-rating"></span></div>
            	<div class="star-ratings-sprite"><span style="width:20%" class="star-ratings-sprite-rating"></span></div>
          </div>

          <div class="col-md-9">

            <?php
              $pesquisa = $mysqli->query("SELECT ID, NOME_FANTASIA, CIDADE FROM pessoa_juridica WHERE NOME_FANTASIA LIKE '%$get%' LIMIT 10");
              while ($row = $pesquisa->fetch_array(MYSQLI_ASSOC)){
                $oficina_id = $row["ID"];
                $oficina_nome = $row["NOME_FANTASIA"];
                $oficina_cidade = $row["CIDADE"];
                echo "<a href='oficina.php?id=".$oficina_id."'><h2 class='display-2'>".$oficina_nome."</h2></a>";
                echo "<div class='review-block-name'>Localizada em ".$oficina_cidade." | Especialidades: ......... | Média de avaliações:</div><hr />";
              }                          
            ?>                    

            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Última</a></li>
              </ul>
            </nav>
          </div>

        </div>

      </div> <!-- /container -->
    </main>

<?php
    include 'includes/footer.php';
?>
