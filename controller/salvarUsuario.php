<?php

include_once '../dao/clsConexao.php';
include_once '../model/clsUsuario.php';
include_once '../dao/clsUsuarioDAO.php';

if (isset($_GET['inserir'])) {
    
    $usuario = new Usuario();
    $usuario->setNome($_POST['txtNome']);
    $usuario->setUsuario($_POST['txtUsuario']);
    
    $senha = $_POST['txtSenha'];
    $usuario->setSenha(md5($senha));
    
    UsuarioDAO::inserir($usuario);
    
    header("Location: ../index.php");
}