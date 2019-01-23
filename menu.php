<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="menu.css">

</head>

<header>

    <!--<div id="divBotoes">-->

    <div class="navBar">

        <nav id="navLinks">

            <?php
            error_reporting(0);

            if (session_status() != PHP_SESSION_ACTIVE) {

                session_start();
            }

            if ($_SESSION['admin'] == 1) {
                ?>

                <a href="salas.php">Salas</a>
                <a href="cadastrarUsuario.php">Cadastrar Usuário</a>

                <?php
            }
            ?>

            <?php
            if (isset($_SESSION['logado']) && $_SESSION['logado']) {
                ?>

                <a href="chamados.php">Chamados</a>
            </nav>

            <!--<a id="linkSair" href="sair.php">Sair</a>-->

            <!--</div>-->

            <!--        $nome = 'Olá ' . $_SESSION['nomeUsuario'];
                   $nome = "10:20:30";
                   $nome = str_replace(":", "", $nome);
                   $nome = substr($nome, 0, 2);
                    echo '<br><br><div>' . $nome . "</div><br><br>";-->

        </div>

        <div class="divNomeUsuario">
                <a href="#"><?php echo $_SESSION['nomeUsuario'] ?></a>
                <a id="aDivSair" href="sair.php">Sair</a>

    <!--<span id="spanNomeUsuario"><?php echo $_SESSION['nomeUsuario'] ?></span><br><br>-->

        </div>

        <?php
    }
    ?>

</header>


