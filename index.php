<?php

error_reporting(0);

session_start();

if (!isset($_SESSION['logado']) && !$_SESSION['logado']) {

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Senac</title>
        
        <link rel="stylesheet" type="text/css" href="index.css">
        
    </head>
    <body>
        
        <script src="jquery.js"></script>
        
        <script src="index.js"></script>
        
        <section>
            
            <a href="login.php"><button id="btLogin">Login</button></a>

            <video id="videoSmoke" src="videos/smoke.mp4" autoplay muted loop></video>
            <h1 class="classH1">
                <span class="spanH1">S</span>
                <span class="spanH1">E</span>
                <span class="spanH1">N</span>
                <span class="spanH1">A</span>
                <span class="spanH1">C</span>
            </h1>
        </section>
        
        <?php

} else {
 
    header("Location: chamados.php?codigo=0&status=todos");
}

?>
        
    </body>
    
</html>