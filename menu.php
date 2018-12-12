<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<header>

    <a href="index.php"><button>Início</button></a>

    <?php
    error_reporting(0);

    if (session_status() != PHP_SESSION_ACTIVE) {

        session_start();
    }
    
    if ($_SESSION['admin'] == 1) {
        
        echo '<a href="salas.php"><button>Salas</button></a>';
    }

    if (isset($_SESSION['logado']) && $_SESSION['logado']) {

        echo '<a href="chamados.php"><button>Chamados</button></a>';
        echo ' <a href="sair.php"><button>Sair</button></a>';
        echo '<br><br>Olá ' . $_SESSION['nomeCompleto'] . "<br><br>";
    }
    
    ?>

</header>


