<?php

error_reporting(0);

if (!isset($_COOKIE['redirect'])) {
    
    setcookie('redirect', $_SERVER['REQUEST_URI'], time() + 20);

?>

<script src="salas.js"></script>

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

include_once 'dao/clsConexao.php';
include_once 'dao/clsSalaDAO.php';
include_once 'model/clsSala.php';

if (isset($_SESSION['logado']) && $_SESSION['logado'] && $_SESSION['admin'] == 1) {
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Salas</title>
            
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
                  integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            
            <link rel="stylesheet" type="text/css" href="salas.css">

            <script src="jquery.js"></script>
            
    </head>
    <body>
        
        <?php
        
        require_once 'menu.php';
        
        ?>
        
        <button id="btCadastrarSala"><a href="cadastrarSala.php">Cadastrar sala</a></button><br><br><br><br>

        <?php
        $lista = SalaDAO::getSalas();

        if ($lista->count() == 0) {

            echo '<h3>Nenhuma sala cadastrada!</h3><br><br>';
        } else {

            echo '<table border="1">
        <th>Código</th>
        <th>Número</th>
        <th>Descrição</th>
        <th>Editar</th>
        <th>Excluir</th>';

            foreach ($lista as $sala) {

                echo '<tr>'
                . '<td>' . $sala->getCodigo() . '</td>'
                . '<td>' . $sala->getNumero() . '</td>'
                . '<td>' . $sala->getDescricao() . '</td>'
                . '<td>'
                . '<a href="cadastrarSala.php?editar&codigoSala=' . $sala->getCodigo() . '">'
                . '<button>Editar</button></a>'
                . '</td>'
                . '<td>'
                . '<a href="controller/salvarSala.php?excluir&codigoSala=' . $sala->getCodigo() . '">'
                . '<button>Excluir</button></a>'
                . '</td>'
                . '</tr>';
            }

            echo '</table>';
        }
    } else {

        header("Location: index.php");
    }
    ?>

</body>
</html>
