<?php

$nome = "chamados_m171";
$local = "localhost";
$usuario = "root";
$senha = "";

$conn = mysqli_connect($local, $usuario, $senha, $nome);

$nomeUsuario = $_POST['txtNomeUsuario'];
$senha = $_POST['txtSenha'];
        
$query = mysql_query("SELECT * FROM usuarios WHERE nomeUsuario == $nomeUsuario"
        . " AND senha == $senha");

if (mysqli_num_rows($query) < 0) {
    echo 'Senha inválida';
}

mysqli_close($conn);
