<?php

session_start();

error_reporting(0);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chamados Senac</title>
        
        <link rel="stylesheet" type="text/css" href="index.css">
        
    </head>
    <body>

        <?php
        if (!isset($_SESSION['logado']) && !$_SESSION['logado']) {
            ?>

            <form action="entrar.php" method="POST">
                <label>Usuário:</label>
                <input type="text" name="txtNomeUsuario" placeholder="Usuário"><br><br>
                <label>Senha:</label>
                <input type="password" name="txtSenha" placeholder="Senha"><br><br>
                <input type="submit" value="Entrar" id="btEntrar">
            </form><br><br><br>

            <?php
        }

        ?>

    </body>
</html>
