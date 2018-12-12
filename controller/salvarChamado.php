<?php

session_start();

include_once '../dao/clsConexao.php';
include_once '../dao/clsChamadoDAO.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';
include_once '../model/clsFakeTecnicoResponsavel.php';

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
    
    $chamado->setStatus("Em aberto");
    
    ChamadoDAO::inserir($chamado);
    
    header("Location: ../chamados.php");
}

if (isset($_GET['editar'])) {
    
    $chamado->setCodigo($_GET['codigoChamado']);
    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);
    $chamado->setStatus($_POST['selectStatus']);
    $chamado->setNivelCriticidade($_POST['selectNivelCriticidade']);
    
    $fakeTecnicoResponsavel = new FakeTecnicoResponsavel();
    $fakeTecnicoResponsavel->setCodigo($_POST['selectTecnicoResponsavel']);
    $chamado->setTecnicoResponsavel($fakeTecnicoResponsavel);
    
    $chamado->setSolucaoProblema($_POST['taSolucaoProblema']);
    
    $sala->setCodigo($_POST['selectSala']);
    $chamado->setSala($sala);
    
    ChamadoDAO::editar($chamado);
    
    header("Location: ../chamados.php");
}