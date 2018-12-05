<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<header>
    
    <?php
    
    if (session_status() != PHP_SESSION_ACTIVE) {
        
        session_start();
    }
    
    if (isset($_SESSION['logado']) && $_SESSION['logado']) {
        
        echo 'Olá ' . $_SESSION['nome'];
    }
    
    ?>
    
    <br><br>
    
    <a href="index.php"><button>Início</button></a>
    <a href="abrirChamado.php"><button>Abrir Chamado</button></a>
    <a href="sair.php"><button>Sair</button></a>
    
</header>


