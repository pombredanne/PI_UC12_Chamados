<?php

include_once 'dao/clsConexao.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsUsuario.php';

$nomeUsuario = $_POST['txtUsuario'];
$senha = md5($_POST['txtSenha']);

$usuario = UsuarioDAO::login($nomeUsuario, $senha);

if ($usuario == null) {

    echo '<body onload="window.history.back()">';
} else {

    session_start();
    $_SESSION['logado'] = true;
    $_SESSION['admin'] = $usuario->getAdmin();
    $_SESSION['id'] = $usuario->getId();
    $_SESSION['nome'] = $usuario->getNome();
    $_SESSION['nomeUsuario'] = $usuario->getNomeUsuario();
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
}



