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

