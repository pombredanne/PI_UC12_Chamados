<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="menu.css">

    <script type="text/javascript" src="menu.js"></script>

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

    <input type="checkbox" id="cbMenu">
    <label for="cbMenu">&#9776;</label>

    <nav class="menu">
        <ul class="ulPrimaria">
            <li><a href=""><?php echo $_SESSION['nomeUsuario']; ?></a></li>
            <li id="liSalas"><a href="salas.php">Salas</a>
                <ul>
                    <li><a href="cadastrarSala.php">Cadastrar sala</a></li>
                </ul>
            </li>
            <li><a href="chamados.php">Chamados</a></li>
            <li><a href="usuarios.php">Usuários</a>
                <ul>
                    <li><a href="cadastrarUsuario.php">Cadastrar Usuário</a></li>
                </ul>
            </li>

                <?php
                $usuario = UsuarioDAO::getUsuario($_SESSION['codigo']);
                ?>
                
                <img src="fotos/senac_logo.png" width="200px"/>
                    <ul>
                        <li><a id="aDivSair" href="sair.php">Sair</a></li>
                    </ul>
        </ul>

    </nav>

    <?php
//            if ($_SESSION['admin'] == 1) {
    ?>

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
    
                <a id="aUsuarios" href="usuarios.php">Todos Usuários</a>
        
            <div class="divNomeUsuario">
                    <a href=""><?php echo $_SESSION['nomeUsuario'] ?></a>
                    <a id="aDivSair" href="sair.php">Sair</a>
            </div>-->

    <?php
//        $usuario = UsuarioDAO::getUsuario($_SESSION['codigo']);
//        
//        echo '<img id="imgUsuario" src="fotos/' . $usuario->getFoto() . '" width="100px"/>';
//    }
    ?>

</header>


