<?php

include_once '../dao/clsConexao.php';
include_once '../model/clsUsuario.php';
include_once '../dao/clsUsuarioDAO.php';

if (isset($_GET['inserir'])) {
    
    $usuario = new Usuario();
    $usuario->setNome($_POST['txtNome']);
    $usuario->setNomeUsuario($_POST['txtUsuario']);
        
    if (isset($_POST['cbAdmin']))
        $usuario->setAdmin (1);
    else
        $usuario->setAdmin (0);
    
    $senha = $_POST['txtSenha'];
    $senha = md5($senha);
    $usuario->setSenha($senha);
    
    UsuarioDAO::inserir($usuario);
    
    header("Location: ../index.php");
}