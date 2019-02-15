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

    $chamado->setCodigo($_GET['codigoChamado']);

    date_default_timezone_set('America/Sao_Paulo');
    $chamado->setPausar(date("Y-m-d H:i:s"));
    $chamado->setPausado(1);
    
    $historicoPausar = ChamadoDAO::getHistoricoPausar($chamado);
    
    if ($historicoPausar == null) {
        
        $historicoPausar = $chamado->getPausar();
        
    } else {
        
        $historicoPausar = $historicoPausar . ", " . $chamado->getPausar();
        
    }
    
    $chamado->setHistoricoPausar($historicoPausar);

    ChamadoDAO::pausar($chamado);

    header("Location: ../chamados.php");
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
    if (isset($_GET['confirmarEncerrar'])) {

        $chamado->setDataHoraEncerramento(date("Y-m-d H:i:s"));
        
    } else {
    
    $retomarTeste = ChamadoDAO::getRetomar($chamado);
    $historicoTeste = ChamadoDAO::getHistoricoRetomar($chamado); 
    
//    if (strpos($historicoTeste, $retomarTeste) !== false) {
//        
////        nao executa nd
//        
//    } else {
        
    $chamado->setRetomar(date("Y-m-d H:i:s"));
    $retomar = $chamado->getRetomar();
    
    $historicoRetomar = ChamadoDAO::getHistoricoRetomar($chamado);
    
    if ($historicoRetomar == null) {
        
        $historicoRetomar = $chamado->getRetomar();
        
    } else {
        
        $historicoRetomar = $historicoRetomar . ", " . $chamado->getRetomar();
        
    }
    
    $chamado->setHistoricoRetomar($historicoRetomar);

    $chamado->setPausado(0);

//pegando o horario em que o chamado foi pausado
    $pausar = ChamadoDAO::getPausar($chamado);

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
//    $segundoPausar = 18;
//    $segundoRetomar = 15;
////
//    $minutoPausar = 28;
//    $minutoRetomar = 28;
////
//    $horaPausar = 20;
//    $horaRetomar = 20;
////
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
//total

    $segundosTotaisPausarRetomar = "";
    $minutosTotaisPausarRetomar = "";
    $horasTotaisPausarRetomar = "";
    $diasTotaisPausarRetomar = "";
    $mesesTotaisPausarRetomar = "";
    
    //se os segundos, minutos, horas, dias, meses ou anos forem iguais
    if ($segundoPausar - $segundoRetomar == 0) {
        
        if ($minutoPausar != $minutoRetomar
                || $minutoPausar == $minutoRetomar && $horaPausar != $horaRetomar
                || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar != $diaRetomar
                || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar
                || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $horaPausar != $horaRetomar 
                || $horaPausar == $horaRetomar && $diaPausar != $diaRetomar 
                || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar 
                || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $diaPausar != $diaRetomar 
                || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar 
                || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $mesPausar != $mesRetomar
                || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $anoPausar != $anoRetomar) {

            $segundosTotaisPausarRetomar = 60;
        }
    } else {
        $segundosTotaisPausarRetomar = $segundoRetomar - $segundoPausar;
    }
    
    
    if ($minutoPausar - $minutoRetomar == 0) {
        
        if ($horaPausar != $horaRetomar 
                || $horaPausar == $horaRetomar && $diaPausar != $diaRetomar 
                || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar 
                || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $diaPausar != $diaRetomar 
                || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar 
                || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $mesPausar != $mesRetomar
                || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $anoPausar != $anoRetomar) {
        
            $minutosTotaisPausarRetomar = 60;
        }
    } else {
        
        $minutosTotaisPausarRetomar = $minutoRetomar - $minutoPausar;
    }

    if ($horaPausar - $horaRetomar == 0) {

//        if ($diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar) {

        if ($diaPausar != $diaRetomar 
                || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar 
                || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $mesPausar != $mesRetomar
                || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $anoPausar != $anoRetomar) {
            
            $horasTotaisPausarRetomar = 24;
        }
    } else {

        $horasTotaisPausarRetomar = $horaRetomar - $horaPausar;
    }
    
    if ($diaPausar - $diaRetomar == 0) {
        
//        if ($mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

        if ($mesPausar != $mesRetomar
                || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar
                || $anoPausar != $anoRetomar) {
        
            $diasTotaisPausarRetomar = 30;
        }
    } else {
        
        $diasTotaisPausarRetomar = $diaRetomar - $diaPausar;
    }
    
    if ($mesPausar - $mesRetomar == 0) {
        
        if ($anoPausar != $anoRetomar) {

            $mesesTotaisPausarRetomar = 12;
        }
    } else {
        
        $mesesTotaisPausarRetomar = $mesRetomar - $mesPausar;
    }
    
//ano nao precisa dessa verificacao
    $anosTotaisPausarRetomar = $anoRetomar - $anoPausar;

//verificando se hora, minuto ou segundo pausar/retomar forem iguais
    if ($horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar == $anoRetomar) {

        $horasTotaisPausarRetomar = 0;
    }

    if ($minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar == $anoRetomar) {

        $minutosTotaisPausarRetomar = 0;
    }

    if ($segundoPausar == $segundoRetomar && $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar == $anoRetomar) {

        $segundosTotaisPausarRetomar = 0;
    }

//verificando se ano, mes ou dia pausar/retomar forem iguais
    if ($anoPausar == $anoRetomar) {

        $anosTotaisPausarRetomar = 0;
    }

    if ($mesPausar == $mesRetomar && $anoPausar == $anoRetomar) {

        $mesesTotaisPausarRetomar = 0;
    }

    if ($diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar == $anoRetomar) {

        $diasTotaisPausarRetomar = 0;
    }

//---verificacoes para quando o segundo, minuto ou hora que pausou for maior----
//o contador smp irá contar os totais, por isso a verificacao o contador em que
//pausar for maior que quando retomar, decrescentar 1
    if ($segundoPausar > $segundoRetomar) {

        
        //PROBLEMA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//- com - daria +
        $segundosTotaisPausarRetomar = 60 + $segundosTotaisPausarRetomar;
        
        if ($minutoPausar - $minutoRetomar == 0) {
            
            $minutosTotaisPausarRetomar = 0;
            
        } else {
            
            $minutosTotaisPausarRetomar = $minutosTotaisPausarRetomar - 1;
            
        }
        
    }

    if ($minutoPausar > $minutoRetomar) {

        $minutosTotaisPausarRetomar = 60 + $minutosTotaisPausarRetomar;
        
        if ($horaPausar - $horaRetomar == 0) {
            
            $horasTotaisPausarRetomar = 0;
            
        } else {
            
            $horasTotaisPausarRetomar = $horasTotaisPausarRetomar - 1;
            
        }
        
    }

    if ($horaPausar > $horaRetomar) {

        $horasTotaisPausarRetomar = 24 + $horasTotaisPausarRetomar;
        
        if ($diaPausar - $diaRetomar == 0) {
            
            $diasTotaisPausarRetomar = 0;
            
        } else {
            
            $diasTotaisPausarRetomar = $diasTotaisPausarRetomar - 1;
            
        }
    }

    if ($diaPausar > $diaRetomar) {

        $diasTotaisPausarRetomar = 30 + $diasTotaisPausarRetomar;
        
        if ($mesPausar - $mesRetomar == 0) {
            
            $mesesTotaisPausarRetomar = 0;
            
        } else {
            
            $mesesTotaisPausarRetomar = $mesesTotaisPausarRetomar - 1;
            
        }
    }

    if ($mesPausar > $mesRetomar) {

        $mesesTotaisPausarRetomar = 12 + $mesesTotaisPausarRetomar;
        $anosTotaisPausarRetomar = $anosTotaisPausarRetomar - 1;
    }
    
//--se as horas forem iguais mas nao der 24hrs por causa dos minutos e segundos--
//    if ($horaPausar - $horaRetomar == 0) {
//        
//        if ($minutoPausar > $minutoRetomar || $segundoPausar > $segundoRetomar) {
//            $diasTotaisPausarRetomar = $diasTotaisPausarRetomar - 1;
//        }
//    }
    
    if ($segundosTotaisPausarRetomar == 60) {
        
//        $minutosTotaisPausarRetomar = $minutosTotaisPausarRetomar + 1;
        $segundosTotaisPausarRetomar = 0;
    }
    
    if ($minutosTotaisPausarRetomar == 60) {
        
//        $horasTotaisPausarRetomar = $horasTotaisPausarRetomar + 1;
        $minutosTotaisPausarRetomar = 0;
    }
    
    if ($horasTotaisPausarRetomar == 24) {
        
        if ($minutoPausar > $minutoRetomar || $segundoPausar > $segundoRetomar) {
            
            $horasTotaisPausarRetomar = $horasTotaisPausarRetomar - 1;

        } else {
            
            $horasTotaisPausarRetomar = 0;

        }
    }
    
    if ($diasTotaisPausarRetomar == 30) {
        
//        $mesesTotaisPausarRetomar = $mesesTotaisPausarRetomar + 1;
        $diasTotaisPausarRetomar = 0;
    }
    
    if ($mesesTotaisPausarRetomar == 12) {
        
//        $anosTotaisPausarRetomar = $anosTotaisPausarRetomar + 1;
        $mesesTotaisPausarRetomar = 0;
    }
    
#VERIFICACAO MESES IMPARES/PARES DIA 31/30
#EXCECAO FEVEREIRO 28 DIAS

    $tempoTotalPausarRetomar = $anosTotaisPausarRetomar . "a "
            . $mesesTotaisPausarRetomar . "m " . $diasTotaisPausarRetomar . "d "
            . $horasTotaisPausarRetomar . "h " . $minutosTotaisPausarRetomar . "min "
            . $segundosTotaisPausarRetomar . "s";

    $tempoTotalAtual = ChamadoDAO::getTempoPausado($chamado);
    
    $getRetomar = ChamadoDAO::getRetomar($chamado);

    //verificacao pro primeiro pausar/retomar
    if ($getRetomar == null) {

        $chamado->setTempoPausado($tempoTotalPausarRetomar);
    } else {

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

        $anoTotalPausarRetomar = "";
        $mesTotalPausarRetomar = "";
        $diaTotalPausarRetomar = "";
        $horaTotalPausarRetomar = "";
        $minutoTotalPausarRetomar = "";
        $segundoTotalPausarRetomar = "";

        $anoTotalAtual = "";
        $mesTotalAtual = "";
        $diaTotalAtual = "";
        $horaTotalAtual = "";
        $minutoTotalAtual = "";
        $segundoTotalAtual = "";

        //VERIFICACOES DE ESPAÇOS NA STRING
        //pegando o ano do tempo em aberto até o momento do chamado
//---------------------------------tempoTotalAtual------------------------------    
        if (strpos($tempoTotalAtual, $indexAnoAtual - 2) == " ") {

            $anoTotalAtual = intval(substr($tempoTotalAtual, $indexAnoAtual - 1, $indexAnoAtual - 1));
        } else {

            $anoTotalAtual = intval(substr($tempoTotalAtual, $indexAnoAtual - 2, $indexAnoAtual - 1));
        }

        //pegando o mes do tempo em aberto até o momento do chamado
        if (strpos($tempoTotalAtual, $indexMesAtual - 2) == " ") {

            $mesTotalAtual = intval(substr($tempoTotalAtual, $indexMesAtual - 1, $indexMesAtual - 1));
        } else {

            $mesTotalAtual = intval(substr($tempoTotalAtual, $indexMesAtual - 2, $indexMesAtual - 1));
        }

        if (strpos($tempoTotalAtual, $indexDiaAtual - 2) == " ") {

            $diaTotalAtual = intval(substr($tempoTotalAtual, $indexDiaAtual - 1, $indexDiaAtual - 1));
        } else {

            $diaTotalAtual = intval(substr($tempoTotalAtual, $indexDiaAtual - 2, $indexDiaAtual - 1));
        }

        if (strpos($tempoTotalAtual, $indexHoraAtual - 2) == " ") {

            $horaTotalAtual = intval(substr($tempoTotalAtual, $indexHoraAtual - 1, $indexHoraAtual - 1));
        } else {

            $horaTotalAtual = intval(substr($tempoTotalAtual, $indexHoraAtual - 2, $indexHoraAtual - 1));
        }

        if (strpos($tempoTotalAtual, $indexMinutoAtual - 2) == " ") {

            $minutoTotalAtual = intval(substr($tempoTotalAtual, $indexMinutoAtual - 1, $indexMinutoAtual - 1));
        } else {

            $minutoTotalAtual = intval(substr($tempoTotalAtual, $indexMinutoAtual - 2, $indexMinutoAtual - 1));
        }

        if (strpos($tempoTotalAtual, $indexSegundoAtual - 2) == " ") {

            $segundoTotalAtual = intval(substr($tempoTotalAtual, $indexSegundoAtual - 1, $indexSegundoAtual - 1));
        } else {

            $segundoTotalAtual = intval(substr($tempoTotalAtual, $indexSegundoAtual - 2, $indexSegundoAtual - 1));
        }

//----------------------------------tempoTotalPausarRetomar---------------------
        if (strpos($tempoTotalPausarRetomar, $indexAnoPausarRetomar - 2) == " ") {

            $anoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexAnoPausarRetomar - 1, $indexAnoPausarRetomar - 1));
        } else {

            $anoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexAnoPausarRetomar - 2, $indexAnoPausarRetomar - 1));
        }

        //pegando o mes do tempo em aberto até o momento do chamado
        if (strpos($tempoTotalPausarRetomar, $indexMesPausarRetomar - 2) == " ") {

            $mesTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexMesPausarRetomar - 1, $indexMesPausarRetomar - 1));
        } else {

            $mesTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexMesPausarRetomar - 2, $indexMesPausarRetomar - 1));
        }

        if (strpos($tempoTotalPausarRetomar, $indexDiaPausarRetomar - 2) == " ") {

            $diaTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexDiaPausarRetomar - 1, $indexDiaPausarRetomar - 1));
        } else {

            $diaTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexDiaPausarRetomar - 2, $indexDiaPausarRetomar - 1));
        }

        if (strpos($tempoTotalPausarRetomar, $indexHoraPausarRetomar - 2) == " ") {

            $horaTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexHoraPausarRetomar - 1, $indexHoraPausarRetomar - 1));
        } else {

            $horaTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexHoraPausarRetomar - 2, $indexHoraPausarRetomar - 1));
        }

        if (strpos($tempoTotalPausarRetomar, $indexMinutoPausarRetomar - 2) == " ") {

            $minutoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexMinutoPausarRetomar - 1, $indexMinutoPausarRetomar - 1));
        } else {

            $minutoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexMinutoPausarRetomar - 2, $indexMinutoPausarRetomar - 1));
        }

        if (strpos($tempoTotalPausarRetomar, $indexSegundoPausarRetomar - 2) == " ") {

            $segundoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexSegundoPausarRetomar - 1, $indexSegundoPausarRetomar - 1));
        } else {

            $segundoTotalPausarRetomar = intval(substr($tempoTotalPausarRetomar, $indexSegundoPausarRetomar - 2, $indexSegundoPausarRetomar - 1));
        }

        $segundosTotais = $segundoTotalAtual + $segundoTotalPausarRetomar;
        $minutosTotais = $minutoTotalAtual + $minutoTotalPausarRetomar;
        $horasTotais = $horaTotalAtual + $horaTotalPausarRetomar;

        $diasTotais = $diaTotalAtual + $diaTotalPausarRetomar;
        $mesesTotais = $mesTotalAtual + $mesTotalPausarRetomar;
        $anosTotais = $anoTotalAtual + $anoTotalPausarRetomar;

        if ($segundosTotais > 60) {

            $segundosTotais = 60 - $segundosTotais;
            $minutosTotais = $minutosTotais + 1;
        }

        if ($minutosTotais > 60) {

            $minutosTotais = 60 - $minutosTotais;
            $horasTotais = $horasTotais + 1;
        }

        if ($horasTotais > 24) {

            $horasTotais = 24 - $horasTotais;
            $diasTotais = $diasTotais + 1;
        }

        if ($mesesTotais > 12) {

            $mesesTotais = 12 - $mesesTotais;
            $anosTotais = $anosTotais + 1;
        }

        $tempoPausado = $anosTotais . "a " . $mesesTotais . "m "
                . $diasTotais . "d " . $horasTotais . "h "
                . $minutosTotais . "min " . $segundosTotais . "s";
        
        $chamado->setTempoPausado($tempoPausado);
    }
    
}
    
    
    
    
    if (isset($_GET['confirmarEncerrar'])) {
        
        $dataHoraAbertura = ChamadoDAO::getDataHoraAbertura($chamado);
        $dataHoraEncerramento = ChamadoDAO::getDataHoraEncerramento($chamado);
        
        $dataHoraAbertura = str_replace(":", "", $dataHoraAbertura);
        $dataHoraAbertura = str_replace("-", "", $dataHoraAbertura);
        $dataHoraEncerramento = str_replace(":", "", $dataHoraEncerramento);
        $dataHoraEncerramento = str_replace("-", "", $dataHoraEncerramento);
        
        $anoAbertura = intval(substr($dataHoraAbertura, 0, 3));
        $mesAbertura = intval(substr($dataHoraAbertura, 4, 5));
        $diaAbertura = intval(substr($dataHoraAbertura, 6, 7));
        
        $anoEncerramento = intval(substr($dataHoraEncerramento, 0, 3));
        $mesEncerramento = intval(substr($dataHoraEncerramento, 4, 5));
        $diaEncerramento = intval(substr($dataHoraEncerramento, 6, 7));
        
        $horarioAbertura = substr($dataHoraAbertura, 9);
        $horarioEncerramento = substr($dataHoraEncerramento, 9);
        
        $horaAbertura = intval(substr($horarioAbertura, 0, 2));
        $minutoAbertura = intval(substr($horarioAbertura, 2, 2));
        $segundoAbertura = intval(substr($horarioAbertura, 4, 4));
        
        $horaEncerramento = intval(substr($horarioEncerramento, 0, 2));
        $minutoEncerramento = intval(substr($horarioEncerramento, 2, 2));
        $segundoEncerramento = intval(substr($horarioEncerramento, 4, 4));
        
//        KKKKKKKKKK

    $segundosTotaisAberturaEncerramento = "";
    $minutosTotaisAberturaEncerramento  = "";
    $horasTotaisAberturaEncerramento  = "";
    $diasTotaisAberturaEncerramento  = "";
    $mesesTotaisAberturaEncerramento  = "";
    
    //se os segundos, minutos, horas, dias, meses ou anos forem iguais
    if ($segundoAbertura - $segundoEncerramento == 0) {
        
        if ($minutoAbertura != $minutoEncerramento
                || $minutoAbertura == $minutoEncerramento && $horaAbertura != $horaEncerramento
                || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento
                || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento
                || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $horaAbertura != $horaEncerramento
                || $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento
                || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento 
                || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $diaAbertura != $diaEncerramento 
                || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento
                || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $mesAbertura != $mesEncerramento
                || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $anoAbertura != $anoEncerramento) {

            $segundosTotaisAberturaEncerramento = 60;
        }
    } else {
        $segundosTotaisAberturaEncerramento = $segundoEncerramento - $segundoAbertura;
    }
    
    
    if ($minutoAbertura - $minutoEncerramento == 0) {
        
        if ($horaAbertura != $horaEncerramento 
                || $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento
                || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento 
                || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $diaAbertura != $diaEncerramento 
                || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento 
                || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $mesAbertura != $mesEncerramento
                || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $anoAbertura != $anoEncerramento) {
        
            $minutosTotaisAberturaEncerramento = 60;
        }
    } else {
        
        $minutosTotaisAberturaEncerramento = $minutoEncerramento - $minutoAbertura;
    }

    if ($horaAbertura - $horaEncerramento == 0) {

//        if ($diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar) {

        if ($diaAbertura != $diaEncerramento 
                || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento 
                || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $mesAbertura != $mesEncerramento
                || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $anoAbertura != $anoEncerramento) {
            
            $horasTotaisAberturaEncerramento = 24;
        }
    } else {

        $horasTotaisAberturaEncerramento = $horaEncerramento - $horaAbertura;
    }
    
    if ($diaAbertura - $diaEncerramento == 0) {
        
//        if ($mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

        if ($mesAbertura != $mesEncerramento
                || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento
                || $anoAbertura != $anoEncerramento) {
        
            $diasTotaisAberturaEncerramento = 30;
        }
    } else {
        
        $diasTotaisAberturaEncerramento = $diaEncerramento - $diaAbertura;
    }
    
    if ($mesAbertura - $mesEncerramento == 0) {
        
        if ($anoAbertura != $anoEncerramento) {

            $mesesTotaisAberturaEncerramento = 12;
        }
    } else {
        
        $mesesTotaisAberturaEncerramento = $mesEncerramento - $mesAbertura;
    }
    
    $anosTotaisAberturaEncerramento = $anoEncerramento - $anoAbertura;

    if ($horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura == $anoEncerramento) {

        $horasTotaisAberturaEncerramento = 0;
    }

    if ($minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura == $anoEncerramento) {

        $minutosTotaisAberturaEncerramento = 0;
    }

    if ($segundoAbertura == $segundoEncerramento && $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura == $anoEncerramento) {

        $segundosTotaisAberturaEncerramento = 0;
    }

    if ($anoAbertura == $anoEncerramento) {

        $anosTotaisAberturaEncerramento = 0;
    }

    if ($mesAbertura == $mesEncerramento && $anoAbertura == $anoEncerramento) {

        $mesesTotaisAberturaEncerramento = 0;
    }

    if ($diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura == $anoEncerramento) {

        $diasTotaisAberturaEncerramento = 0;
    }

    if ($segundoAbertura > $segundoEncerramento) {

        $segundosTotaisAberturaEncerramento = 60 + $segundosTotaisAberturaEncerramento;
        
        if ($minutoAbertura - $minutoEncerramento == 0) {
            
            $minutosTotaisAberturaEncerramento = 0;
            
        } else {
            
            $minutosTotaisAberturaEncerramento = $minutosTotaisAberturaEncerramento - 1;
            
        }
        
    }

    if ($minutoAbertura > $minutoEncerramento) {

        $minutosTotaisAberturaEncerramento = 60 + $minutosTotaisAberturaEncerramento;
        
        if ($horaAbertura - $horaEncerramento == 0) {
            
            $horasTotaisAberturaEncerramento = 0;
            
        } else {
            
            $horasTotaisAberturaEncerramento = $horasTotaisAberturaEncerramento - 1;
            
        }
        
    }

    if ($horaAbertura > $horaEncerramento) {

        $horasTotaisAberturaEncerramento = 24 + $horasTotaisAberturaEncerramento;
        
        if ($diaAbertura - $diaEncerramento == 0) {
            
            $diasTotaisAberturaEncerramento = 0;
            
        } else {
            
            $diasTotaisAberturaEncerramento = $diasTotaisAberturaEncerramento - 1;
            
        }
    }

    if ($diaAbertura > $diaEncerramento) {

        $diasTotaisAberturaEncerramento = 30 + $diasTotaisAberturaEncerramento;
        
        if ($mesAbertura - $mesEncerramento == 0) {
            
            $mesesTotaisAberturaEncerramento = 0;
            
        } else {
            
            $mesesTotaisAberturaEncerramento = $mesesTotaisAberturaEncerramento - 1;
            
        }
    }

    if ($mesAbertura > $mesEncerramento) {

        $mesesTotaisAberturaEncerramento = 12 + $mesesTotaisAberturaEncerramento;
        $anosTotaisAberturaEncerramento = $anosTotaisAberturaEncerramento - 1;
    }
    
    if ($segundosTotaisAberturaEncerramento == 60) {
        
        $segundosTotaisAberturaEncerramento = 0;
    }
    
    if ($minutosTotaisAberturaEncerramento == 60) {
        
        $minutosTotaisAberturaEncerramento = 0;
    }
    
    if ($horasTotaisAberturaEncerramento == 24) {
        
        if ($minutoAbertura > $minutoEncerramento || $segundoAbertura > $segundoEncerramento) {
            
            $horasTotaisAberturaEncerramento = $horasTotaisAberturaEncerramento - 1;

        } else {
            
            $horasTotaisAberturaEncerramento = 0;

        }
    }
    
    if ($diasTotaisAberturaEncerramento == 30) {
        
        $diasTotaisAberturaEncerramento = 0;
    }
    
    if ($mesesTotaisAberturaEncerramento == 12) {
        
        $mesesTotaisAberturaEncerramento = 0;
    }
 
        if ($segundosTotaisAberturaEncerramento > 60) {

            $segundosTotaisAberturaEncerramento = 60 - $segundosTotaisAberturaEncerramento;
            $minutosTotaisAberturaEncerramento = $minutosTotaisAberturaEncerramento + 1;
        }

        if ($minutosTotaisAberturaEncerramento > 60) {

            $minutosTotaisAberturaEncerramento = 60 - $minutosTotaisAberturaEncerramento;
            $horasTotaisAberturaEncerramento = $horasTotaisAberturaEncerramento + 1;
        }

        if ($horasTotaisAberturaEncerramento > 24) {

            $horasTotaisAberturaEncerramento = 24 - $horasTotaisAberturaEncerramento;
            $diasTotaisAberturaEncerramento = $diasTotaisAberturaEncerramento + 1;
        }

        if ($mesesTotaisAberturaEncerramento > 12) {

            $mesesTotaisAberturaEncerramento = 12 - $mesesTotaisAberturaEncerramento;
            $anosTotaisAberturaEncerramento = $anosTotaisAberturaEncerramento + 1;
        }
    
        $tempoTotalAberturaEncerramento =  $anosTotaisAberturaEncerramento . "a "
                . $mesesTotaisAberturaEncerramento . "m "
                .  $diasTotaisAberturaEncerramento . "d "
                . $horasTotaisAberturaEncerramento . "h "
                . $minutosTotaisAberturaEncerramento . "min "
                . $segundosTotaisAberturaEncerramento . "s";
        
//        ---------------------------------------------------------------------
        
        $tempoTotalPausado = ChamadoDAO::getTempoPausado($chamado);
        
        $indexAnoAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "a");
        $indexMesAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "m");
        $indexDiaAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "d");
        $indexHoraAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "h");
        $indexMinutoAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "min");
        $indexSegundoAberturaEncerramento = strpos($tempoTotalAberturaEncerramento, "s");

        $indexAnoPausado = strpos($tempoTotalPausado, "a");
        $indexMesPausado = strpos($tempoTotalPausado, "m");
        $indexDiaPausado = strpos($tempoTotalPausado, "d");
        $indexHoraPausado = strpos($tempoTotalPausado, "h");
        $indexMinutoPausado = strpos($tempoTotalPausado, "min");
        $indexSegundoPausado = strpos($tempoTotalPausado, "s");

        $anoTotalAberturaEncerramento = "";
        $mesTotalAberturaEncerramento = "";
        $diaTotalAberturaEncerramento = "";
        $horaTotalAberturaEncerramento = "";
        $minutoTotalAberturaEncerramento = "";
        $segundoTotalAberturaEncerramento = "";

        $anoTotalPausado = "";
        $mesTotalPausado = "";
        $diaTotalPausado = "";
        $horaTotalPausado = "";
        $minutoTotalPausado = "";
        $segundoTotalPausado = "";
        
