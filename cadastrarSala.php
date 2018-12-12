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
        
        if(isset($_SESSION['logado'])&& $_SESSION['logado'] && $_SESSION['admin'] == 1){
            
        ?>
        
        <form action="controller/salvarSala.php?inserir" method="POST">
            <label>Sala:</label>
            <input type="text" name="txtNumero" placeholder="Número"><br><br><br>
            <label>Descrição da sala:</label><br><br>
            <textarea name="taDescricaoSala" placeholder="Descrição da sala"></textarea><br><br>
            <input type="submit" value="Cadastrar">
            
            
        </form>
        
        <?php
        
        } else {
            header("Location: index.php");
        }
        
        ?>
        
    </body>
</html>

