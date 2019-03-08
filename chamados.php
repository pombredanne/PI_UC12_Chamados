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

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

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

            <script type="text/javascript" src="jquery.js"></script>
            <script type="text/javascript" src="chamados.js"></script>

        </head>

        <body>

            <?php
            require_once 'menu.php';
            ?>

            <a href="abrirChamado.php"><button id="btSolicitarNovoChamado">Solicitar novo chamado</button></a>
            <br><br>    

            <div id="divContainerLabel">
                <label id="lblFiltroChamados">Filtro de chamados</label>
                <label id="lblStatus">Status</label>
                <label id="lblTecnicosUsuarios"></label>
            </div>

            <div id="divContainerSelect">

                <?php
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    ?>

                <div id="divSelectTodosChamados">
                    <select id="selectTodosChamados">
                        <option value="0">Todos chamados</option>
                        <option value="1">Chamados de técnicos</option>
                        <option value="2">Chamados de docentes</option>
                    </select>
                </div>
                    
                    <?php
                }
                ?>

                <div id="divSelectStatus">
                    <select id="selectStatus">
                        <option value="todos">Todos</option>
                        <option value="Em aberto">Em aberto</option>
                        <option value="Resolvido">Resolvido</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>

                <?php
                if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                    ?>

                <div id="divSelectTecnicosUsuarios">
                    <select id="selectTecnicosUsuarios"></select>
                </div>
                    <?php
                }
                ?>

            </div>

            <div id="divTable"></div>

        </table>
        <?php
    } else {
        header("Location: login.php");
    }
    ?>

</body>
</html>
