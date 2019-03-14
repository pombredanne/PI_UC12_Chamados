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

if (isset($_GET['changeSelect'])) {

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
        $chaveChamadoAtivo = 'chaveChamadoAtivo';

        $chaveChamadoTecnicoNomeUsuario = 'chaveChamadoTecnicoNomeUsuario';

        $chaveUsuarioNomeUsuario = 'chaveUsuarioNomeUsuario';

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

        if ($arrayNomeUsuarios[0]->getAdmin() == 1) {
            $array['chaveUsuarioAdmin'] = 1;
        } else {
            $array['chaveUsuarioAdmin'] = 0;
        }
    } else {
        $array[$chaveTecnicosUsuarios] = null;
        $array['countUsuarios'] = null;
    }

    echo json_encode($array);
} else if (isset($_GET['fillSelect'])) {

    $indexSelecTecnicosUsuarios = $_GET['indexSelectTecnicosUsuarios'];

    $arrayNomeUsuarios = ChamadoDAO::getUsuarios();

    $admin = 1;

    foreach ($arrayNomeUsuarios as $usuario) {
        if ($usuario->getNomeUsuario() == $indexSelecTecnicosUsuarios) {
            $admin = 0;
            break;
        }
    }

    $change = "";

    if ($admin == $_GET['admin']) {
        $change = false;
    } else {
        $change = true;
    }

    echo json_encode($change);
} else if (isset($_GET['excluirSala'])) {

    $excluir = SalaDAO::excluir($_GET['codigoSala']);

    if ($excluir == false) {
        $error = 'error';
        echo json_encode($error);
    } else {
        $error = 'success';
        echo json_encode($error);
    }
} else if (isset($_GET['excluirUsuario'])) {

    $excluir = UsuarioDAO::excluir($_GET['codigoUsuario']);

    if ($excluir == false) {
        $error = 'error';
        echo json_encode($error);
    } else {
        $error = 'success';
        echo json_encode($error);
    }
} else if (isset($_GET['pausado'])) {

    $pausado = ChamadoDAO::getPausado($_GET['codigoChamado']);

    echo json_encode($pausado);
} else if (isset($_GET['pausarRetomar'])) {

    $pausado = ChamadoDAO::getPausado($_GET['codigoChamado']);

    if ($pausado == 0)
        pausar($_GET['codigoChamado']);
    else
        retomar($_GET['codigoChamado']);
} else if (isset($_GET['recuperarLogin'])) {

    $usuario = UsuarioDAO::verificarDadosUsuario
                    ($_GET['nomeCompleto'], $_GET['nomeUsuario'], $_GET['email']);

    if ($usuario == true) {

        include_once './PHPMailer/src/Exception.php';
        include_once './PHPMailer/src/PHPMailer.php';
        include_once './PHPMailer/src/SMTP.php';

        $email = new PHPMailer\PHPMailer\PHPMailer;
        $email->isSMTP();
        $email->Host = 'smtp.gmail.com';
        $email->SMTPAuth = true;
        $email->SMTPSecure = 'tls';
        $email->Username = 'senacinformaticapi@gmail.com';
        $email->Password = 'senac2019Project';
        $email->Port = 587;

        $email->setFrom('senacinformaticapi@gmail.com');
        $email->addReplyTo('senacinformaticapi@gmail.com');
        $email->addAddress($_GET['email'], $_GET['nomeUsuario']);

        $email->isHTML(true);
        $email->CharSet = 'UTF-8';
        $email->Subject = 'Recuperação de senha';
        $email->Body = $_GET['nomeUsuario'] . ', segue o link para'
                        . ' redefinir a senha da sua conta:'
                        . ' http://localhost/m171/PI_UC12_Chamados/novaSenha.php'
                        . '?nomeCompleto=' . $_GET['nomeCompleto']
                        . '&nomeUsuario=' . $_GET['nomeUsuario']
                        . '&email=' . $_GET['email'];

        //Texto alternativo para quem nao consegue visualizar o html
        $email->AltBody = 'Nenhum';
        //enviar arquivos em anexos
//        $email->addAttachment('fotos/adalto.jpg');

        $email->send();

//        if (!$email->send()) {
//            echo 'Não foi possível enviar a mensagem';
//            echo 'Erro: ' . $email->ErrorInfo;
//        } else {
//            echo 'Mensagem enviada';
//        }

        echo json_encode($usuario);
    } else {
        echo json_encode($usuario);
    }
}

function pausar($codigoChamado) {

    $chamado = new Chamado();

    $chamado->setCodigo($codigoChamado);

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
}

function retomar($codigoChamado) {

    $chamado = new Chamado();

    $chamado->setCodigo($codigoChamado);

    date_default_timezone_set('America/Sao_Paulo');

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

        if ($minutoPausar != $minutoRetomar || $minutoPausar == $minutoRetomar && $horaPausar != $horaRetomar || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar != $diaRetomar || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $minutoPausar == $minutoRetomar && $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $horaPausar != $horaRetomar || $horaPausar == $horaRetomar && $diaPausar != $diaRetomar || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

            $segundosTotaisPausarRetomar = 60;
        }
    } else {
        $segundosTotaisPausarRetomar = $segundoRetomar - $segundoPausar;
    }


    if ($minutoPausar - $minutoRetomar == 0) {

        if ($horaPausar != $horaRetomar || $horaPausar == $horaRetomar && $diaPausar != $diaRetomar || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $horaPausar == $horaRetomar && $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

            $minutosTotaisPausarRetomar = 60;
        }
    } else {

        $minutosTotaisPausarRetomar = $minutoRetomar - $minutoPausar;
    }

    if ($horaPausar - $horaRetomar == 0) {

//        if ($diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar) {

        if ($diaPausar != $diaRetomar || $diaPausar == $diaRetomar && $mesPausar != $mesRetomar || $diaPausar == $diaRetomar && $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

            $horasTotaisPausarRetomar = 24;
        }
    } else {

        $horasTotaisPausarRetomar = $horaRetomar - $horaPausar;
    }

    if ($diaPausar - $diaRetomar == 0) {

//        if ($mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

        if ($mesPausar != $mesRetomar || $mesPausar == $mesRetomar && $anoPausar != $anoRetomar || $anoPausar != $anoRetomar) {

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

    ChamadoDAO::retomar($chamado);
}
