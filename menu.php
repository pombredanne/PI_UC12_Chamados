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
    
    if (!$_SESSION['tipo'] == "gerenciamento" && $_SESSION['logado']) {

        echo '<a href="abrirChamado.php"><button>Abrir chamado</button></a>';
    }

    if (isset($_SESSION['logado']) && $_SESSION['logado']) {

        echo ' <a href="sair.php"><button>Sair</button></a>';
        echo '<br><br>Olá ' . $_SESSION['nome'] . "<br><br>";
    }
    
    ?>

</header>


