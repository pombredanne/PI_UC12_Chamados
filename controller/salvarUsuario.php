<?php

include_once '../dao/clsConexao.php';
include_once '../model/clsUsuario.php';
include_once '../dao/clsUsuarioDAO.php';

if (isset($_GET['inserir'])) {

    if ($_POST['txtSenha'] == $_POST['txtConfirmarSenha']) {

        $usuario = new Usuario();
        $usuario->setNomeCompleto($_POST['txtNomeCompleto']);
        $usuario->setNomeUsuario($_POST['txtNomeUsuario']);
        $usuario->setEmail($_POST['txtEmail']);
        $usuario->setFoto(salvarFoto());

        if (isset($_POST['cbAdmin']))
            $usuario->setAdmin(1);
        else
            $usuario->setAdmin(0);

        $usuario->setSenha(crypt($_POST['txtSenha']), 'uz');

        UsuarioDAO::inserir($usuario);
        
        header("Location: ../cadastrarUsuario.php");
        
    } else {
        echo '<body onload="window.history.back();">'
        . '<script>'
        . 'alert("As senhas não coincidem!");'
        . '</script></body>';
    }
}

if (isset($_GET['editar'])) {
    
    $usuario = UsuarioDAO::getUsuarioByCodigo($_GET['codigoUsuario']);
    
    $usuario->setNomeCompleto($_POST['txtNomeCompleto']);
    $usuario->setNomeUsuario($_POST['txtNomeUsuario']);
    $usuario->setEmail($_POST['txtEmail']);
    
    if (isset($_FILES['txtFoto']['name']) && $_FILES['txtFoto']['name'] != "")
    {
        $usuario->setFoto(salvarFoto());
    }
    
    if (isset($_POST['cbAdmin']))
        $usuario->setAdmin(1);
    else
        $usuario->setAdmin (0);
    
    UsuarioDAO::editar($usuario);
    
    header("Location: ../usuarios.php");
}

function salvarFoto()
{
    $nome_arquivo = "";

    if (isset($_FILES['txtFoto']['name']) && $_FILES['txtFoto']['name'] != "") {

        $nome_arquivo = date('YmdHis') . basename($_FILES['txtFoto']['name']);

        $diretorio = "../fotos/";

        $caminho = $diretorio . $nome_arquivo;

        if (!move_uploaded_file($_FILES['txtFoto']['tmp_name'], $caminho)) {

            $nome_arquivo = "sem_foto.png";

        }

    } else {

        $nome_arquivo = "sem_foto.png";

    }
    
    return $nome_arquivo;
}