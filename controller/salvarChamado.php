<?php

session_start();

include_once '../dao/clsConexao.php';
include_once '../dao/clsChamadoDAO.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';

$chamado = new Chamado();
$sala = new Sala();

if (isset($_GET['inserir'])) {

    $sala->setCodigo($_POST['selectSala']);
    $chamado->setSala($sala);

    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);

    date_default_timezone_set('America/Sao_Paulo');
    $chamado->setDataHora(date("Y-m-d H:i:s"));

    $usuario = new Usuario();
    $usuario->setCodigo($_SESSION['codigo']);
    $chamado->setUsuario($usuario);
    
    ChamadoDAO::inserir($chamado);

    header("Location: ../chamados.php");
}

if (isset($_GET['editar'])) {

    $chamado->setCodigo($_GET['codigoChamado']);
    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);
    $chamado->setStatus($_POST['selectStatus']);
    $chamado->setNivelCriticidade($_POST['selectNivelCriticidade']);

    $chamado->setTecnicoResponsavel($_POST['selectTecnicoResponsavel']);

    $chamado->setSolucaoProblema($_POST['taSolucaoProblema']);
    
    $tecnicoResponsavel = new Usuario();
    $tecnicoResponsavel->setCodigo($_POST['selectTecnicoResponsavel']);
    
    $chamado->setTecnicoResponsavel($tecnicoResponsavel);

    $sala->setCodigo($_POST['selectSala']);
    $chamado->setSala($sala);

    if ($_SESSION['admin'] == 1)
        ChamadoDAO::editarChamadoAdmin($chamado);
    else
        ChamadoDAO::editarChamadoDocente($chamado);


    header("Location: ../chamados.php");
}

if (isset($_GET['excluir'])) {

    ChamadoDAO::excluir($_GET['codigoChamado']);

    header("Location: ../chamados.php");
}