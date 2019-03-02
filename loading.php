<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <link rel="stylesheet" type="text/css" href="loading.css">
        
    </head>
    <body>
        
        <script src="jquery.js"></script>
        <script src="loading.js"></script>
        
        <?php
        
        error_reporting(0);
        
        $redirect = '';
        
        if (isset($_COOKIE['redirect'])) {
        
            $redirect = $_COOKIE['redirect'];
            
        ?>
        
        <script>
            
        var varRedirect = "<?php echo $redirect; ?>";
        
        redirect(varRedirect);
        
        </script>
        
        <img src="fotos/senac_logo.png">
        
        <nav>
            <ul>
                <li data-title="C">C</li>
                <li data-title="A">A</li>
                <li data-title="R">R</li>
                <li data-title="R">R</li>
                <li data-title="E">E</li>
                <li data-title="G">G</li>
                <li data-title="A">A</li>
                <li data-title="N">N</li>
                <li data-title="D">D</li>
                <li data-title="O">O</li>
            </ul>
        </nav>
        
        <?php
        
        } else {
            
            echo '<script>window.history.back();</script>';
            
        }
        
        ?>
        
    </body>
</html>
