<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="menu.css">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

</head>

<header>

    <?php
    error_reporting(0);

    include_once 'dao/clsConexao.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'model/clsUsuario.php';

    if (session_status() != PHP_SESSION_ACTIVE) {

        session_start();
    }
    ?>

    <div id="divMenuToogle"><i class="fas fa-bars"></i></div>
    <nav>
        <ul id="ulMain">

            <?php
            if ($_SESSION['admin'] == 1) {
                ?>

                <li class="liSubMenu"><a id="aSalas" href="salas.php">Salas</a>
                    <ul>
                        <li><a id="aCadastrarSala" href="cadastrarSala.php">Cadastrar sala</a></li>
                    </ul>
                </li>

                <?php
            }
            ?>

            <li class="liSubMenu"><a id="aChamados" href="chamados.php">Chamados</a>
                <ul>

                    <?php
                    if ($_SESSION['admin'] == 1) {
                        ?>

                        <li><a id="aAbrirChamado" href="abrirChamado.php">Abrir chamado</a></li>
                    </ul>
                </li>
                <li class="liSubMenu"><a id="aUsuarios" href="usuarios.php">Usuários</a>
                    <ul>
                        <li><a id="aCadastrarUsuario" href="cadastrarUsuario.php">Cadastrar usuário</a></li>
                    </ul>
                </li>

                <?php
            }
            ?>
            <div id="divImgMenu">

                <?php
                $foto = UsuarioDAO::getFoto($_SESSION['codigo']);
                ?>

                <img id="imgMenu" src="fotos/<?php echo $foto; ?>">
                <a id="aSair" href="sair.php">Sair</a>
            </div>

        </ul>
    </nav>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="menu.js"></script>

</header>