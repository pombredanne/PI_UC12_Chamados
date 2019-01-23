<?php

include_once '../dao/clsConexao.php';
include_once '../model/clsUsuario.php';
include_once '../dao/clsUsuarioDAO.php';

if (isset($_GET['inserir'])) {
    
    if ($_POST['txtSenha'] == $_POST['txtConfirmarSenha']){
        
    $usuario = new Usuario();
    $usuario->setNomeCompleto($_POST['txtNome']);
    $usuario->setNomeUsuario($_POST['txtNomeUsuario']);
    $usuario->setEmail($_POST['txtEmail']);
        
    if (isset($_POST['cbAdmin']))
        $usuario->setAdmin (1);
    else
        $usuario->setAdmin (0);
    
    $usuario->setSenha(md5($_POST['txtSenha']));
    
    UsuarioDAO::inserir($usuario);
    
    header("cadastrarUsuario.php");
    
    } else {
        echo '<script>window.history.back();</script>';
    }
}