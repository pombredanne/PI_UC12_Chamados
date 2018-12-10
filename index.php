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

        <?php
        if (!isset($_SESSION['logado']) && !$_SESSION['logado']) {
            ?>

            <form action="entrar.php" method="POST">
                <label>Usuário:</label>
                <input type="text" name="txtNomeUsuario" placeholder="Usuário"><br><br>
                <label>Senha:</label>
                <input type="password" name="txtSenha" placeholder="Senha">
                <input type="submit" value="Entrar">
            </form><br><br><br>

            <?php
        }

        echo '<br><br>';

        if (isset($_SESSION['logado']) && $_SESSION['logado'] && $_SESSION['admin'] == 1) {
            
            echo '<a href="cadastrarUsuario.php">Cadastrar usuário</a>';
        }
        ?>

    </body>
</html>
