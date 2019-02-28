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
        
        <script src="jquery.js"></script>

        <?php
        if (!isset($_SESSION['logado']) && !$_SESSION['logado']) {
            ?>

            <form action="entrar.php" method="POST">
                <img src="fotos/senac_logo.png">
                
                <div>
                    <input type="text" id="inputUsuario" name="txtNomeUsuario" required><br><br>
                <label id="labelUsuario">Usuário</label>
                </div>
                
                <div>
                    <input type="password" id="inputSenha" name="txtSenha" required><br><br>
                <label id="labelSenha">Senha</label>
                </div>
                
                <input type="submit" value="Entrar" id="btEntrar">
            </form><br><br><br>

            <?php
        } else {
            
            header("Location: chamados.php");
            
        }

        ?>

    </body>
</html>
