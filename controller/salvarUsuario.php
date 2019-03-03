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
    $usuario->setFoto(salvarFoto());
    
    if (isset($_POST['cbAdmin']))
        $usuario->setAdmin(1);
    else
        $usuario->setAdmin (0);
    
    UsuarioDAO::editar($usuario);
    
    header("Location: ../usuarios.php");
}

if (isset($_GET['excluir'])) {
    
    setcookie('historyBack', $_SERVER['HTTP_REFERER']);
    
    $usuario = UsuarioDAO::getUsuarioByCodigo($_GET['codigoUsuario']);
    
    echo '<head>'
    . '<style>'
    . 'button {
        width: 10%;
    height: 10%;
    background-color: #f8b032;
    color: #0033ff;
    font-weight: bold;
    font-size: 130%;
    border-radius: 100px;
    }
    
button:hover {
    background-color: #0033ff;
    color: white;
    }
    
#btExcluir {
position: absolute;
left: 40%;
top: 60%;
}

#btVoltar {
position: absolute;
left: 55%;
top: 60%;
}
    
h3 {
position: absolute;
left: 35%;
font-size: 200%;
}

body {
background-image: url("../fotos/background_cadastrarUsuario.png");
}
'
    . '</style>'
    . '</head>'
    . '<body>'
    . '<br><br><br><h3>Tem certeza que deseja excluir o usuário ' . $usuario->getNomeUsuario() . ' ?</h3>'
    . '<br><br>'
    . '<a href="../usuarios.php">'
    . '<button id="btVoltar">Voltar</button></a> '
    . '<a href="?confirmarExcluir&codigoUsuario=' . $_GET['codigoUsuario'] . '">'
    . '<button id="btExcluir">Excluir</button></a>'
    . '</body>';
    
}

if (isset($_GET['confirmarExcluir'])) {
    
    $excluir = UsuarioDAO::excluir($_GET['codigoUsuario']);

    if ($excluir == false) {

        echo '<body>'
        . '<script>'
        . 'alert("Este usuário não pode ser deletado pois pertence a algum chamado!"); '
        . 'window.location = "' . $_COOKIE['historyBack'] . '"'
        . '</script>'
        . '</body>';
        
    } else {

        header("Location: ../usuarios.php");
    }
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