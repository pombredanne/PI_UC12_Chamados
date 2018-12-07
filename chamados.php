<?php
session_start();

error_reporting(0);

if (isset($_SESSION['logado']) && $_SESSION['logado']) {
    include_once 'model/clsChamado.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsConexao.php';
    ?>
    <!DOCTYPE html>


    <html>
        <head>
            <meta charset="UTF-8">
            <title>chamados</title>
        </head>
        <body>

            <?php
            require_once 'menu.php';
            ?>
            <h1 align="center">Chamados</h1>
            <br><br>
            <a href="abrirChamado.php">
                <h1 align="center"><button>Solicitar novo chamado</button></a></h1>
        <br><br>

        <?php
        $lista = ChamadoDAO::getChamados();

        if ($lista->count() == 0) {
            echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
        } else {
            ?> 

            <table border="2">
                <tr>
                    <th>Número</th>
                    <th>Usuário</th>
                    <th>Sala</th>
                    <th>Descrição do problema</th>
                    <th>Status</th>
                    <th>Nível de criticidade</th>
                    <th>Técnico responsável</th>
                    <th>Data e hora de abertura</th>
                    <th>Data e hora de encerramento</th>
                    <th>Solução do problema</th>
                    <th>Tempo utilizado</th>
                    <th>Editar</th>
                </tr>
                <?php
                foreach ($lista as $chamado) {

                    echo '<tr>'
                    . '<td>' . $chamado->getId() . '</td>'
                    . '<td>' . $chamado->getUsuario() . '</td>'
                    . '<td>' . $chamado->getSala() . '</td>'
                    . '<td>' . $chamado->getDescricaoProblema() . '</td>'
                    . '<td>' . $chamado->getStatus() . '</td>'
                    . '<td>' . $chamado->getNivelCriticidade() . '</td>'
                    . '<td>' . $chamado->getTecnicoResponsavel() . '</td>'
                    . '<td>' . $chamado->getDataHora() . '</td>'
                    . '<td></td>'
                    . '<td></td>'
                    . '<td></td>'
                    . '<td>'
                    . '<a href="abrirChamado.php?editar&idChamado=' . $chamado->getId() . '"><button>Editar</button></a>'
                    . '</td>'
                    . '</tr>';
                }
            }
            ?>
        </table>
        <?php
    }
    ?>
</body>
</html>
