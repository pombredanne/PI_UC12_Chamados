<?php

include_once 'dao/clsConexao.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsUsuario.php';

$nomeUsuario = $_POST['txtNomeUsuario'];
$senha = $_POST['txtSenha'];
$senha = md5($senha);

$usuario = UsuarioDAO::login($nomeUsuario, $senha);

if ($usuario == null) {

    echo '<body onload="window.history.back()">';
    
} else {

    session_start();
    $_SESSION['logado'] = true;
    $_SESSION['admin'] = $usuario->getAdmin();
    $_SESSION['codigo'] = $usuario->getCodigo();
    $_SESSION['nomeCompleto'] = $usuario->getNomeCompleto();
    $_SESSION['nomeUsuario'] = $usuario->getNomeUsuario();
    
        header("Location: chamados.php");
  
}