//        ahdaUHD
        if (strpos($tempoTotalAberturaEncerramento, $indexAnoAberturaEncerramento - 2) == " ") {

            $anoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexAnoAberturaEncerramento - 1, $indexAnoAberturaEncerramento - 1));
        } else {

            $anoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexAnoAberturaEncerramento - 2, $indexAnoAberturaEncerramento - 1));
        }

        if (strpos($tempoTotalAberturaEncerramento, $indexMesAberturaEncerramento - 2) == " ") {

            $mesTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexMesAberturaEncerramento - 1, $indexMesAberturaEncerramento - 1));
        } else {

            $mesTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexMesAberturaEncerramento - 2, $indexMesAberturaEncerramento - 1));
        }

        if (strpos($tempoTotalAberturaEncerramento, $indexDiaAberturaEncerramento - 2) == " ") {

            $diaTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexDiaAberturaEncerramento - 1, $indexDiaAberturaEncerramento - 1));
        } else {

            $diaTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexDiaAberturaEncerramento - 2, $indexDiaAberturaEncerramento - 1));
        }

        if (strpos($tempoTotalAberturaEncerramento, $indexHoraAberturaEncerramento - 2) == " ") {

            $horaTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexHoraAberturaEncerramento - 1, $indexHoraAberturaEncerramento - 1));
        } else {

            $horaTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexHoraAberturaEncerramento - 2, $indexHoraAberturaEncerramento - 1));
        }

        if (strpos($tempoTotalAberturaEncerramento, $indexMinutoAberturaEncerramento - 2) == " ") {

            $minutoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexMinutoAberturaEncerramento - 1, $indexMinutoAberturaEncerramento - 1));
        } else {

            $minutoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexMinutoAberturaEncerramento - 2, $indexMinutoAberturaEncerramento - 1));
        }

        if (strpos($tempoTotalAberturaEncerramento, $indexSegundoAberturaEncerramento - 2) == " ") {

            $segundoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexSegundoAberturaEncerramento - 1, $indexSegundoAberturaEncerramento - 1));
        } else {

            $segundoTotalAberturaEncerramento = intval(substr($tempoTotalAberturaEncerramento, $indexSegundoAberturaEncerramento - 2, $indexSegundoAberturaEncerramento - 1));
        }
