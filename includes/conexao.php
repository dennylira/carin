<?php
        $mysqli = mysqli_connect("localhost", "admin", "carin2019", "db_carin");
        if (mysqli_connect_errno()) {
            printf("Falha na conexão com o banco de dados: %s\n", mysqli_connect_error());
            exit();
        }	
?>