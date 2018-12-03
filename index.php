<?php

session_start();

require_once 'menu.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chamados Senac</title>
    </head>
    <body>
        
        <img src="fotos/logotipo_senac.jpg">
        
        <form action="entrar.php" method="POST">
            <label>Usuário:</label>
            <input type="text" name="txtUsuario" placeholder="Usuário"><br><br>
            <label>Senha:</label>
            <input type="password" name="txtSenha" placeholder="Senha">
            <input type="submit" value="Entrar">
        </form><br><br><br>
        
        <a href="cadastrarUsuario.php">Cadastre-se aqui</a>
        
    </body>
</html>
