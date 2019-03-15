<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nova senha</title>
        
        <link rel="stylesheet" type="text/css" href="novaSenha.css">
        
    </head>
    <body>
        
        <?php
        
        error_reporting(0);
        
        ?>
        
         <div id="divContainerForm">
             
             <form action="controller/salvarUsuario.php?mudarSenha" method="POST">
                
                <h1>Nova senha</h1>

                <div>
                    <input type="password" name="txtSenha" id="inputSenha" required>
                    <label>Senha</label>
                </div>

                <div>
                    <input type="password" name="txtConfirmarSenha" id="inputConfirmarSenha" required>
                    <label>Confirmar senha</label>
                </div>

                <span></span>
                
                <input type="submit" value="Mudar senha">
                
                </form>

            </div>
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="novaSenha.js"></script>
        <script src="js-cookie/src/js.cookie.js"></script>
        
    </body>
</html>
