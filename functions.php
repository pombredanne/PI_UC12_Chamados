<?php

error_reporting(0);

include_once 'dao/clsConexao.php';
include_once 'dao/clsChamadoDAO.php';
include_once 'dao/clsSalaDAO.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsChamado.php';
include_once 'model/clsUsuario.php';
include_once 'model/clsSala.php';

//$index = $_GET['index'];

$array = new ArrayObject();
$chaveChamadoCodigo = 'chaveChamadoCodigo';
$chaveChamadoDataHoraAbertura = 'chaveChamadoDataHoraAbertura';
$chaveChamadoDescricaoProblema = 'chaveChamadoDescricaoProblema';
$chaveChamadoStatus = 'chaveChamadoStatus';
$chaveChamadoHistoricoStatus = 'chaveChamadoHistoricoStatus';
$chaveChamadoNivelCriticidade = 'chaveChamadoNivelCriticidade';
$chaveChamadoSolucaoProblema = 'chaveChamadoSolucaoProblema';
$chaveChamadoPausar = 'chaveChamadoPausar';
$chaveChamadoRetomar = 'chaveChamadoRetomar';
$chaveChamadoPausado = 'chaveChamadoPausado';
$chaveChamadoResolvido = 'chaveChamadoResolvido';
$chaveChamadoAtivo = 'chaveChamadoAtivo';

$chaveTecnicoCodigo = 'chaveTecnicoCodigo';
$chaveTecnicoNomeUsuario = 'chaveTecnicoNomeUsuario';

$chaveUsuarioCodigo = 'chaveUsuarioCodigo';
$chaveUsuarioNomeUsuario = 'chaveUsuarioNomeUsuario';

$chaveSalaCodigo = 'chaveSalaCodigo';
$chaveSalaNumero = 'chaveSalaNumero';
$i = 0;

$lista = ChamadoDAO::getChamados('todos');

foreach ($lista as $chamado)
{
    $array[$chaveChamadoCodigo . $i] = $chamado->getCodigo();
    $array[$chaveChamadoDataHoraAbertura . $i] = $chamado->getDataHoraAbertura();
    $array[$chaveChamadoDescricaoProblema . $i] = $chamado->getDescricaoProblema();
    $array[$chaveChamadoStatus . $i] = $chamado->getStatus();
    $array[$chaveChamadoHistoricoStatus . $i] = $chamado->getHistoricoStatus();
    $array[$chaveChamadoNivelCriticidade . $i] = $chamado->getNivelCriticidade();
    $array[$chaveChamadoSolucaoProblema . $i] = $chamado->getSolucaoProblema();
//    $array[$chaveChamadoPausar . $i] = $chamado->getPausar();
//    $array[$chaveChamadoRetomar . $i] = $chamado->getRetomar();
//    $array[$chaveChamadoPausado . $i] = $chamado->getPausado();
//    $array[$chaveChamadoResolvido . $i] = $chamado->getResolvido();
//    $array[$chaveChamadoAtivo . $i] = $chamado->getAtivo();
    
    if ($chamado->getTecnicoResponsavel() != null) {
        
//        $array[$chaveTecnicoCodigo . $i] = $chamado->getTecnicoResponsavel()->getCodigo();
        $array[$chaveTecnicoNomeUsuario . $i] = $chamado->getTecnicoResponsavel()->getNomeUsuario();
        
    } else {
        
//         $array[$chaveTecnicoCodigo . $i] = "";
         $array[$chaveTecnicoNomeUsuario . $i] = "";
        
    }
    
//    $array[$chaveUsuarioCodigo . $i] = $chamado->getUsuario()->getCodigo();
    $array[$chaveUsuarioNomeUsuario . $i] = $chamado->getUsuario()->getNomeUsuario();
    
//    $array[$chaveSalaCodigo . $i] = $chamado->getSala()->getCodigo();
    $array[$chaveSalaNumero . $i] = $chamado->getSala()->getNumero();
    $i++;
}

$array['rows'] = $lista->count();

//$array = array('chave1' => 1,'chave2' => 2,'chave3' => 3,
//    'chave4' => 4,'chave5' => 5,'chave6' => 6);
//foreach($array as $a) {
//    echo implode('~', $array);
//}
$json = json_encode($array);
echo $json;