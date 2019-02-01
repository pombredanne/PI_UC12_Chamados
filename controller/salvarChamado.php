<?php

session_start();

include_once '../dao/clsConexao.php';
include_once '../dao/clsChamadoDAO.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';

$chamado = new Chamado();
$sala = new Sala();
$tecnicoResponsavel = new Usuario();

if (isset($_GET['inserir'])) {

    $usuario = new Usuario();
    $usuario->setCodigo($_SESSION['codigo']);
    $chamado->setUsuario($usuario);

    $sala->setCodigo($_POST['selectSala']);
    $chamado->setSala($sala);

    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);

    date_default_timezone_set('America/Sao_Paulo');
    $chamado->setDataHoraAbertura(date("Y-m-d H:i:s"));

    if ($_SESSION['admin'] == 1) {

        $chamado->setNivelCriticidade($_POST['selectNivelCriticidade']);

        $tecnicoResponsavel->setCodigo($_POST['selectTecnicoResponsavel']);
        $chamado->setTecnicoResponsavel($tecnicoResponsavel);

        ChamadoDAO::inserirChamadoAdmin($chamado);
    } else {

        ChamadoDAO::inserirChamadoDocente($chamado);
    }

    header("Location: ../chamados.php");
}

if (isset($_GET['editar'])) {

    $chamado->setCodigo($_GET['codigoChamado']);
    $chamado->setDescricaoProblema($_POST['taDescricaoProblema']);
    $chamado->setStatus($_POST['taStatusAtual']);
    $chamado->setNivelCriticidade($_POST['selectNivelCriticidade']);

    $chamado->setSolucaoProblema($_POST['taSolucaoProblema']);

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

if (isset($_GET['cancelar'])) {

    $chamado->setCodigo($_GET['codigoChamado']);
    $chamado->setResolvido(1);
    $chamado->setAtivo(0);

    ChamadoDAO::excluir($chamado);

    header("Location: ../chamados.php");
}

if (isset($_GET['confirmarExcluir'])) {
    
}

if (isset($_GET['cancelar'])) {

    $chamado->setCodigo($_GET['codigoChamado']);
//    $chamado->setResolvido(0);resolvido ou cancelado?
    $chamado->setAtivo(0);

    ChamadoDAO::cancelar($chamado);

    header("Location: ../chamados.php");
}

if (isset($_GET['pausar'])) {

    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);

    echo '<br><br><br><h3>Tem certeza que deseja pausar o chamado ' . $chamado->getCodigo() . ' ?</h3>'
    . '<br><hr><br>'
    . '<a href="../chamados.php">'
    . '<button>Cancelar</button></a> '
    . '<a href="?confirmarPausar&codigoChamado=' . $_GET['codigoChamado'] . '">'
    . '<button>Pausar</button></a>';
}

if (isset($_GET['confirmarPausar'])) {

    confirmarPausar();
}

if (isset($_GET['retomar'])) {

    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);

    echo '<br><br><br><h3>Tem certeza que deseja retomar o chamado ' . $chamado->getCodigo() . ' ?</h3>'
    . '<br><hr><br>'
    . '<a href="../chamados.php">'
    . '<button>Cancelar</button></a> '
    . '<a href="?confirmarRetomar&codigoChamado=' . $_GET['codigoChamado'] . '">'
    . '<button>Retomar</button></a>';
}

if (isset($_GET['confirmarRetomar'])) {

    confirmarRetomar();
}

function confirmarRetomar() {
    
    $chamado = new Chamado();

    $chamado->setCodigo($_GET['codigoChamado']);

    date_default_timezone_set('America/Sao_Paulo');

    $retomar = "";

//pra nao colocar o ultimo "retomar" com a mesma data/hora da "dataHoraEncerramento"
    if (!isset($_GET['confirmarEncerrar'])) {

        $chamado->setRetomar(date("Y-m-d H:i:s"));
        $retomar = $chamado->getRetomar();
    } else {

        $retomar = ChamadoDAO::getDataHoraEncerramento($chamado);
        $chamado->setDataHoraEncerramento($retomar);
    }

    $chamado->setPausado(0);
}

