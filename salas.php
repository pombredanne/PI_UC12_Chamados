<?php
error_reporting(0);

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
                    . '<td id="tdCodigo" class="tdPadding">' . $sala->getCodigo() . '</td>'
                    . '<td id="tdNumero" class="tdPadding">' . $sala->getNumero() . '</td>'
                    . '<td class="tdPadding">' . $sala->getDescricao() . '</td>'
                    . '<td class="tdFakeButton" id="tdEditar">Editar</td>'
                    . '<td class="tdFakeButton" id="tdExcluir">Excluir</td>'
                    . '</tr>';
                }

                echo '</table>';
            }
            ?>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="salas.js"></script>
            
            <div id="divContainerAlert">
                <h1>Excluir a sala <span id="spanAlert"></span>?</h1>
                
                <button id="buttonAlertCancel">
                <i class="fas fa-times"></i>
                <label>Cancelar</label></button>
                
                <button id="buttonAlertDelete">
                <i class="fas fa-check"></i>
                <label>Excluir</label></button>
                
            </div>
            
            <div class="divError">
                <label>A sala <span id="spanError"></span> já pertence a um chamado!</label>
                <i class="fas fa-times"></i>
                <button id="buttonError">Fechar</button>
            </div>

            <?php
        } else {

            header("Location: chamados.php");
        }
        ?>

    </body>
</html>
