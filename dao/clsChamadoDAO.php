<?php

include_once 'clsConexao.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';

class ChamadoDAO {

    public static function inserirChamadoAdmin($chamado) {

        $sql = "INSERT INTO chamados (descricaoProblema, dataHoraAbertura, fkUsuario, fkSala, nivelCriticidade, fkTecnicoResponsavel)"
                . " VALUES"
                . "("
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHoraAbertura() . "' , "
                . " " . $chamado->getUsuario()->getCodigo() . " , "
                . " " . $chamado->getSala()->getCodigo() . " , "
                . " '" . $chamado->getNivelCriticidade() . "' , "
                . " " . $chamado->getTecnicoResponsavel()->getCodigo() . "  "
                . ");";

        Conexao::executar($sql);
    }

    public static function inserirChamadoDocente($chamado) {

        $sql = "INSERT INTO chamados (descricaoProblema, dataHoraAbertura, fkUsuario, fkSala)"
                . " VALUES"
                . "("
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHoraAbertura() . "' , "
                . " " . $chamado->getUsuarioByCodigo()->getCodigo() . " , "
                . " " . $chamado->getSala()->getCodigo() . " "
                . ");";

        Conexao::executar($sql);
    }

    public static function editarChamadoAdmin($chamado) {

        $chamado2 = ChamadoDAO::getChamadoByCodigo($chamado->getCodigo());

        $historicoStatus = $chamado2->getHistoricoStatus() . ", " . $chamado->getStatus();
        $chamado->setHistoricoStatus($historicoStatus);

        $sql = "UPDATE chamados SET"
                . " fkSala = " . $chamado->getSala()->getCodigo() . " , "
                . " descricaoProblema = '" . $chamado->getDescricaoProblema() . "' , "
                . " status = '" . $chamado->getStatus() . "' , "
                . " historicoStatus = '" . $chamado->getHistoricoStatus() . "' , "
                . " nivelCriticidade = '" . $chamado->getNivelCriticidade() . "' , "
                . " fkTecnicoResponsavel = " . $chamado->getTecnicoResponsavel()->getCodigo() . " , "
                . " solucaoProblema = '" . $chamado->getSolucaoProblema() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function editarChamadoDocente($chamado) {

        $sql = "UPDATE chamados SET"
                . " fkSala = " . $chamado->getSala()->getCodigo() . " , "
                . " descricaoProblema = '" . $chamado->getDescricaoProblema() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function cancelar($chamado) {

        $sql = "UPDATE chamados SET"
                . " ativo = " . $chamado->getAtivo() . " , "
                . " resolvido = '" . $chamado->getResolvido() . "' , "
                . " pausado = null "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function pausar($chamado) {

        $sql = "UPDATE chamados SET"
                . " pausar = '" . $chamado->getPausar() . "' , "
                . " pausado = " . $chamado->getPausado() . " , "
                . " historicoPausar = '" . $chamado->getHistoricoPausar() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function retomar($chamado) {

        $sql = "UPDATE chamados SET"
                . " retomar = '" . $chamado->getRetomar() . "' , "
                . " pausado = " . $chamado->getPausado() . " , "
                . " tempoPausado = '" . $chamado->getTempoPausado() . "' , "
                . " historicoRetomar = '" . $chamado->getHistoricoRetomar() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function encerrar($chamado) {

        $sql = "UPDATE chamados SET"
                . " dataHoraEncerramento = '" . $chamado->getDataHoraEncerramento() . "' , "
                . " pausar = null , "
                . " retomar = null , "
                . " pausado = null , "
                . " tempoTotal = '" . $chamado->getTempoTotal() . "' , "
                . " ativo = " . $chamado->getAtivo() . " , "
                . " resolvido = '" . $chamado->getResolvido() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }

    public static function getDataHoraAbertura($chamado) {

        $sql = "SELECT dataHoraAbertura FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['dataHoraAbertura'];
    }

    public static function getDataHoraEncerramento($chamado) {

        $sql = "SELECT dataHoraEncerramento FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['dataHoraEncerramento'];
    }

    public static function getTempoPausado($chamado) {

        $sql = "SELECT tempoPausado FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['tempoPausado'];
    }

    public static function getPausar($chamado) {

        $sql = "SELECT pausar FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['pausar'];
    }

    public static function getRetomar($chamado) {

        $sql = "SELECT retomar FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['retomar'];
    }

    public static function getHistoricoPausar($chamado) {

        $sql = "SELECT historicoPausar FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['historicoPausar'];
    }

    public static function getHistoricoRetomar($chamado) {

        $sql = "SELECT historicoRetomar FROM chamados WHERE codigo = " . $chamado->getCodigo();

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        return $dados['historicoRetomar'];
    }
    
    public static function getPausado($codigoChamado)
    {
        $sql = "SELECT pausado FROM chamados WHERE codigo = " . $codigoChamado;
            
        $result = Conexao::consultar($sql);
        
        $dados = mysqli_fetch_assoc($result);
        
        return $dados['pausado'];
        
    }

    public static function getTecnicos() {

        $sql = "SELECT codigo, nomeUsuario, admin FROM usuarios WHERE admin = 1
            ORDER BY nomeUsuario";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        while (list($codigo, $nome, $admin) = mysqli_fetch_row($result)) {

            $tecnico = new Usuario();
            $tecnico->setCodigo($codigo);
            $tecnico->setNomeUsuario($nome);
            $tecnico->setAdmin($admin);

            $lista->append($tecnico);
        }

        return $lista;
    }

    public static function getUsuarios() {

        $sql = "SELECT codigo, nomeUsuario, admin FROM usuarios WHERE admin = 0
            ORDER BY nomeUsuario";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        while (list($codigo, $nome, $admin) = mysqli_fetch_row($result)) {

            $usuario = new Usuario();
            $usuario->setCodigo($codigo);
            $usuario->setNomeUsuario($nome);
            $usuario->setAdmin($admin);

            $lista->append($usuario);
        }

        return $lista;
    }

    public static function getChamados($status) {

        $sql = " SELECT * FROM chamados c"
                . " INNER JOIN salas on fkSala = salas.codigo"
                . " INNER JOIN usuarios u ON fkUsuario = u.codigo"
                . " WHERE c.ativo = 1"
                . " ORDER BY c.dataHoraAbertura";

        if ($status != "todos") {

            $sql = $sql . " AND chamados.status = '" . $status . "'";
        }

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $cPausar, $cRetomar, $cPausado, $cResolvido, $cTempoPausado,
                    $cTempoTotal, $cDataHoraEncerramento, $cHistoricoPausar, $cHistoricoRetomar, $sFkSala,
            $uFkCodigo, $tFkCodigo, $cAtivo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin, $uFoto) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($cCodigo);
                $chamado->setDataHoraAbertura($cDataHoraAbertura);
                $chamado->setDescricaoProblema($cDescricaoProblema);
                $chamado->setStatus($cStatus);
                $chamado->setHistoricoStatus($cHistoricoStatus);
                $chamado->setNivelCriticidade($cNivelCriticidade);
                $chamado->setSolucaoProblema($cSolucaoProblema);
                $chamado->setPausar($cPausar);
                $chamado->setRetomar($cRetomar);
                $chamado->setPausado($cPausado);
                $chamado->setResolvido($cResolvido);
                $chamado->setAtivo($cAtivo);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                if ($tFkCodigo == null) {

                    $chamado->setTecnicoResponsavel(null);
                } else {

                    $sql = " SELECT * FROM usuarios"
                            . " WHERE codigo = " . $tFkCodigo;

                    $resultTecnico = Conexao::consultar($sql);

                    list($tCodigo, $tNomeCompleto, $tNomeUsuario, $tEmail, $tSenha, $tAdmin) = mysqli_fetch_row($resultTecnico);

                    $tecnicoResponsavel = new Usuario();
                    $tecnicoResponsavel->setCodigo($tCodigo);
                    $tecnicoResponsavel->setNomeUsuario($tNomeUsuario);

                    $chamado->setTecnicoResponsavel($tecnicoResponsavel);
                }

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);

                $lista->append($chamado);
            }

            return $lista;
        } else {

            return null;
        }
    }

    public static function getAllChamadosByUsuario($nomeUsuario, $status) {

        $sql = " SELECT *"
                . " FROM chamados c"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " WHERE c.ativo = 1"
                . " AND u.admin = 0"
                . " ORDER BY c.dataHoraAbertura";
        
        if ($nomeUsuario != 'todos') {
            
            $sql = $sql . " AND u.nomeUsuario = '" . $nomeUsuario . "'";
            
        }    
            
        if ($_SESSION['admin'] == 1) {
            
            if ($status != '    todos') {

                $sql = $sql . " AND c.status = '" . $status . "'";
            }
            
        }
        
        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $cPausar, $cRetomar, $cPausado, $cResolvido, $cTempoPausado,
                    $cTempoTotal, $cDataHoraEncerramento, $cHistoricoPausar, $cHistoricoRetomar, $sFkSala,
            $uFkCodigo, $tFkCodigo, $cAtivo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin, $uFoto) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($cCodigo);
                $chamado->setDataHoraAbertura($cDataHoraAbertura);
                $chamado->setDescricaoProblema($cDescricaoProblema);
                $chamado->setStatus($cStatus);
                $chamado->setHistoricoStatus($cHistoricoStatus);
                $chamado->setNivelCriticidade($cNivelCriticidade);
                $chamado->setSolucaoProblema($cSolucaoProblema);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                if ($tFkCodigo == null) {

                    $chamado->setTecnicoResponsavel(null);
                } else {

                    $sql = "SELECT * FROM usuarios"
                            . " WHERE codigo = " . $tFkCodigo;

                    $resultTecnico = Conexao::consultar($sql);

                    list($tCodigo, $tNomeCompleto, $tNomeUsuario, $tEmail, $tSenha, $tAdmin) = mysqli_fetch_row($resultTecnico);

                    $tecnicoResponsavel = new Usuario();
                    $tecnicoResponsavel->setCodigo($tCodigo);
                    $tecnicoResponsavel->setNomeUsuario($tNomeUsuario);

                    $chamado->setTecnicoResponsavel($tecnicoResponsavel);
                }

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);

                $lista->append($chamado);
            }
        }

        return $lista;
    }

    public static function getAllChamadosByNomeUsuarioTecnico($nomeUsuario, $status) {

        $sql = " SELECT *"
                . " FROM chamados c"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " WHERE c.ativo = 1"
                . " AND u.admin = 1"
                . " ORDER BY c.dataHoraAbertura";
        
        if ($nomeUsuario != "todos") {
            
            $sql = $sql . " AND u.nomeUsuario  = '" . $nomeUsuario . "'";
            
        }

        if ($status != "todos") {

            $sql = $sql . " AND c.status = '" . $status . "'";
        }

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $cPausar, $cRetomar, $cPausado, $cResolvido, $cTempoPausado,
                    $cTempoTotal, $cDataHoraEncerramento, $cHistoricoPausar, $cHistoricoRetomar, $sFkSala,
            $uFkCodigo, $tFkCodigo, $cAtivo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin, $uFoto) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($cCodigo);
                $chamado->setDataHoraAbertura($cDataHoraAbertura);
                $chamado->setDescricaoProblema($cDescricaoProblema);
                $chamado->setStatus($cStatus);
                $chamado->setHistoricoStatus($cHistoricoStatus);
                $chamado->setNivelCriticidade($cNivelCriticidade);
                $chamado->setSolucaoProblema($cSolucaoProblema);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                if ($tFkCodigo == null) {

                    $chamado->setTecnicoResponsavel(null);
                } else {

                    $sql = "SELECT * FROM usuarios"
                            . " WHERE codigo = " . $tFkCodigo;

                    $resultTecnico = Conexao::consultar($sql);

                    list($tCodigo, $tNomeCompleto, $tNomeUsuario, $tEmail, $tSenha, $tAdmin) = mysqli_fetch_row($resultTecnico);

                    $tecnicoResponsavel = new Usuario();
                    $tecnicoResponsavel->setCodigo($tCodigo);
                    $tecnicoResponsavel->setNomeUsuario($tNomeUsuario);

                    $chamado->setTecnicoResponsavel($tecnicoResponsavel);
                }

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);

                $lista->append($chamado);
            }
        }

        return $lista;
    }

    public static function getChamadoByCodigo($codigo) {

        $sql = "SELECT *"
                . " FROM chamados c"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " WHERE c.codigo = " . $codigo;

        $result = Conexao::consultar($sql);

        if (mysqli_num_rows($result) > 0) {

            $chamado = new Chamado();

            list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $cPausar, $cRetomar, $cPausado, $cResolvido, $cTempoPausado,
                    $cTempoTotal, $cDataHoraEncerramento, $cHistoricoPausar, $cHistoricoRetomar, $sFkSala,
            $uFkCodigo, $tFkCodigo, $cAtivo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin, $uFoto) = mysqli_fetch_row($result);

            $chamado->setCodigo($cCodigo);
            $chamado->setDescricaoProblema($cDescricaoProblema);
            $chamado->setDataHoraAbertura($cDataHoraAbertura);
            $chamado->setStatus($cStatus);
            $chamado->setHistoricoStatus($cHistoricoStatus);
            $chamado->setNivelCriticidade($cNivelCriticidade);
            $chamado->setSolucaoProblema($cSolucaoProblema);

            $usuario = new Usuario();
            $usuario->setCodigo($uCodigo);
            $usuario->setNomeUsuario($uNomeUsuario);

            $sala = new Sala();
            $sala->setCodigo($sCodigo);
            $sala->setNumero($sNumero);

            if ($tFkCodigo == null) {

                $chamado->setTecnicoResponsavel(null);
            } else {

                $sql2 = "SELECT * FROM usuarios"
                        . " WHERE codigo = " . $tFkCodigo;

                $resultTecnico = Conexao::consultar($sql2);

                list($tCodigo, $tNomeCompleto, $tNomeUsuario, $tEmail, $tSenha, $tAdmin) = mysqli_fetch_row($resultTecnico);

                $tecnicoResponsavel = new Usuario();
                $tecnicoResponsavel->setCodigo($tCodigo);
                $tecnicoResponsavel->setNomeUsuario($tNomeUsuario);

                $chamado->setTecnicoResponsavel($tecnicoResponsavel);
            }

            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);

            return $chamado;
        } else {

            return null;
        }
    }

}
