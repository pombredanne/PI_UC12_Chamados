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
        
        echo 'Olá ' . $_SESSION['senha'];
    }
    
    ?>
    
    <br><br>
    
    <a href="index.php"><button>Início</button></a>
    
</header>


