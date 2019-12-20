<?php
    include 'includes/head.php';
    include 'includes/navbar.php';
?>

  <div id="logreg-forms">

          <h1 class="h3 mb-3 font-weight-normal text-center" style="padding-top: 30px">Cadastro de oficinas e profissionais de serviços automotivos</h1>


          
          <form action="/signup/" class="form-signin">

              <input type="text" id="user-name" class="form-control" placeholder="Nome fantasia do estabelecimento" required="" autofocus="">
              <input type="text" id="user-name" class="form-control" placeholder="Razão social do estabelecimento" required="" autofocus="">
              <input type="text" id="user-name" class="form-control" placeholder="Nome do proprietário" required="" autofocus="">
              <input type="text" id="user-name" class="form-control" placeholder="Fundação do estabelecimento" required="" autofocus="">
              <input type="text" id="user-name" class="form-control" placeholder="Nº de funcionários" required="" autofocus="">
              <input type="text" id="user-name" class="form-control" placeholder="Faturamento médio" required="" autofocus="">
              <input type="email" id="user-email" class="form-control" placeholder="Endereço de e-mail" required autofocus="">
              <input type="password" id="user-pass" class="form-control" placeholder="Senha" required autofocus="">
              <input type="password" id="user-repeatpass" class="form-control" placeholder="Repita a senha" required autofocus="">

              <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Cadastrar</button>

          </form>
          <br>
          
  </div>

<?php
    include 'includes/footer.php';
?>