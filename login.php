<?php
session_start();

error_reporting(0);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chamados Senac</title>

        <link rel="stylesheet" type="text/css" href="login.css">

        <script src="login.js"></script>

    </head>

<?php
if (!isset($_SESSION['logado']) && !$_SESSION['logado']) {
    ?>

        <body>

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

    <?php
    
    if ($_COOKIE['login'] == 0) {
        
        echo '<script>'
        . 'loginInvalido();'
        . '</script>';
        
        setcookie('login', null);
    }
    
    ?>

                <span id="spanLoginInvalido"></span>

                <input type="submit" value="Entrar" id="btEntrar">
            </form><br><br><br>

    <?php
} else {

    header("Location: login.php");
}
?>

    </body>
</html>
