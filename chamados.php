<?php
session_start();

error_reporting(0);

if (isset($_SESSION['logado']) && $_SESSION['logado']) {
    include_once 'model/clsChamado.php';
    include_once 'model/clsUsuario.php';
    include_once 'model/clsSala.php';
    include_once 'model/clsFakeTecnicoResponsavel.php';
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
        $lista = new ArrayObject();

        $disabled = "";

        if ($_SESSION['admin'] == 0) {

            $lista = ChamadoDAO::getChamadosByUsuario($_SESSION['nomeUsuario']);
            
            $disabled = "disabled";
            
        } else {

            $lista = ChamadoDAO::getChamados();

        }

        if ($lista->count() == 0) {
            echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
        } else {
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
                foreach ($lista as $chamado) {

                    echo '<tr>'
                    . '<td>' . $chamado->getCodigo() . '</td>'
                    . '<td>' . $chamado->getUsuario()->getNomeUsuario() . '</td>'
                    . '<td>' . $chamado->getSala()->getNumero() . '</td>'
                    . '<td>' . $chamado->getDescricaoProblema() . '</td>'
                    . '<td>' . $chamado->getStatus() . '</td>'
                    . '<td>' . $chamado->getNivelCriticidade() . '</td>';
                    
                    $nomeCompletoTecnico = $chamado->getTecnicoResponsavel()->getNomeCompleto();
                    
                    if ($nomeCompletoTecnico == 0) {
                        $nomeCompletoTecnico = "";
                    }
                    
                    echo '<td>' . $nomeCompletoTecnico . '</td>'
                    . '<td>' . $chamado->getDataHora() . '</td>'
                    . '<td></td>'
                    . '<td>' . $chamado->getSolucaoProblema() . '</td>'
                    . '<td></td>'
                    . '<td>';

                    echo '<a href="abrirChamado.php?editar&codigoChamado=' . $chamado->getCodigo() . '"><button ' . $disabled . '>Editar</button></a>'
                    . '</td>'
                    . '<td>'
                    . '<a href="abrirChamado.php?excluir&codigoChamado=' . $chamado->getCodigo() . '"><button ' . $disabled . '>Excluir</button></a>'
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
