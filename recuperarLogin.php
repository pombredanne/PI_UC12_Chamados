<?php

error_reporting(0);

session_start();
if (!$_SESSION['logado'] && !isset($_SESSION['logado'])) {

    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Recuperar login</title>

            <link rel="stylesheet" type="text/css" href="recuperarLogin.css">

        </head>
        <body>

            <div id="divContainerForm">
                
                <h1>Recuperação de senha</h1>

                <div>
                    <input type="text" id="inputNomeCompleto" required>
                    <label>Nome completo</label>
                </div>

                <div>
                    <input type="text" id="inputNomeUsuario" required>
                    <label>Nome de usuário</label>
                </div>

                <div>
                    <input type="email" id="inputEmail" required>
                    <label id="labelEmail">E-mail</label>
                </div>

                <span>Os dados não conferem!</span>
                
                <button>Verificar usuário</button>

            </div>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="recuperarLogin.js"></script>

        </body>
    </html>

    <?php
} else {
    header("Location: login.php");
}
