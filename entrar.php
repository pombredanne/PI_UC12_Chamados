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
    $_SESSION['id'] = $usuario->getCodigo();
    $_SESSION['nomeCompleto'] = $usuario->getNomeCompleto();
    $_SESSION['nomeUsuario'] = $usuario->getNomeUsuario();
    
    if ($usuario->getAdmin() == '') {
        
        header("Location: chamados.php");
        
    } else if ($usuario->getAdmin() == 0){
        
        header("Location: abrirChamado.php");
        
    }else {
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        
    }
}



