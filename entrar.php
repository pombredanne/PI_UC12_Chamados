<?php

include_once 'dao/clsConexao.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsUsuario.php';

$nomeUsuario = $_POST['txtUsuario'];
$senha = $_POST['txtSenha'];
$senha = md5($senha);

$usuario = UsuarioDAO::login($nomeUsuario, $senha);

if ($usuario == null) {

    echo '<body onload="window.history.back()">';
} else {

    session_start();
    $_SESSION['logado'] = true;
    $_SESSION['id'] = $usuario->getId();
    $_SESSION['nome'] = $usuario->getNome();
    $_SESSION['nomeUsuario'] = $usuario->getNomeUsuario();
    $_SESSION['senha'] = $usuario->getSenha();
}

header("Location: " . $_SERVER['HTTP_REFERER']);