//        jasdijdaiojfi
        
        if (strpos($tempoTotalPausado, $indexAnoPausado - 2) == " ") {

            $anoTotalPausado = intval(substr($tempoTotalPausado, $indexAnoPausado - 1, $indexAnoPausado - 1));
        } else {

            $anoTotalPausado = intval(substr($tempoTotalPausado, $indexAnoPausado - 2, $indexAnoPausado - 1));
        }

        if (strpos($tempoTotalPausado, $indexMesPausado - 2) == " ") {

            $mesTotalPausado = intval(substr($tempoTotalPausado, $indexMesPausado - 1, $indexMesPausado - 1));
        } else {

            $mesTotalPausado = intval(substr($tempoTotalPausado, $indexMesPausado - 2, $indexMesPausado - 1));
        }

        if (strpos($tempoTotalPausado, $indexDiaPausado - 2) == " ") {

            $diaTotalPausado = intval(substr($tempoTotalPausado, $indexDiaPausado - 1, $indexDiaPausado - 1));
        } else {

            $diaTotalPausado = intval(substr($tempoTotalPausado, $indexDiaPausado - 2, $indexDiaPausado - 1));
        }

        if (strpos($tempoTotalPausado, $indexHoraPausado - 2) == " ") {

            $horaTotalPausado = intval(substr($tempoTotalPausado, $indexHoraPausado - 1, $indexHoraPausado - 1));
        } else {

            $horaTotalPausado = intval(substr($tempoTotalPausado, $indexHoraPausado - 2, $indexHoraPausado - 1));
        }

        if (strpos($tempoTotalPausado, $indexMinutoPausado - 2) == " ") {

            $minutoTotalPausado = intval(substr($tempoTotalPausado, $indexMinutoPausado - 1, $indexMinutoPausado - 1));
        } else {

            $minutoTotalPausado = intval(substr($tempoTotalPausado, $indexMinutoPausado - 2, $indexMinutoPausado - 1));
        }

        if (strpos($tempoTotalPausado, $indexSegundoPausado - 2) == " ") {

            $segundoTotalPausado = intval(substr($tempoTotalPausado, $indexSegundoPausado - 1, $indexSegundoPausado - 1));
        } else {

            $segundoTotalPausado = intval(substr($tempoTotalPausado, $indexSegundoPausado - 2, $indexSegundoPausado - 1));
        }
