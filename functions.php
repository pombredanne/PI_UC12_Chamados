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
$arrayNomeUsuarios = new ArrayObject();

if ($_GET['indexSelectTodosChamados'] == 0) {

    $lista = ChamadoDAO::getChamados($_GET['indexSelectStatus']);
} else {
    if ($_GET['indexSelectTodosChamados'] == 1) {
        $lista = ChamadoDAO::getAllChamadosByNomeUsuarioTecnico
                        ($_GET['indexSelectTecnicosUsuarios'], $_GET['indexSelectStatus']);

        $arrayNomeUsuarios = ChamadoDAO::getTecnicos();
    } else if ($_GET['indexSelectTodosChamados'] == 2) {
        $lista = ChamadoDAO::getAllChamadosByUsuario
                        ($_GET['indexSelectTecnicosUsuarios'], $_GET['indexSelectStatus']);

        $arrayNomeUsuarios = ChamadoDAO::getUsuarios();
    }
}

if ($lista->count() > 0) {

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

    foreach ($lista as $chamado) {

        $array[$chaveChamadoCodigo . $i] = $chamado->getCodigo();
        $array[$chaveChamadoDataHoraAbertura . $i] = $chamado->getDataHoraAbertura();
        $array[$chaveChamadoDescricaoProblema . $i] = $chamado->getDescricaoProblema();
        $array[$chaveChamadoStatus . $i] = $chamado->getStatus();
        $array[$chaveChamadoHistoricoStatus . $i] = $chamado->getHistoricoStatus();
        $array[$chaveChamadoNivelCriticidade . $i] = $chamado->getNivelCriticidade();
        $array[$chaveChamadoSolucaoProblema . $i] = $chamado->getSolucaoProblema();

        if ($chamado->getTecnicoResponsavel() != null) {

            $array[$chaveChamadoTecnicoNomeUsuario . $i] = $chamado->getTecnicoResponsavel()->getNomeUsuario();
        } else {

            $array[$chaveChamadoTecnicoNomeUsuario . $i] = "";
        }

        $array[$chaveUsuarioNomeUsuario . $i] = $chamado->getUsuario()->getNomeUsuario();

        $array[$chaveSalaNumero . $i] = $chamado->getSala()->getNumero();

        $i++;
    }

    $array['countRows'] = $lista->count();
} else {

    $array = null;
}

//array de usuários
if ($arrayNomeUsuarios->count() > 0) {
    $chaveTecnicosUsuarios = 'chaveTecnicosUsuarios';

    $i = 0;

    foreach ($arrayNomeUsuarios as $usuario) {
        $array[$chaveTecnicosUsuarios . $i] = $usuario->getNomeUsuario();
        $i++;
    }

    $array['countUsuarios'] = $arrayNomeUsuarios->count();
    
    if ($arrayNomeUsuarios[0]->getAdmin() == 1)
    {
        $array['chaveUsuarioAdmin'] = 1;
    } else {
        $array['chaveUsuarioAdmin'] = 0;
    }
    
} else {
    $array[$chaveTecnicosUsuarios] = null;
    $array['countUsuarios'] = null;
}

$json = json_encode($array);
echo $json;