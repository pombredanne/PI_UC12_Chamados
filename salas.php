<?php
require_once 'menu.php';

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

        <h1 align="center">Salas</h1><br><br>

    </head>
    <body>


        <?php
        $lista = SalaDAO::getSalas();

        echo '<div align="center"><a href="cadastrarSala.php"><button>Cadastrar sala</button></a></div><br><br><br><br>';

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
                . '<a href="controller/salvarSala.php?editar&codigoSala=' . $sala->getCodigo() . '">'
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
