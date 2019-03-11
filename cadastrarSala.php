<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        
        <link rel="stylesheet" type="text/css" href="cadastrarSala.css">

        <script src="jquery.js"></script>
        <script src="cadastrarSala.js"></script>

    </head>
    <body>

        <?php
        
        error_reporting(0);
        
        session_start();

        include_once 'dao/clsConexao.php';
        include_once 'dao/clsSalaDAO.php';
        include_once 'model/clsSala.php';

        require_once 'menu.php';

        if (isset($_SESSION['logado']) && $_SESSION['logado'] && $_SESSION['admin'] == 1) {

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

            <div id="divContainerForm">
                
                <label id="labelCadastroSala">Cadastro de sala</label>

                <form action="controller/salvarSala.php?<?php echo $action; ?>" method="POST">

                    <div>
                        <input type="text" name="txtNumero" value="<?php echo $numero; ?>" required>
                        <label id="labelSala">Sala</label>
                    </div><br><br>

                    <div>
                        <textarea name="taDescricaoSala" required><?php echo $descricao; ?></textarea>
                        <label id="labelDescricao">Descrição da sala</label>
                    </div>

                    <input type="submit" value="Cadastrar">


                </form>

            </div>

    <?php
} else {
    header("Location: index.php");
}
?>

    </body>
</html>

