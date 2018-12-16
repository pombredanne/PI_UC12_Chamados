<?php
session_start();

error_reporting(0);

if (isset($_SESSION['logado']) && $_SESSION['logado']) {
    include_once 'model/clsChamado.php';
    include_once 'model/clsUsuario.php';
    include_once 'model/clsSala.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'dao/clsSalaDAO.php';
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
        date_default_timezone_set('America/Sao_Paulo');
        echo '<h2 align="center">' . date("d/m/Y") . "</h2><br><br>";

        $lista = new ArrayObject();
        $lista3 = new ArrayObject();

        if ($_SESSION['admin'] == 0) {

            $lista = ChamadoDAO::getChamadosByUsuario($_SESSION['nomeUsuario']);

            foreach ($lista as $chamado) {

                $lista3->append($chamado);
            }
        } else {

            $lista = ChamadoDAO::getChamadosComTecnico();
            $lista2 = ChamadoDAO::getChamadosSemTecnico();

            if ($lista != null && $lista2 != null) {

                foreach ($lista as $chamado) {

                    $lista3->append($chamado);
                }

                foreach ($lista2 as $chamado) {

                    $lista3->append($chamado);
                }
            } else if ($lista2 == null) {

                foreach ($lista as $chamado) {

                    $lista3->append($chamado);
                }
            } else if ($lista == null){

                foreach ($lista2 as $chamado) {

                    $lista3->append($chamado);
                }
                
            }
                
        }

        if ($lista3->count() == 0) {
            echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
        } else {

            echo '<h3>Total de chamados: ' . $lista3->count() . '</h3>';

            echo '<label>Status: </label>'
            . '<select id="selectFiltroStatus">'
            . '<option>Selecione...</option>'
            . '<option value="Em aberto">Em aberto</option>'
            . '<option value="Resolvido">Resolvido</option>'
            . '<option value="Cancelado">Cancelado</option>'
            . '</select><br><br>';
            ?> 

            <table border="1">
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
                    <th>Excluir</th>
                </tr>
        <?php
        foreach ($lista3 as $chamado) {

            echo '<tr>'
            . '<td>' . $chamado->getCodigo() . '</td>'
            . '<td>' . $chamado->getUsuario()->getNomeUsuario() . '</td>'
            . '<td>' . $chamado->getSala()->getNumero() . '</td>'
            . '<td>' . $chamado->getDescricaoProblema() . '</td>'
            . '<td>' . $chamado->getStatus() . '</td>'
            . '<td>' . $chamado->getNivelCriticidade() . '</td>';
            
            if ($chamado->getTecnicoResponsavel()->getNomeUsuario() != null) {
                
                echo '<td>' . $chamado->getTecnicoResponsavel()->getNomeUsuario() . '</td>';
                
            } else {
                
                echo '<td></td>';
            }

            echo '<td>' . $chamado->getDataHora() . '</td>'
            . '<td></td>'
            . '<td>' . $chamado->getSolucaoProblema() . '</td>'
            . '<td></td>'
            . '<td>'
            . '<a href="abrirChamado.php?editar&codigoChamado=' . $chamado->getCodigo() . '"><button>Editar</button></a>'
            . '</td>'
            . '<td>'
            . '<a href="controller/salvarChamado.php?excluir&codigoChamado=' . $chamado->getCodigo() . '"><button>Excluir</button></a>'
            . '</td>'
            . '</tr>';
        }
        ?>
            </table>
                <?php
            }
        } else {
            header("Location: index.php");
        }
        ?>
</body>
</html>
