<?php

include_once 'clsConexao.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';

class ChamadoDAO {

    public static function inserir($chamado) {

        $sql = "INSERT INTO chamados (descricaoProblema, dataHora, fkUsuario, fkSala)"
                . " VALUES"
                . "("
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHora() . "' , "
                . " " . $chamado->getUsuario()->getCodigo() . " , "
                . " " . $chamado->getSala()->getCodigo() . "  "
                . ");";

        Conexao::executar($sql);
    }

    public static function editarChamadoAdmin($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " fkSala = " . $chamado->getSala()->getCodigo() . " , "
                . " descricaoProblema = '" . $chamado->getDescricaoProblema() . "' , "
//                . " status = '" . $chamado->getStatus() . "' , ";
                . " status = '" . $chamado->getStatus() . "' , "
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

    public static function excluir($codigo) {

        $sql = "DELETE FROM chamados WHERE codigo = " . $codigo;

        Conexao::executar($sql);
    }

    public static function getChamados() {

        $sql = " SELECT * FROM chamados"
                . " INNER JOIN salas on fkSala = salas.codigo"
                . " INNER JOIN usuarios u ON fkUsuario = u.codigo";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($codigo, $dataHora, $descricaoProblema, $status, $historicoStatus,
                    $nivelCriticidade, $solucaoProblema, $sFkSala,
            $uFkCodigo, $tFkCodigo, $sCodigo, $sNumero, $sDescricao
            , $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($codigo);
                $chamado->setDataHora($dataHora);
                $chamado->setDescricaoProblema($descricaoProblema);
                $chamado->setStatus($status);
                $chamado->setHistoricoStatus($historicoStatus);
                $chamado->setNivelCriticidade($nivelCriticidade);
                $chamado->setSolucaoProblema($solucaoProblema);

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
                . " WHERE u.nomeUsuario = '" . $nomeUsuario . "'";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDataHora, $cDescricaoProblema, $cStatus,
                    $cHistoricoStatus, $cNivelCriticidade, $cSolucaoProblema, $sFkSala,
            $uFkCodigo, $tFkCodigo, $sCodigo, $sNumero, $sDescricao,
            $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($cCodigo);
                $chamado->setDataHora($cDataHora);
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

            list($cCodigo, $cDataHora, $cDescricaoProblema, $cStatus,
                    $cHistoricoStatus, $cNivelCriticidade, $cSolucaoProblema, $sFkSala,
                    $uFkCodigo, $tFkCodigo, $sCodigo, $sNumero, $sDescricao,
                    $uCodigo, $uNomeCompleto, $uNomeUsuario, $uEmail, $uSenha, $uAdmin) = mysqli_fetch_row($result);

            $chamado->setCodigo($cCodigo);
            $chamado->setDescricaoProblema($cDescricaoProblema);
            $chamado->setDataHora($cDataHora);
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
            }

            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);

            return $chamado;
        } else {

            return null;
        }
    }

}
