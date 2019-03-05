<?php
error_reporting(0);

session_start();

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

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
            <script type="text/javascript" src="jquery.js"></script>
            <script type="text/javascript" src="js-cookie/src/js.cookie.js"></script>
            <script type="text/javascript" src="chamados.js"></script>

        </head>

        <body>
<!--//            selectInvisible();
//                    selectVisible();
//                    selectedOptionChamados();
//                    selectedOptionTecnicosUsuarios();
    //                    selectedOptionStatus();-->

        <?php
//        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
//
//            if ($_GET['tipo'] == 'tecnico' && $_GET['codigo'] != 1 || $_GET['usuario'] == 'docente' && $_GET['codigo'] != 2) {
//
//                echo 'changeUrlSelectTodosChamados();">';
//            } else {
//                ?>

                      <!--">-->

                    <?php
//                }
//            }
            ?>

            <?php
            require_once 'menu.php';
            ?>


            <h1><button id="btSolicitarNovoChamado"><a href="abrirChamado.php">Solicitar novo chamado</a></button></h1>
            <br><br>    

            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                ?>

                <label id="lblFiltroChamados">Filtro de chamados</label>

                <div id="divSelectTodosChamados">
                    <select id="selectTodosChamados">
                    <!--<select id="selectTodosChamados" onchange="changeUrlSelectTodosChamados();">-->
                        <option value="0">Todos chamados</option>
                        <option value="1">Chamados de técnicos</option>
                        <option value="2">Chamados de docentes</option>
                    </select>
                </div><br><br>

                <label id="lblTecnicosUsuarios">
                    <?php
                    if ($_GET['tipo'] == 'tecnico')
                        echo 'Técnicos';
                    else if ($_GET['tipo'] == 'docente')
                        echo 'Usuários';
                    ?>
                </label>

                <div id="divSelectTecnicosUsuarios">
                    <select id="selectTecnicosUsuarios">
                    <!--<select id="selectTecnicosUsuarios" onchange="changeUrlSelectTecnicosUsuarios();">-->
                        <option value="todos">Todos</option>

                        <?php
                        if ($_GET['tipo'] == 'tecnico') {

                            $lista = ChamadoDAO::getTecnicos();

                            foreach ($lista as $tecnico) {

                                echo '<option value="' . $tecnico->getNomeUsuario() . '">' . $tecnico->getNomeUsuario() . '</option>';
                            }
                        } else if ($_GET['tipo'] == 'docente') {

                            $lista = ChamadoDAO::getUsuarios();

                            foreach ($lista as $usuario) {

                                echo '<option value="' . $usuario->getNomeUsuario() . '">' . $usuario->getNomeUsuario() . '</option>';
                            }
                        }
                        ?>

                    </select>
                </div><br><br>

                <?php
            }
            ?>

            <?php
            $lista = new ArrayObject();

            $status = null;
            $nomeUsuario = null;

            if (isset($_GET['status']))
                $status = $_GET['status'];

            if (isset($_GET['tipo'])) {

                $nomeUsuario = $_GET['usuario'];
            }

            if ($_SESSION['admin'] == 1) {

//                if ($_GET['codigo'] == 0) {
//
//                    $lista = ChamadoDAO::getChamados($status);
//                } else if ($_GET['codigo'] == 1) {
//
//                    $lista = ChamadoDAO::getAllChamadosByNomeUsuarioTecnico($nomeUsuario, $status);
//                } else if ($_GET['codigo'] == 2) {
//
//                    $lista = ChamadoDAO::getAllChamadosByUsuario($nomeUsuario, $status);
//                }
//                    echo $_COOKIE['select'];
//                    echo $_COOKIE['status'];
//                    
//                    setcookie('select', '', time() - 3600);
//                        unset($_COOKIE['select']);
//                        setcookie('status', '', time() - 3600);
//                        unset($_COOKIE['status']);
//                    
//                    if ($_COOKIE['select'] === 'selectStatus') {
//                        
//                        $status = $_COOKIE['status'];

                        $lista = ChamadoDAO::getChamados('todos');
//                        setcookie('select', '', time() - 3600);
//                        unset($_COOKIE['select']);
//                        setcookie('status', '', time() - 3600);
//                        unset($_COOKIE['status']);
//                    }
                    
            } else {

                $lista = ChamadoDAO::getAllChamadosByUsuario($_SESSION['nomeUsuario'], $status);
            }
            ?>
                
            <label id="lblStatus">Status</label>
            <div id="divSelectStatus">
                <!--<select id="selectStatus">-->
                
