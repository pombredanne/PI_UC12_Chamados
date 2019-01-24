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
                . " " . $chamado->getUsuario()->getCodigo() . " , "
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

    public static function cancelar($codigo) {

        $sql = "UPDATE chamados SET"
                . " ativo = " . $chamado->getAtivo()
                . " WHERE codigo = " . $chamado->getCodigo();

        Conexao::executar($sql);
    }
    
    public static function pausar($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " pausar = '" . $chamado->getPausar(). "' , "
                . " pausado = " . $chamado->getPausado(). " "
                . " WHERE codigo = " . $chamado->getCodigo();
        
        Conexao::executar($sql);
        
    }
    
    public static function retomar($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " retomar = '" . $chamado->getRetomar(). "' , "
                . " pausado = " . $chamado->getPausado(). " , "
                . " tempoTotal = '" . $chamado->getTempoTotal(). "' "
                . " WHERE codigo = " . $chamado->getCodigo();
        
        Conexao::executar($sql);
        
    }
    
    public static function tempoTotal($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " tempoTotal = '" . $chamado->getTempoTotal() . "'"
                . " WHERE codigo = " . $chamado->getCodigo();
        
        Conexao::executar($sql);
    }
    
    public static function getPausar($chamado) {
        
        $sql = "SELECT pausar FROM chamados WHERE codigo = " . $chamado->getCodigo();
        
        $result = Conexao::consultar($sql);
        
        $dados = mysqli_fetch_assoc($result);
        
        return $dados['pausar'];
    }
    
    public static function encerrar($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " dataHoraEncerramento = '" . $chamado->getDataHoraEncerramento() . "', "
                . " ativo = " . $chamado->getAtivo()
                . " WHERE codigo = " . $chamado->getCodigo();
        
        Conexao::executar($sql);
    }
    
    public static function getChamados() {

        $sql = " SELECT * FROM chamados"
                . " INNER JOIN salas on fkSala = salas.codigo"
                . " INNER JOIN usuarios u ON fkUsuario = u.codigo"
                . " WHERE chamados.ativo = 1";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $cPausar, $cRetomar, $cPausado, $cResolvido, $sFkSala,
            $uFkCodigo, $tFkCodigo, $cAtivo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result)) {

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

    public static function getChamadosByUsuario($nomeUsuario) {

        $sql = " SELECT *"
                . " FROM chamados c"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " WHERE u.nomeUsuario = '" . $nomeUsuario . "'"
                . " AND WHERE chamados.ativo = 1";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus, $cHistoricoStatus,
            $cNivelCriticidade, $cSolucaoProblema, $sFkSala,
            $uFkCodigo, $tFkCodigo, $ativo, $sCodigo, $sNumero
            , $sDescricao, $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result)) {

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

            list($cCodigo, $cDataHoraAbertura, $cDescricaoProblema, $cStatus,
                    $cHistoricoStatus, $cNivelCriticidade, $cSolucaoProblema, $sFkSala,
                    $uFkCodigo, $tFkCodigo, $ativo, $sCodigo, $sNumero, $sDescricao,
                    $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result);

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
