<?php

session_start();

if (isset($_SESSION['logado']) && $_SESSION['logado']) {
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Usuário</title>
    </head>
    <body>
        
        <img src="fotos/logotipo_senac.jpg">
        
        <form action="controller/salvarChamado.php?inserir" method="POST">
            <label>Sala:</label>
            <select name="selectSala">
                <option>Selecione...</option>
                <option>201</option>
                <option>308</option>
            </select><br><br>
            <label>Descrição do Problema:</label><br><br>
            <textarea name="taDescricaoProblema" placeholder="Descrição do Problema"></textarea><br><br>
            <input type="submit" value="Enviar">
        </form>
        
    </body>
</html>
