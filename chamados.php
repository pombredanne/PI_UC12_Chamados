<?php
session_start();
if(isset($_SESSION['logado']) && $_SESSION['logado']){
    include_once 'model/clsChamado.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsConexao.php';
    ?>
<!DOCTYPE html>

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>chamados</title>
    </head>
    <body>
        
        <?php
            require_once 'menu.php';
        ?>
        $lista = ChamadoDAO::getChamados();
        if
        
    </body>
</html>
