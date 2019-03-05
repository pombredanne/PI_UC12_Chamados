<?php

error_reporting(0);

include_once 'dao/clsConexao.php';
include_once 'dao/clsChamadoDAO.php';
include_once 'dao/clsSalaDAO.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsChamado.php';
include_once 'model/clsUsuario.php';
include_once 'model/clsSala.php';

$lista = new ArrayObject();

if ($_GET['indexSelectTodosChamados'] == 0)
{
    
    $lista = ChamadoDAO::getChamados($_GET['indexSelectStatus']);
    
}
else
{
    if ($_GET['indexSelectTodosChamados'] == 1)
    {
        $lista = ChamadoDAO::getAllChamadosByNomeUsuarioTecnico
                ($_GET['indexSelectTecnicosUsuarios'], $_GET['indexSelectStatus']);
    }
    else if ($_GET['indexSelectTodosChamados'] == 2)
    {
        $lista = ChamadoDAO::getAllChamadosByUsuario
                ($_GET['indexSelectTecnicosUsuarios'], $_GET['indexSelectStatus']);
    }
}

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

$chaveChamadoTecnicoCodigo = 'chaveChamadoTecnicoCodigo';
$chaveChamadoTecnicoNomeUsuario = 'chaveChamadoTecnicoNomeUsuario';

$chaveUsuarioCodigo = 'chaveUsuarioCodigo';
$chaveUsuarioNomeUsuario = 'chaveUsuarioNomeUsuario';

$chaveSalaCodigo = 'chaveSalaCodigo';
$chaveSalaNumero = 'chaveSalaNumero';
$i = 0;

//$lista = ChamadoDAO::getChamados('todos');

if ($lista->count() > 0) {

    foreach ($lista as $chamado) {
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
            $array[$chaveChamadoTecnicoNomeUsuario . $i] = $chamado->getTecnicoResponsavel()->getNomeUsuario();
        } else {

//         $array[$chaveTecnicoCodigo . $i] = "";
            $array[$chaveChamadoTecnicoNomeUsuario . $i] = "";
        }

//    $array[$chaveUsuarioCodigo . $i] = $chamado->getUsuario()->getCodigo();
        $array[$chaveUsuarioNomeUsuario . $i] = $chamado->getUsuario()->getNomeUsuario();

//    $array[$chaveSalaCodigo . $i] = $chamado->getSala()->getCodigo();
        $array[$chaveSalaNumero . $i] = $chamado->getSala()->getNumero();
        $i++;
    }

    $array['rows'] = $lista->count();
} else {

    $array = null;
}

//$array = array('chave1' => 1,'chave2' => 2,'chave3' => 3,
//    'chave4' => 4,'chave5' => 5,'chave6' => 6);
//foreach($array as $a) {
//    echo implode('~', $array);
//}
$json = json_encode($array);
echo $json;