<select id="selectStatus" onchange="ajax();">
                <!--<select id="selectStatus" onchange="changeUrlSelectStatus();">-->
                    <option value="todos">Todos</option>
                    <option value="Em aberto">Em aberto</option>
                    <option value="Resolvido">Resolvido</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div><br><br>

            <?php
//            echo '<h3>' . $_COOKIE['status'] . '</h3>';

            if ($lista->count() == 0) {
                echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
            } else {

                if ($_GET['status'] == 'todos')
                    echo '<h3>Total de chamados: ' . $lista->count() . '</h3>';
                else if ($_GET['status'] == 'Em aberto')
                    echo '<h3>Chamados em aberto: ' . $lista->count() . '</h3>';
                else if ($_GET['status'] == 'Resolvido')
                    echo '<h3>Chamados resolvidos: ' . $lista->count() . '</h3>';
                else if ($_GET['status'] == 'Cancelado')
                    echo '<h3>Chamados cancelados: ' . $lista->count() . '</h3>';
                ?>

                <table id="tableChamados">
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
                    
//                    for ($i = 0; $i < $lista->count(); $i++) {
                        
//                        for ($j = 1; $j < 2; $j++) {
                            
                            echo '<tr>'
                        . '<td>' . $lista[1][2] . '</td>'
                        . '</tr>'; 
                            
//                        }
                        
//                    }
                    
//                    foreach ($lista as $chamado) {
//
//                        echo '<tr>'
//                        . '<td>' . $chamado->getCodigo() . '</td>'
//                        . '<td>' . $chamado->getUsuario()->getNomeUsuario() . '</td>'
//                        . '<td>' . $chamado->getSala()->getNumero() . '</td>'
//                        . '<td>' . $chamado->getDescricaoProblema() . '</td>'
//                        . '<td>' . $chamado->getStatus() . '</td>'
//                        . '<td>' . $chamado->getHistoricoStatus() . '</td>'
//                        . '<td>' . $chamado->getNivelCriticidade() . '</td>';
//
//                        if ($chamado->getTecnicoResponsavel() != null) {
//
//                            echo '<td>' . $chamado->getTecnicoResponsavel()->getNomeUsuario() . '</td>';
//                        } else {
//
//                            echo '<td></td>';
//                        }
//
//                        echo '<td>' . $chamado->getDataHoraAbertura() . '</td>';
////                        . '<td></td>'
////                        . '<td>' . $chamado->getSolucaoProblema() . '</td>'
////                        . '<td></td>';
//
//
//                        if ($_SESSION['admin'] == 1) {
//
//                            echo '<td class="tdBotao">'
//                            . '<a href="abrirChamado.php?editar&codigoChamado=' . $chamado->getCodigo() . '"><button>Editar</button></a>'
//                            . '</td>';
//
//                            if ($chamado->getPausado() == 0) {
//
//                                echo '<td class="tdBotao"><a href="controller/salvarChamado.php?pausar&codigoChamado=' . $chamado->getCodigo() . '"><button>Pausar</button></a>'
//                                . '</td>';
//                            } else {
//
//                                echo '<td class="tdBotao"><a href="controller/salvarChamado.php?retomar&codigoChamado=' . $chamado->getCodigo() . '"><button>Retomar</button></a>'
//                                . '</td>';
//                            }
//                        }
//
//                        echo '<td class="tdBotao">'
//                        . '<a href="controller/salvarChamado.php?cancelar&codigoChamado=' . $chamado->getCodigo() . '"><button>Cancelar</button></a>'
//                        . '</td>';
//
//                        if ($_SESSION['admin'] == 1) {
//
//                            echo '<td class="tdBotao">'
//                            . '<a href="controller/salvarChamado.php?encerrar&codigoChamado=' . $chamado->getCodigo() . '"><button>Encerrar</button></a>'
//                            . '</td>'
//                            . '</tr>';
//                        }
//                    }
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
