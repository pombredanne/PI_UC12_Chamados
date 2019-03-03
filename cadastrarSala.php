<?php
error_reporting(0);

//if (!isset($_COOKIE['redirect'])) {
//    
//    setcookie('redirect', $_SERVER['REQUEST_URI'], time() + 20);
//
//
?>

<!--<script src="cadastrarSala.js"></script>

<script>

    onload();

</script>-->

<?php
//
//} else {
//    setcookie('redirect', '', time() - 3600);
//    unset($_COOKIE['redirect']);
//}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link rel="stylesheet" type="text/css" href="cadastrarSala.css">

        <script src="jquery.js"></script>
        <script src="cadastrarSala.js"></script>

    </head>
    <body>

        <?php
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

            <div id="divForm">

                <form action="controller/salvarSala.php?<?php echo $action; ?>" method="POST">

                    <div>
                        <label id="labelSala">Sala</label>
                        <input type="text" name="txtNumero" value="<?php echo $numero; ?>" required>
                    </div><br><br>

                    <div>
                        <label id="labelDescricao">Descrição da sala</label>
                        <textarea name="taDescricaoSala"><?php echo $descricao; ?></textarea>
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

