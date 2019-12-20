<?php
    session_start();
?>   
    <div id="flipkart-navbar">
        <div class="container">
            <div class="row row1">
                <ul class="largenav pull-right">
                    <li class="upper-links dropdown"><a class="links" href="sobre.php">Sobre o CarIn</a>
                        <ul class="dropdown-menu">
                            <li class="profile-li"><a class="profile-links" href="sobre.php#missao">Missão</a></li>
                            <li class="profile-li"><a class="profile-links" href="sobre.php#visao">Visão</a></li>
                            <li class="profile-li"><a class="profile-links" href="sobre.php#valores">Valores</a></li>
                            <li class="profile-li"><a class="profile-links" href="#">Parceiros</a></li>
                            <li class="profile-li"><a class="profile-links" href="#">Termos de uso</a></li>
                            <li class="profile-li"><a class="profile-links" href="#">Política de privacidade</a></li>
                            <li class="profile-li"><a class="profile-links" href="#">Contato</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="row row2">                
                    <h2 style="margin:0"><span class="smallnav menu" onclick="openNav()">☰</span> <center class="smallnav menu" ><a href="../"><img src="/img/logo-carin.png" width="150px" style="margin-top: -30px"></a></center></h2>
                    <a href="../" class="col-sm-2"><h1 style="margin:0px;"><span class="largenav"><img src="/img/logo-carin.png" width="130" style="margin-top: -20px"></span></h1></a>
                <div class="flipkart-navbar-search smallsearch col-sm-8">
                    <div class="row">
                        <form name="searchform" method="get" action="pesquisa.php">
                            <input style="width: 84%" class="flipkart-navbar-input col-xs-11" name="q" type="text" placeholder="Buscar por oficinas..." required />                                       
                            <span class="input-group-btn"><button type="submit" class="flipkart-navbar-button btn btn-danger" value=""><span class="glyphicon glyphicon-search"></span></button></span>
                        </form>
                    </div>
                </div>
                <div class="cart largenav col-sm-2">
                    <div class="cart-button">
                        <span class="glyphicon glyphicon-user pull-right"></span> <span><?php if(isset($_SESSION['email'])){echo substr($_SESSION['nome'], 0, 16);}else{echo "<a class='botaologin' href='login.php'>Login/Cadastro</a>";}?></span>
                    </div>
					<center><?php if(isset($_SESSION["email"]) && $_SESSION["FJ"] == 'F'){echo "<a class='botaologin' href='minha-conta.php'>Meu Perfil</a> | <a class='botaologin' href='includes/logout.php'>Sair »</a>";}elseif(isset($_SESSION["email"]) && $_SESSION["FJ"] == 'J'){echo "<a class='botaologin' href='minha-oficina.php'>Minha Oficina</a> | <a class='botaologin' href='includes/logout.php'>Sair »</a>";}?></center>
                </div>                    
            </div>				
        </div>
    </div>
    
    <div id="mySidenav" class="sidenav">
        <div class="container" style="background-color: #000; padding: 10px;">
            <a href="../"><span class="sidenav-heading">Início</span></a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        </div>
        <a class="profile-links" href="sobre.php#missao">Missão</a>
        <a class="profile-links" href="sobre.php#visao">Visão</a>
        <a class="profile-links" href="sobre.php#valores">Valores</a>
        <a class="profile-links" href="#">Parceiros</a>
        <a class="profile-links" href="#">Termos de uso</a>
        <a class="profile-links" href="#">Política de privacidade</a>
        <a class="profile-links" href="#">Contato</a>
        <div class="container sidenavlogin">
            <div class="text-center" style="margin-top: 10px;"><span class="sidenav-heading" style="font-size: 14px"><?php if(isset($_SESSION['email'])){echo substr($_SESSION['nome'], 0, 25);}else{echo "<a style='color: #FFF' href='login.php'>Login/Cadastro</a>";}?></span></div>
            <div class="text-center"><?php if(isset($_SESSION['email'])){echo "<a style='font-size: 12px; color: #FFF' href='minha-conta.php'>Meu Perfil</a><a style='margin-top: -10px; font-size: 12px; color: #FFF' href='includes/logout.php'>Sair »</a>";}?></div>
        </div>
    </div>
