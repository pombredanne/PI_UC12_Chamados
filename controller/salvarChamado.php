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
    $chamado->setRetomar(date("Y-m-d H:i:s"));
    $chamado->setPausado(0);

    $retomar = $chamado->getRetomar();

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
//    $segundoPausar = 21;
//    $segundoRetomar = 15;
//
//    $minutoPausar = 25;
//    $minutoRetomar = 17;
//
//    $horaPausar = 20;
//    $horaRetomar = 22;
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
    //total
    $segundosTotais = $segundoRetomar - $segundoPausar . "s";
    $minutosTotais = $minutoRetomar - $minutoPausar . "m ";
    $horasTotais = $horaRetomar - $horaPausar . "h ";

    $diasTotais = $diaRetomar - $diaPausar . "d ";
    $mesesTotais = $mesRetomar - $mesPausar . "m ";
    $anosTotais = $anoRetomar - $anoPausar . "a ";

    //verificando se hora, minuto ou segundo pausar/retomar forem iguais
    if ($horaPausar == $horaRetomar) {

        $horasTotais = "";
    }

    if ($minutoPausar == $minutoRetomar) {

        $minutosTotais = "";
    }

    if ($segundoPausar == $segundoRetomar) {

        $segundosTotais = "";
    }

    //verificando se ano, mes ou dia pausar/retomar forem iguais
    if ($anoPausar == $anoRetomar) {

        $anosTotais = "";
    }

    if ($mesPausar == $mesRetomar) {

        $mesesTotais = "";
    }

    if ($diaPausar == $diaRetomar) {

        $diasTotais = "";
    }

    //verificacoes para quando o segundo, minuto ou hora que pausou for maior
    if ($segundoPausar > $segundoRetomar) {

        //- com - daria +
        $segundosTotais = 60 + $segundosTotais . "s";
        $minutosTotais = $minutosTotais - 1 . "m ";

        if ($minutosTotais == "0m ") {
            $minutosTotais = "";
        }
    }

    if ($minutoPausar > $minutoRetomar) {

        $minutosTotais = 60 + $minutosTotais . "m ";
        $horasTotais = $horasTotais - 1 . "h ";

        if ($horasTotais == "0h ") {
            $horasTotais = "";
        }
    }

    //o contador de dias smp irá contar os dias totais, por isso
    //a verificacao de se a hr do dia em q pausou for maior, decrescentar 1
    if ($horaPausar > $horaRetomar) {

        $horasTotais = 24 + $horasTotais . "h ";
        $diasTotais = $diasTotais - 1 . "d ";

        if ($diasTotais == "0d ") {
            $diasTotais = "";
        }
    }

    if ($diaPausar > $diaRetomar) {

        $diasTotais = 30 + $diasTotais . "d ";
        $mesesTotais = $mesesTotais - 1 . "m ";

        if ($mesesTotais == "0m ") {
            $mesesTotais = "";
        }

        if (($mesesTotais - 1) % 2 == 0) {
            
        }
    }

    if ($mesPausar > $mesRetomar) {

        $mesesTotais = 12 + $mesesTotais . "m ";
        $anosTotais = $anosTotais - 1 . "a ";

        if ($anosTotais == "0a ") {
            $anosTotais = "";
        }
    }

    #VERIFICACAO MESES IMPARES/PARES DIA 31/30
    #EXCECAO FEVEREIRO 28 DIAS

    $tempoTotal = $anosTotais . $mesesTotais . $diasTotais . $horasTotais . $minutosTotais . $segundosTotais;

    $chamado->setTempoTotal($tempoTotal);

    ChamadoDAO::retomar($chamado);

    header("Location: ../chamados.php");
}

if (isset($_GET['encerrar'])) {

    $chamado = ChamadoDAO::getChamadoByCodigo($_GET['codigoChamado']);

    echo '<br><br><br><h3>Tem certeza que deseja retomar o chamado '
    . $chamado->getCodigo() . ' ?</h3><br><hr><br>'
    . '<a href="../chamados.php"><button>Cancelar</button></a>'
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
    
    header("Location: ../chamados.php");
    
}