//        ajdjIOJDJI
        $segundosTotaisPausadoAberturaEncerramento = $segundoTotalAberturaEncerramento + $segundoTotalPausado;
        $minutosTotaisPausadoAberturaEncerramento = $minutoTotalAberturaEncerramento + $minutoTotalPausado;
        $horasTotaisPausadoAberturaEncerramento = $horaTotalAberturaEncerramento + $horaTotalPausado;

        $diasTotaisPausadoAberturaEncerramento = $diaTotalAberturaEncerramento + $diaTotalPausado;
        $mesesTotaisPausadoAberturaEncerramento = $mesTotalAberturaEncerramento + $mesTotalPausado;
        $anosTotaisPausadoAberturaEncerramento = $anoTotalAberturaEncerramento + $anoTotalPausado;

        if ($segundosTotaisPausadoAberturaEncerramento > 60) {

            $segundosTotaisPausadoAberturaEncerramento = 60 - $segundosTotaisPausadoAberturaEncerramento;
            $minutosTotaisPausadoAberturaEncerramento = $minutosTotaisPausadoAberturaEncerramento + 1;
        }

        if ($minutosTotaisPausadoAberturaEncerramento > 60) {

            $minutosTotaisPausadoAberturaEncerramento = 60 - $minutosTotaisPausadoAberturaEncerramento;
            $horasTotaisPausadoAberturaEncerramento = $horasTotaisPausadoAberturaEncerramento + 1;
        }

        if ($horasTotaisPausadoAberturaEncerramento > 24) {

            $horasTotaisPausadoAberturaEncerramento = 24 - $horasTotaisPausadoAberturaEncerramento;
            $diasTotaisPausadoAberturaEncerramento = $diasTotaisPausadoAberturaEncerramento + 1;
        }

        if ($mesesTotaisPausadoAberturaEncerramento > 12) {

            $mesesTotaisPausadoAberturaEncerramento = 12 - $mesesTotaisPausadoAberturaEncerramento;
            $anosTotaisPausadoAberturaEncerramento = $anosTotaisPausadoAberturaEncerramento + 1;
        }
        
        $tempoTotal = $anosTotaisPausadoAberturaEncerramento . "a "
                . $mesesTotaisPausadoAberturaEncerramento . "m "
                . $diasTotaisPausadoAberturaEncerramento . "d "
                . $horasTotaisPausadoAberturaEncerramento . "h "
                . $minutosTotaisPausadoAberturaEncerramento . "min "
                . $segundosTotaisPausadoAberturaEncerramento . "s";
        
        $chamado->setTempoTotal($tempoTotal);
        
    } else {
        
        $chamado->setTempoTotal(null);
        
    }

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