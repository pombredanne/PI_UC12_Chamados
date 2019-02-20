<?php

include_once '../dao/clsConexao.php';
include_once '../dao/clsSalaDAO.php';
include_once '../model/clsSala.php';

$sala = new Sala();

if (isset($_GET['inserir'])) {

    $sala->setNumero($_POST['txtNumero']);
    $sala->setDescricao($_POST['taDescricaoSala']);

    SalaDAO::inserir($sala);

    header("Location: ../salas.php");
}

if (isset($_GET['editar'])) {

    $codigo = $_GET['codigoSala'];

    $sala = SalaDAO::getSalaByCodigo($codigo);

    $sala->setCodigo($codigo);
    $sala->setNumero($_POST['txtNumero']);
    $sala->setDescricao($_POST['taDescricaoSala']);

    SalaDAO::editar($sala);

    header("Location: ../salas.php");
}

if (isset($_GET['excluir'])) {

    $sala = SalaDAO::getSalaByCodigo($_GET['codigoSala']);
    
    echo '<head>'
    . '<style>'
    . 'button {
        width: 10%;
    height: 10%;
    background-color: #f8b032;
    color: #0033ff;
    font-weight: bold;
    font-size: 130%;
    }
    
button:hover {
    background-color: #f8b032;
    color: #0033ff;
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
    . '<br><br><br><h3>Tem certeza que deseja excluir a sala ' . $sala->getNumero() . ' ?</h3>'
    . '<br><br>'
    . '<a href="../salas.php">'
    . '<button id="btVoltar">Voltar</button></a> '
    . '<a href="?confirmarExcluir&codigoSala=' . $_GET['codigoSala'] . '">'
    . '<button id="btExcluir">Excluir</button></a>'
    . '</body>';
}

if (isset($_GET['confirmarExcluir'])) {
    
    $excluir = SalaDAO::excluir($_GET['codigoSala']);

    if ($excluir == false) {

        echo '<body onload="window.history.back();">'
        . '<script>'
        . 'alert("Esta sala não pode ser deletada pois pertence a algum chamado!");'
        . '</script>'
        . '</body>';
    } else {

        header("Location: ../salas.php");
    }
    
}

