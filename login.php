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

    </head>

    <?php
    if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
        ?>

        <body>

            <script type="text/javascript" src="login.js"></script>

            <form action="entrar.php" method="POST">
                <img src="fotos/senac_logo.png">

                <div>
                    <input type="text" id="inputUsuario" name="txtNomeUsuario" required 
                           oninvalid="validacaoUsuario(this);"
                           oninput="this.setCustomValidity('')"><br><br>

                    <label id="labelUsuario">Usuário</label>
                </div>

                <div>
                    <input type="password" id="inputSenha" name="txtSenha" required
                           oninvalid="validacaoSenha(this);" 
                           oninput="this.setCustomValidity('')"><br><br>
                    <label id="labelSenha">Senha</label>
                </div>

                <span id="spanLoginInvalido"></span>

                <input type="submit" value="Entrar" id="btEntrar">
                
                <a id="aEsqueciMinhaSenha" href="recuperarLogin.php">Esqueci minha senha</a>
            </form>
            
            <?php
            if ($_COOKIE['logado'] == 2) {
                ?>

                <script type="text/javascript">
                    loginInvalido();
                </script>

        <?php
    }
} else {

    header("Location: chamados.php");
}
?>

    </body>
</html>
