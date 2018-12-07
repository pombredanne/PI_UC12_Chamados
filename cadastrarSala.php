<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        
        <?php
        session_start();
        require_once 'menu.php';
        ?>
        
        <?php
        
        if(isset($_SESSION['logado'])&& $_SESSION['logado']){
            
            
        
        
        ?>
        <form action="controller/salvarSala.php?inserir" method="POST">
            <label>Sala:</label>
            <input type="text" name="txtSala">
            <input type="submit" value="Cadastrar">
            
            
        </form>
        <?php
        }
        ?>
    </body>
</html>

