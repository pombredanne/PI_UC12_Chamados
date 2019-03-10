<?php

error_reporting(0);

session_start();

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