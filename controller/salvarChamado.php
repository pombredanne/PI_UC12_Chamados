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
    
    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);
    
    echo '<br><br><br><h3>Tem certeza que deseja cancelar o chamado ' . $chamado->getCodigo() . ' ?</h3>'
    . '<br><hr><br>'
    . '<a href="../chamados.php">'
    . '<button>Voltar</button></a> '
    . '<a href="?confirmarCancelar&codigoChamado=' . $_GET['codigoChamado'] . '">'
    . '<button>Cancelar</button></a>';
    
}

if (isset($_GET['confirmarCancelar'])) {

    $chamado->setCodigo($_GET['codigoChamado']);
    
    $chamado->setResolvido("Cancelado por " . $_SESSION['nomeUsuario']);
    
    $chamado->setAtivo(0);

    ChamadoDAO::cancelar($chamado);

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

    $dataHoraAbertura = ChamadoDAO::getDataHoraAbertura($chamado);
    $dataHoraEncerramento = $chamado->getDataHoraEncerramento();

    $dataHoraAbertura = str_replace(":", "", $dataHoraAbertura);
    $dataHoraAbertura = str_replace("-", "", $dataHoraAbertura);
    $dataHoraEncerramento = str_replace(":", "", $dataHoraEncerramento);
    $dataHoraEncerramento = str_replace("-", "", $dataHoraEncerramento);

    $anoAbertura = intval(substr($dataHoraAbertura, 0, 4));
    $mesAbertura = intval(substr($dataHoraAbertura, 4, 2));
    $diaAbertura = intval(substr($dataHoraAbertura, 6, 8));

    $anoEncerramento = intval(substr($dataHoraEncerramento, 0, 4));
    $mesEncerramento = intval(substr($dataHoraEncerramento, 4, 2));
    $diaEncerramento = intval(substr($dataHoraEncerramento, 6, 8));

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
    $minutosTotaisAberturaEncerramento = "";
    $horasTotaisAberturaEncerramento = "";
    $diasTotaisAberturaEncerramento = "";
    $mesesTotaisAberturaEncerramento = "";

    //se os segundos, minutos, horas, dias, meses ou anos forem iguais
    if ($segundoAbertura - $segundoEncerramento == 0) {

        if ($minutoAbertura != $minutoEncerramento || $minutoAbertura == $minutoEncerramento && $horaAbertura != $horaEncerramento || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $minutoAbertura == $minutoEncerramento && $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $horaAbertura != $horaEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $diaAbertura != $diaEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $mesAbertura != $mesEncerramento || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $anoAbertura != $anoEncerramento) {

            $segundosTotaisAberturaEncerramento = 60;
        }
    } else {
        $segundosTotaisAberturaEncerramento = $segundoEncerramento - $segundoAbertura;
    }


    if ($minutoAbertura - $minutoEncerramento == 0) {

        if ($horaAbertura != $horaEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura != $diaEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $horaAbertura == $horaEncerramento && $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $diaAbertura != $diaEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $mesAbertura != $mesEncerramento || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $anoAbertura != $anoEncerramento) {

            $minutosTotaisAberturaEncerramento = 60;
        }
    } else {

        $minutosTotaisAberturaEncerramento = $minutoEncerramento - $minutoAbertura;
    }

    if ($horaAbertura - $horaEncerramento == 0) {

//        if ($diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar) {

        if ($diaAbertura != $diaEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura != $mesEncerramento || $diaAbertura == $diaEncerramento && $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $mesAbertura != $mesEncerramento || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $anoAbertura != $anoEncerramento) {

            $horasTotaisAberturaEncerramento = 24;
        }
    } else {

        $horasTotaisAberturaEncerramento = $horaEncerramento - $horaAbertura;
    }

    if ($diaAbertura - $diaEncerramento == 0) {

//        if ($mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

        if ($mesAbertura != $mesEncerramento || $mesAbertura == $mesEncerramento && $anoAbertura != $anoEncerramento || $anoAbertura != $anoEncerramento) {

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

    $tempoTotalAberturaEncerramento = $anosTotaisAberturaEncerramento . "a "
            . $mesesTotaisAberturaEncerramento . "m "
            . $diasTotaisAberturaEncerramento . "d "
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
    
    $minutoTotalAberturaEncerramento = 19;
    $segundoTotalAberturaEncerramento = 2;
    
    $minutoTotalPausado = 18;
    $segundoTotalPausado = 49;
    
    $segundosTotaisPausadoAberturaEncerramento = $segundoTotalAberturaEncerramento - $segundoTotalPausado;
    $minutosTotaisPausadoAberturaEncerramento = $minutoTotalAberturaEncerramento - $minutoTotalPausado;
    $horasTotaisPausadoAberturaEncerramento = $horaTotalAberturaEncerramento - $horaTotalPausado;

    $diasTotaisPausadoAberturaEncerramento = $diaTotalAberturaEncerramento - $diaTotalPausado;
    $mesesTotaisPausadoAberturaEncerramento = $mesTotalAberturaEncerramento - $mesTotalPausado;
    $anosTotaisPausadoAberturaEncerramento = $anoTotalAberturaEncerramento - $anoTotalPausado;
    
    if ($segundosTotaisPausadoAberturaEncerramento < 0) {
        
        $segundosTotaisPausadoAberturaEncerramento = 60 + $segundoTotalAberturaEncerramento - $segundoTotalPausado ;
        $minutosTotaisPausadoAberturaEncerramento = $minutosTotaisPausadoAberturaEncerramento - 1;
        
    }
    
    if ($minutosTotaisPausadoAberturaEncerramento < 0) {
        
        $minutosTotaisPausadoAberturaEncerramento = 60 + $minutoTotalAberturaEncerramento - $minutoTotalPausado;
        $horasTotaisPausadoAberturaEncerramento = $horasTotaisPausadoAberturaEncerramento - 1;
        
    }
    
    if ($horasTotaisPausadoAberturaEncerramento < 0) {
        
        $horasTotaisPausadoAberturaEncerramento = 24 + $horaTotalAberturaEncerramento - $horaTotalPausado;
        $diasTotaisPausadoAberturaEncerramento = $diasTotaisPausadoAberturaEncerramento - 1;
        
    }
    
    if ($diasTotaisPausadoAberturaEncerramento < 0) {
        
        $diasTotaisPausadoAberturaEncerramento = 30 + $diaTotalAberturaEncerramento - $diaTotalPausado;
        $mesesTotaisPausadoAberturaEncerramento = $mesesTotaisPausadoAberturaEncerramento - 1;
        
    }
    
    if ($mesesTotaisPausadoAberturaEncerramento < 0) {
        
        $mesesTotaisPausadoAberturaEncerramento = 12 + $mesTotalAberturaEncerramento - $mesTotalPausado;
        $anosTotaisPausadoAberturaEncerramento = $anosTotaisPausadoAberturaEncerramento - 1;
        
    }
    
    //ano n precisa pq nunca sera negativo
    
    $tempoTotal = $anosTotaisPausadoAberturaEncerramento . "a "
            . $mesesTotaisPausadoAberturaEncerramento . "m "
            . $diasTotaisPausadoAberturaEncerramento . "d "
            . $horasTotaisPausadoAberturaEncerramento . "h "
            . $minutosTotaisPausadoAberturaEncerramento . "min "
            . $segundosTotaisPausadoAberturaEncerramento . "s";
    
    $chamado->setTempoTotal($tempoTotal);
    
    $chamado->setResolvido("Resolvido por " . $_SESSION['nomeUsuario']);
    
    ChamadoDAO::encerrar($chamado);

    header("Location: ../chamados.php");
}