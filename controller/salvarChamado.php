<?php

session_start();

include_once '../dao/clsConexao.php';
include_once '../dao/clsChamadoDAO.php';
include_once '../model/clsChamado.php';

$chamado = new Chamado();

if (isset($_GET['inserir'])) {
    
    $chamado->setSala($_POST['selectSala']);
    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);
    
    date_default_timezone_set('America/Sao_Paulo');
    $chamado->setDataHora(date("Y-m-d H:i:s"));
    $chamado->setUsuario($_SESSION['nomeUsuario']);
    $chamado->setStatus("Em aberto");
    
    ChamadoDAO::inserir($chamado);
    
    header("Location: ../index.php");
}

if (isset($_GET['editar'])) {
    
    $chamado->setSala($_POST['selectSala']);
//    $chamado->setStatus($_POST['txtStatus']));
    
    ChamadoDAO::editar($chamado);
    
    header("Location: ../chamados.php");
}