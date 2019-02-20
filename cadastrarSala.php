<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link rel="stylesheet" type="text/css" href="cadastrarSala.css">
        
    </head>
    <body>
        
        <?php
        
        session_start();
        
        error_reporting(0);
        
        require_once 'menu.php';
        include_once 'dao/clsConexao.php';
        include_once 'dao/clsSalaDAO.php';
        include_once 'model/clsSala.php';
        
        if(isset($_SESSION['logado'])&& $_SESSION['logado'] && $_SESSION['admin'] == 1){
            
        $numero = "";
        $descricao = "";
        $action = "inserir";
        
        if (isset($_GET['editar'])) {
            
            $codigoSala = $_GET['codigoSala'];
            
            $sala = SalaDAO::getSalaByCodigo($codigoSala);
            
            $numero = $sala->getNumero();
            $descricao = $sala->getDescricao();
            $action = "editar&codigoSala=" . $codigoSala;
        }
            
        ?>
        
        <form action="controller/salvarSala.php?<?php echo $action; ?>" method="POST">
            <label>Sala:</label>
            <input type="text" name="txtNumero" placeholder="Número" value="<?php echo $numero; ?>"><br><br><br>
            <label>Descrição da sala:</label><br><br>
            <textarea name="taDescricaoSala" placeholder="Descrição da sala"><?php echo $descricao; ?></textarea><br><br>
            <input type="submit" value="Cadastrar">
            
            
        </form>
        
        <?php
        
        } else {
            header("Location: index.php");
        }
        
        ?>
        
    </body>
</html>

