<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="menu.css">

</head>

<header>

    <!--<div id="divBotoes">-->

    <!--<div class="navBar">-->

        <!--<nav id="navLinks">-->

            <?php
            
            error_reporting(0);
            
            include_once 'dao/clsConexao.php';
            include_once 'dao/clsUsuarioDAO.php';
            include_once 'model/clsUsuario.php';
            
            ?>
        <div>
        <nav>
            <ul class="menu">
                <li><a href="salas.php">Salas</a></li>
                <li><a href="usuarios.php">Usuários</a>
                    <ul>
                        <li><a href="cadastrarUsuario.php">Cadastrar Usuário</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        </div>
        

<!--//            if (session_status() != PHP_SESSION_ACTIVE) {
//
//                session_start();
//            }

//            if ($_SESSION['admin'] == 1) {-->
                <!--?>-->

<!--                <a href="salas.php">Salas</a>
                <a href="cadastrarUsuario.php">Cadastrar Usuário</a>-->

                <?php
//            }
            ?>

            <?php
//            if (isset($_SESSION['logado']) && $_SESSION['logado']) {
                ?>

<!--                <a href="chamados.php?codigo=0&status=todos">Chamados</a>
            </nav>

        </div>

            <a id="aUsuarios" href="usuarios.php">Todos Usuários</a>-->
    
        <!--<div class="divNomeUsuario">-->
                <!--<a href=""><?php // echo $_SESSION['nomeUsuario']?></a>-->
                <!--<a id="aDivSair" href="sair.php">Sair</a>-->
                
    <!--<span id="spanNomeUsuario"><?php echo $_SESSION['nomeUsuario'] ?></span><br><br>-->

        <!--</div>-->

        <?php
//        
//        $usuario = UsuarioDAO::getUsuario($_SESSION['codigo']);
//        
//        echo '<img id="imgUsuario" src="fotos/' . $usuario->getFoto() . '" width="100px"/>';
//    }
    ?>

</header>


