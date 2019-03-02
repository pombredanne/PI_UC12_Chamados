<?php

error_reporting(0);

if (!isset($_COOKIE['redirect'])) {
    
    setcookie('redirect', 'cadastrarUsuario.php', time() + 20);

?>

<script src="cadastrarUsuario.js"></script>

<script>

    onload();

</script>

<?php

} else {
    setcookie('redirect', '', time() - 3600);
    unset($_COOKIE['redirect']);
}

?>

<?php
session_start();

if (isset($_SESSION['logado']) && $_SESSION['admin'] == 1) {
    ?>

    <!DOCTYPE html>

    <html>
        <head>
            <meta charset="UTF-8">
            <title>Cadastrar usuario</title>

            <link rel="stylesheet" type="text/css" href="cadastrarUsuario.css">

        </head>

        <?php
        require_once 'menu.php';

        if (strpos('inserir', $_SERVER['HTTP_REFERER'])) {
            ?>

            <body onload="enviarSenha();">

        <?php
    } else {
        ?>

            <body>

                <?php
            }
            ?>

            <div id="wrapper">

                <div class="box">

                    <h2>Cadastro de usuário</h2><br><br>

                    <form action="controller/salvarUsuario.php?inserir" method="POST"
                          enctype="multipart/form-data" id="formCadastrarUsuario">

                        <div>
                            <input type="text" name="txtNome" required>
                            <label>Nome</label><br><br>
                        </div>

                        <div>
                            <input type="text" name="txtNomeUsuario" required>
                            <label>Nome de usuário</label><br><br>
                        </div>

                        <input id="inputCheckbox" type="checkbox" name="cbAdmin">
                        <label for="inputCheckbox" id="labelAdmin">Admin</label><br><br>
                        
                        <div>
                            <input type="email" name="txtEmail" required>
                            <label>E-mail</label><br><br>
                        </div>

                        <label for="inputFile" id="labelFile">Foto</label>
                        
                        <!--<div class="divFile">-->
                        <input type="file" name="txtFoto" id="inputFile">
                        <!--</div>-->

                        <script src="cadastrarUsuario.js"></script>

                        <div id="divSenha">
                            <input type="password" name="txtSenha" id="inputSenha" onkeyup="verificarSenha();" required>
                            <label>Senha</label><br><br>
                        </div>

                        <div>   
                            <input type="password" name="txtConfirmarSenha" id="inputConfirmarSenha" onkeyup="verificarSenha();" required>
                            <label>Confirmar senha</label><br><br>
                        </div>

                        <span id="txtSenhaIncorreta"></span>

                        <input type="submit" value="Cadastrar">
                    </form>

                </div>


    <?php
} else {
    header("Location: index.php");
}
?>

    </body>

</div>

</html>
