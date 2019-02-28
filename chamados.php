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

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
                  integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                ?>

                <link rel="stylesheet" type="text/css" href="chamadosAdmin.css">

                <?php
            } else {
                ?>

                <link rel="stylesheet" type="text/css" href="chamadosDocente.css">

                <?php
            }
            ?>

            <script src="chamados.js"></script>

        </head>

        <body onload="selectInvisible();
                selectVisible();
                selectedOptionChamados();
                selectedOptionTecnicos();
                selectedOptionUsuarios();
                selectedOptionStatus();
                
                <?php
                
                if (!isset($_GET['?'])) {
                    
//                    header("Location: chamados.php?codigo=0&status=todos");
                    
                }
                
                ?>
                
//                defaultIndexSelectStatus();

        <?php
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {

            if (isset($_GET['tecnico']) && $_GET['codigo'] != 1 || isset($_GET['usuario']) && $_GET['codigo'] != 2) {

                echo 'removeKeysUrl();">';
            } else {
                ?>

                      ">

                    <?php
                }
            }
            ?>

            <?php
            require_once 'menu.php';

            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                ?>

                <label id="lblFiltroChamados">Filtro de chamados</label>
                <select id="selectTodosChamados" onchange="changeUrlSelectTodosChamados(); removeKeysUrl();">
                    <option value="0">Todos chamados</option>
                    <option value="1">Chamados de técnicos</option>
                    <option value="2">Chamados de docentes</option>
                </select>

            <label id="lblTecnicosUsuarios">
                <?php
                
                if (isset($_GET['tecnico']))
                    echo 'Técnicos';
                else if(isset($_GET['usuario']))
                    echo 'Usuários';
                
                ?>
            </label>
                
            <div id="divSelectTecnicos">
                <select id="selectTecnicos" onchange="changeUrlSelectTecnicos();">
                    <option value="todos">Todos</option>

                    <?php
                    $lista = ChamadoDAO::getTecnicos();

                    foreach ($lista as $tecnico) {

                        echo '<option value="' . $tecnico->getCodigo() . '">' . $tecnico->getNomeUsuario() . '</option>';
                    }
                    ?>

                </select>
            </div>

            <div id="divSelectUsuarios">
                <select id="selectUsuarios" onchange="changeUrlSelectUsuarios();">
                    <option value="todos">Todos</option>

                    <?php
                    $lista = ChamadoDAO::getUsuarios();

                    foreach ($lista as $usuario) {

                        echo '<option value="' . $usuario->getNomeUsuario() . '">' . $usuario->getNomeUsuario() . '</option>';
                    }
                    ?>

                </select>
            </div>

                    <?php
                }
                ?>

            <a href="abrirChamado.php">
                <h1 align="center"><button id="btSolicitarNovoChamado">Solicitar novo chamado</button></a></h1>
        <br><br>

    <?php
    $lista = new ArrayObject();

    $tecnico = null;
    $status = null;
    $nomeUsuario = null;

    if (isset($_GET['tecnico']))
        $tecnico = $_GET['tecnico'];

    if (isset($_GET['status']))
        $status = $_GET['status'];

    if (isset($_GET['usuario']))
        $nomeUsuario = $_GET['usuario'];

    if ($_SESSION['admin'] == 1) {

        if ($_GET['codigo'] == 0) {

            $lista = ChamadoDAO::getChamados($status);
        } else if ($_GET['codigo'] == 1) {

            $lista = ChamadoDAO::getAllChamadosByCodigoTecnico($tecnico, $status);
        } else if ($_GET['codigo'] == 2) {

            $lista = ChamadoDAO::getAllChamadosByUsuario($nomeUsuario, $status);
        }
    } else {

        $lista = ChamadoDAO::getAllChamadosByUsuario($_SESSION['nomeUsuario'], $status);
    }

    date_default_timezone_set('America/Sao_Paulo');
    echo '<h2 align="center">' . date("d/m/Y") . "</h2><br><br>";

        ?>

            <label>Status: </label>
            <select id="selectStatus" onchange="changeUrlSelectStatus();">
                <option value="0">Selecione...</option>
                <option value="todos">Todos</option>
                <option value="Em aberto">Em aberto</option>
                <option value="Resolvido">Resolvido</option>
                <option value="Cancelado">Cancelado</option>
            </select><br><br>

        <?php

    if ($lista->count() == 0) {
        echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
    } else {

        echo '<h3>Total de chamados: ' . $lista->count() . '</h3>';
        ?>

            <table>
                <tr>
                    <th>Número</th>
                    <th>Usuário</th>
                    <th>Sala</th>
                    <th>Descrição do problema</th>
                    <th>Status atual</th>
                    <th>Histórico de Status</th>
                    <th>Nível de criticidade</th>
                    <th>Técnico responsável</th>
                    <th>Data e hora de abertura</th>
<!--                    <th>Data e hora de encerramento</th>
                    <th>Solução do problema</th>
                    <th>Tempo utilizado</th>-->

        <?php
        if ($_SESSION['admin'] == 1) {
            ?>

                        <th>Editar</th>
                        <th>Pausar/Retomar</th>

            <?php
        }
        ?>

                    <th>Cancelar</th>

                    <?php
                    if ($_SESSION['admin'] == 1) {
                        ?>

                        <th>Encerrar</th>

                        <?php
                    }
                    ?>
                </tr>
                    <?php
                    foreach ($lista as $chamado) {

                        echo '<tr>'
                        . '<td>' . $chamado->getCodigo() . '</td>'
                        . '<td>' . $chamado->getUsuario()->getNomeUsuario() . '</td>'
                        . '<td>' . $chamado->getSala()->getNumero() . '</td>'
                        . '<td>' . $chamado->getDescricaoProblema() . '</td>'
                        . '<td>' . $chamado->getStatus() . '</td>'
                        . '<td>' . $chamado->getHistoricoStatus() . '</td>'
                        . '<td>' . $chamado->getNivelCriticidade() . '</td>';

                        if ($chamado->getTecnicoResponsavel() != null) {

                            echo '<td>' . $chamado->getTecnicoResponsavel()->getNomeUsuario() . '</td>';
                        } else {

                            echo '<td></td>';
                        }

                        echo '<td>' . $chamado->getDataHoraAbertura() . '</td>';
//                        . '<td></td>'
//                        . '<td>' . $chamado->getSolucaoProblema() . '</td>'
//                        . '<td></td>';


                        if ($_SESSION['admin'] == 1) {

                            echo '<td>'
                            . '<a href="abrirChamado.php?editar&codigoChamado=' . $chamado->getCodigo() . '"><button>Editar</button></a>'
                            . '</td>';

                            if ($chamado->getPausado() == 0) {

                                echo '<td><a href="controller/salvarChamado.php?pausar&codigoChamado=' . $chamado->getCodigo() . '"><button>Pausar</button></a>'
                                . '</td>';
                            } else {

                                echo '<td><a href="controller/salvarChamado.php?retomar&codigoChamado=' . $chamado->getCodigo() . '"><button>Retomar</button></a>'
                                . '</td>';
                            }
                        }

                        echo '<td>'
                        . '<a href="controller/salvarChamado.php?cancelar&codigoChamado=' . $chamado->getCodigo() . '"><button>Cancelar</button></a>'
                        . '</td>';

                        if ($_SESSION['admin'] == 1) {

                            echo '<td>'
                            . '<a href="controller/salvarChamado.php?encerrar&codigoChamado=' . $chamado->getCodigo() . '"><button>Encerrar</button></a>'
                            . '</td>'
                            . '</tr>';
                        }
                    }
                    ?>
            </table>
                <?php
            }
        } else {
            header("Location: login.php");
        }
        ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>
</html>