function confirmarPausar() {
    
    $chamado = new Chamado();

    $chamado->setCodigo($_GET['codigoChamado']);

    $retomar = ChamadoDAO::getRetomar($chamado);
    
    date_default_timezone_set('America/Sao_Paulo');
    
    $chamado->setPausar(date("Y-m-d H:i:s"));
    
    $pausar = $chamado->getPausar();
    
//removendo os : e -
    $pausar = str_replace(":", "", $pausar);
    $pausar = str_replace("-", "", $pausar);
    $retomar = str_replace(":", "", $retomar);
    $retomar = str_replace("-", "", $retomar);

    $anoPausar = intval(substr($pausar, 0, 3));
    $mesPausar = intval(substr($pausar, 4, 5));
    $diaPausar = intval(substr($pausar, 6, 7));

    $anoRetomar = intval(substr($retomar, 0, 3));
    $mesRetomar = intval(substr($retomar, 4, 5));
    $diaRetomar = intval(substr($retomar, 6, 7));

//    INDEX 8 É O ESPAÇO
//pegando somente o horario da string com data e hora
    $pausar = substr($pausar, 9);
    $retomar = substr($retomar, 9);

//transformando em int
    $horaPausar = intval(substr($pausar, 0, 2));
    $minutoPausar = intval(substr($pausar, 2, 2));
    $segundoPausar = intval(substr($pausar, 4, 4));

    $horaRetomar = intval(substr($retomar, 0, 2));
    $minutoRetomar = intval(substr($retomar, 2, 2));
    $segundoRetomar = intval(substr($retomar, 4, 4));

//----------------TESTES-------------------------------------
    $segundoPausar = 21;
    $segundoRetomar = 20;
//
    $minutoPausar = 25;
    $minutoRetomar = 17;
//
    $horaPausar = 20;
    $horaRetomar = 22;
//
//    $diaPausar = 23;
//    $diaRetomar = 26;
//
//    $mesPausar = 3;
//    $mesRetomar = 1;
//O ANO QUE PAUSAR NUNCA SERÁ MAIOR QUE O ANO QUE RETOMAR
//    $anoPausar = 2019;
//    $anoRetomar = 2021;
//----------------FIM-------------------------------------
//
    $segundosTotaisPausarRetomar = $segundoPausar - $segundoRetomar;
    $minutosTotaisPausarRetomar = $minutoPausar - $minutoRetomar;
    $horasTotaisPausarRetomar = $horaPausar - $horaRetomar;

    $diasTotaisPausarRetomar = $diaPausar - $diaRetomar;
    $mesesTotaisPausarRetomar = $mesPausar - $mesRetomar;
    $anosTotaisPausarRetomar = $anoPausar - $anoRetomar;

//verificando se hora, minuto ou segundo pausar/retomar forem iguais
    if ($horaPausar == $horaRetomar) {

        $horasTotaisPausarRetomar = 0;
    }

    if ($minutoPausar == $minutoRetomar) {

        $minutosTotaisPausarRetomar = 0;
    }

    if ($segundoPausar == $segundoRetomar) {

        $segundosTotaisPausarRetomar = 0;
    }

//verificando se ano, mes ou dia pausar/retomar forem iguais
    if ($anoPausar == $anoRetomar) {

        $anosTotaisPausarRetomar = 0;
    }

    if ($mesPausar == $mesRetomar) {

        $mesesTotaisPausarRetomar = 0;
    }

    if ($diaPausar == $diaRetomar) {

        $diasTotaisPausarRetomar = 0;
    }

//verificacoes para quando o segundo, minuto ou hora que pausou for maior
    if ($segundoRetomar > $segundoPausar) {

//- com - daria +
        $segundosTotaisPausarRetomar = 60 + $segundosTotaisPausarRetomar;
        $minutosTotaisPausarRetomar = $minutosTotaisPausarRetomar - 1;
    }

    if ($minutoRetomar > $minutoPausar) {

        $minutosTotaisPausarRetomar = 60 + $minutosTotaisPausarRetomar;
        $horasTotaisPausarRetomar = $horasTotaisPausarRetomar - 1;
    }

//o contador de dias smp irá contar os dias totais, por isso
//a verificacao de se a hr do dia em q pausou for maior, decrescentar 1
    if ($horaRetomar > $horaPausar) {

        $horasTotaisPausarRetomar = 24 + $horasTotaisPausarRetomar;
        $diasTotaisPausarRetomar = $diasTotaisPausarRetomar - 1;
    }

    if ($diaRetomar > $diaPausar) {

        $diasTotaisPausarRetomar = 30 + $diasTotaisPausarRetomar;
        $mesesTotaisPausarRetomar = $mesesTotaisPausarRetomar - 1;
    }

    if ($mesRetomar > $mesPausar) {

        $mesesTotaisPausarRetomar = 12 + $mesesTotaisPausarRetomar;
        $anosTotaisPausarRetomar = $anosTotaisPausarRetomar - 1;
    }

#VERIFICACAO MESES IMPARES/PARES DIA 31/30
#EXCECAO FEVEREIRO 28 DIAS

    $tempoTotalPausarRetomar = $anosTotaisPausarRetomar . "a "
            . $mesesTotaisPausarRetomar . "m " . $diasTotaisPausarRetomar . "d "
            . $horasTotaisPausarRetomar . "h " . $minutosTotaisPausarRetomar . "min "
            . $segundosTotaisPausarRetomar . "s";

    $tempoTotalAtual = ChamadoDAO::getTempoTotal($chamado);

    $indexAnoPausarRetomar = strpos($tempoTotalPausarRetomar, "a");
    $indexMesPausarRetomar = strpos($tempoTotalPausarRetomar, "m");
    $indexDiaPausarRetomar = strpos($tempoTotalPausarRetomar, "d");
    $indexHoraPausarRetomar = strpos($tempoTotalPausarRetomar, "h");
    $indexMinutoPausarRetomar = strpos($tempoTotalPausarRetomar, "min");
    $indexSegundoPausarRetomar = strpos($tempoTotalPausarRetomar, "s");
    
    $indexAnoAtual = strpos($tempoTotalAtual, "a");
    $indexMesAtual = strpos($tempoTotalAtual, "m");
    $indexDiaAtual = strpos($tempoTotalAtual, "d");
    $indexHoraAtual = strpos($tempoTotalAtual, "h");
    $indexMinutoAtual = strpos($tempoTotalAtual, "min");
    $indexSegundoAtual = strpos($tempoTotalAtual, "s");
    
    $anoTotalAtual = "";
    $mesTotalAtual = "";
    $diaTotalAtual = "";
    $horaTotalAtual = "";
    $minutoTotalAtual = "";
    $segundoTotalAtual = "";
    
    $anoTotalPausarRetomar = "";
    $mesTotalPausarRetomar = "";
    $diaTotalPausarRetomar = "";
    $horaTotalPausarRetomar = "";
    $minutoTotalPausarRetomar = "";
    $segundoTotalPausarRetomar = "";
    
//---------------------------tempoTotalAtual------------------------------------
    //VERIFICACOES DE ESPAÇOS NA STRING
    //pegando o ano do tempo em aberto até o momento do chamado
    if (strpos($tempoTotalAtual, $indexAnoAtual - 2) == " ") {
        
        $anoTotalAtual = substr($tempoTotalAtual, $indexAnoAtual - 1, $indexAnoAtual - 1);
        
    } else {
        
        $anoTotalAtual = substr($tempoTotalAtual, $indexAnoAtual - 2, $indexAnoAtual - 1);
    }
    
    if (strpos($tempoTotalAtual, $indexMesAtual - 2) == " ") {
        
        $mesTotalAtual = substr($tempoTotalAtual, $indexMesAtual - 1, $indexMesAtual - 1);
        
    } else {
        
        $mesTotalAtual = substr($tempoTotalAtual, $indexMesAtual - 2, $indexMesAtual - 1);
    }
    
    if (strpos($tempoTotalAtual, $indexDiaAtual - 2) == " ") {
        
        $diaTotalAtual = substr($tempoTotalAtual, $indexDiaAtual - 1, $indexDiaAtual - 1);
        
    } else {
        
        $diaTotalAtual = substr($tempoTotalAtual, $indexDiaAtual - 2, $indexDiaAtual - 1);
    }
    
    if (strpos($tempoTotalAtual, $indexHoraAtual - 2) == " ") {
        
        $horaTotalAtual = substr($tempoTotalAtual, $indexHoraAtual - 1, $indexHoraAtual - 1);
        
    } else {
        
        $horaTotalAtual = substr($tempoTotalAtual, $indexHoraAtual - 2, $indexHoraAtual - 1);
    }
    
    if (strpos($tempoTotalAtual, $indexMinutoAtual - 2) == " ") {
        
        $minutoTotalAtual = substr($tempoTotalAtual, $indexMinutoAtual - 1, $indexMinutoAtual - 1);
        
    } else {
        
        $minutoTotalAtual = substr($tempoTotalAtual, $indexMinutoAtual - 2, $indexMinutoAtual - 1);
    }
    
    if (strpos($tempoTotalAtual, $indexSegundoAtual - 2) == " ") {
        
        $segundoTotalAtual = substr($tempoTotalAtual, $indexSegundoAtual - 1, $indexSegundoAtual - 1);
        
    } else {
        
        $segundoTotalAtual = substr($tempoTotalAtual, $indexSegundoAtual - 2, $indexSegundoAtual - 1);
    }
    
//--------------------------------tempoTotalPausarRetomar-----------------------
    
    if (strpos($tempoTotalPausarRetomar, $indexAnoPausarRetomar - 2) == " ") {
        
        $anoTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexAnoPausarRetomar - 1, $indexAnoPausarRetomar - 1);
        
    } else {
        
        $anoTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexAnoPausarRetomar - 2, $indexAnoPausarRetomar - 1);
    }
    
    if (strpos($tempoTotalPausarRetomar, $indexMesPausarRetomar - 2) == " ") {
        
        $mesTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexMesPausarRetomar - 1, $indexMesPausarRetomar - 1);
        
    } else {
        
        $mesTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexMesPausarRetomar - 2, $indexMesPausarRetomar - 1);
    }
    
    if (strpos($tempoTotalPausarRetomar, $indexDiaPausarRetomar - 2) == " ") {
        
        $diaTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexDiaPausarRetomar - 1, $indexDiaPausarRetomar - 1);
        
    } else {
        
        $diaTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexDiaPausarRetomar - 2, $indexDiaPausarRetomar - 1);
    }
    
    if (strpos($tempoTotalPausarRetomar, $indexHoraPausarRetomar - 2) == " ") {
        
        $horaTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexHoraPausarRetomar - 1, $indexHoraPausarRetomar - 1);
        
    } else {
        
        $horaTotalPausarRetomar = substr($tempoTotalPausarRetomar, 
                $indexHoraPausarRetomar - 2, $indexHoraPausarRetomar - 1);
    }
    
    if (strpos($tempoTotalPausarRetomar, $indexMinutoPausarRetomar - 2) == " ") {
        
        $minutoTotalPausarRetomar = substr($tempoTotalPausarRetomar,
                $indexMinutoPausarRetomar - 1, $indexMinutoPausarRetomar - 1);
        
    } else {
        
        $minutoTotalPausarRetomar = substr($tempoTotalPausarRetomar,
                $indexMinutoPausarRetomar - 2, $indexMinutoPausarRetomar - 1);
    }
    
    if (strpos($tempoTotalPausarRetomar, $indexSegundoPausarRetomar - 2) == " ") {
        
        $segundoTotalPausarRetomar = substr($tempoTotalPausarRetomar,
                $indexSegundoPausarRetomar - 1, $indexSegundoPausarRetomar - 1);
        
    } else {
        
        $segundoTotalPausarRetomar = substr($tempoTotalPausarRetomar,
                $indexSegundoPausarRetomar - 2, $indexSegundoPausarRetomar - 1);
    }
    
    $segundosTotais = $segundoTotalPausarRetomar + $segundoTotalAtual;
    $minutosTotais = $minutoTotalPausarRetomar + $minutoTotalAtual;
    $horasTotais = $horaTotalPausarRetomar + $horaTotalAtual;
    
    $diasTotais = $diaTotalPausarRetomar + $diaTotalAtual;
    $mesesTotais = $mesTotalPausarRetomar + $mesTotalAtual;
    $anosTotais = $anoTotalPausarRetomar + $anoTotalAtual;
    
    if ($segundosTotais > 60) {
        
        $segundosTotais = $segundosTotais - 60;
        $minutosTotais = $minutosTotais + 1;
    }
    
    if ($minutosTotais > 60) {
        
        $minutosTotais = $minutosTotais - 60;
        $horasTotais = $horasTotais + 1;
    }
    
    if ($diasTotais > 30) {
        
        $diasTotais = $diasTotais - 30;
        $mesesTotais = $mesesTotais + 1;
    }
    
    if ($mesesTotais > 12) {
        
        $mesesTotais = $mesesTotais - 12;
        $anosTotais = $anosTotais + 1;
    }

    $chamado->setTempoTotal($anosTotais . "a " . $mesesTotais . "m "
            . $diasTotais . "d " . $horasTotais . "h "
            . $minutosTotais . "min " . $segundosTotais . "s");

    ChamadoDAO::retomar($chamado);

    header("Location: ../chamados.php");
}

if (isset($_GET['encerrar'])) {

    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);

    echo '<br><br><br><h3>Tem certeza que deseja encerrar o chamado '
    . $chamado->getCodigo() . ' ?</h3><br><hr><br>'
    . '<a href="../chamados.php"><button>Voltar</button></a>'
    . '<a href="?confirmarEncerrar&codigoChamado=' . $_GET['codigoChamado'] . '">'
    . '<button>Encerrar</button></a>';
}

if (isset($_GET['confirmarEncerrar'])) {

    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);

    date_default_timezone_set('America/Sao_Paulo');
    $chamado->setDataHoraEncerramento(date("Y-m-d H:i:s"));

    $chamado->setAtivo(0);

    ChamadoDAO::encerrar($chamado);

    confirmarRetomar();
}