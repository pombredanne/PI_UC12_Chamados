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

    public static function getChamadosComTecnico() {

        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status,"
                . " c.nivelCriticidade, c.solucaoProblema,"
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero, t.codigo, t.nomeUsuario"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios t ON c.fkTecnicoResponsavel = t.codigo"
                . " ORDER BY datahora DESC ";

        $result = Conexao::consultar($sql);
        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($codigo, $descricaoProblema, $datahora, $status, $nivelCriticidade,
            $solucaoProblema, $uCodigo, $uNomeUsuario,
            $sCodigo, $sNumero, $tCodigo, $tNomeusuario) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($codigo);
                $chamado->setDescricaoProblema($descricaoProblema);
                $chamado->setDataHora($datahora);
                $chamado->setStatus($status);
                $chamado->setNivelCriticidade($nivelCriticidade);
                $chamado->setSolucaoProblema($solucaoProblema);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                $tecnicoResponsavel = new Usuario();
                $tecnicoResponsavel->setCodigo($tCodigo);
                $tecnicoResponsavel->setNomeUsuario($tNomeusuario);

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);
                $chamado->setTecnicoResponsavel($tecnicoResponsavel);

                $lista->append($chamado);
            }

            return $lista;
            
        } else {
            
            return null;
        }
    }

    public static function getChamadosSemTecnico() {

        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status,"
                . " c.nivelCriticidade, c.solucaoProblema,"
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " ORDER BY datahora DESC";

        $result = Conexao::consultar($sql);
        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($codigo, $descricaoProblema, $datahora, $status, $nivelCriticidade,
            $solucaoProblema, $uCodigo, $uNomeUsuario,
            $sCodigo, $sNumero) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($codigo);
                $chamado->setDescricaoProblema($descricaoProblema);
                $chamado->setDataHora($datahora);
                $chamado->setStatus($status);
                $chamado->setNivelCriticidade($nivelCriticidade);
                $chamado->setSolucaoProblema($solucaoProblema);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);

                $lista->append($chamado);
            }

            return $lista;
            
        } else {
            
            return null;
        }
    }

    public static function getChamadoComTecnicoByCodigo($codigo) {

        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status, "
                . " c.nivelCriticidade, c.solucaoProblema, "
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero, t.codigo, t.nomeUsuario"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios t ON c.fkTecnicoResponsavel = t.codigo"
                . " WHERE c.codigo = " . $codigo;

        $result = Conexao::consultar($sql);

        $chamado = new Chamado();

        if (mysqli_num_rows($result) > 0) {

            list($cCodigo, $cDescricaoProblema, $cDataHora, $cStatus,
                    $cNivelCriticidade, $cSolucaoProblema,
                    $uCodigo, $uNomeUsuario, $sCodigo, $sNumero, $tCodigo, $tNomeUsuario) = mysqli_fetch_row($result);

            $chamado->setCodigo($cCodigo);
            $chamado->setDescricaoProblema($cDescricaoProblema);
            $chamado->setDataHora($cDataHora);
            $chamado->setStatus($cStatus);
            $chamado->setNivelCriticidade($cNivelCriticidade);
            $chamado->setSolucaoProblema($cSolucaoProblema);

            $usuario = new Usuario();
            $usuario->setCodigo($uCodigo);
            $usuario->setNomeUsuario($uNomeUsuario);

            $sala = new Sala();
            $sala->setCodigo($sCodigo);
            $sala->setNumero($sNumero);

            $tecnicoResponsavel = new Usuario();
            $tecnicoResponsavel->setCodigo($tCodigo);
            $tecnicoResponsavel->setNomeUsuario($tNomeUsuario);

            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);
            $chamado->setTecnicoResponsavel($tecnicoResponsavel);

            return $chamado;
        } else {

            return null;
        }
    }

    public static function getChamadoSemTecnicoByCodigo($codigo) {

        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status, "
                . " c.nivelCriticidade, c.solucaoProblema, "
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " WHERE c.codigo = " . $codigo;

        $result = Conexao::consultar($sql);

        $chamado = new Chamado();

        if (mysqli_num_rows($result) > 0) {

            list($cCodigo, $cDescricaoProblema, $cDataHora, $cStatus,
                    $cNivelCriticidade, $cSolucaoProblema,
                    $uCodigo, $uNomeUsuario, $sCodigo, $sNumero) = mysqli_fetch_row($result);

            $chamado->setCodigo($cCodigo);
            $chamado->setDescricaoProblema($cDescricaoProblema);
            $chamado->setDataHora($cDataHora);
            $chamado->setStatus($cStatus);
            $chamado->setNivelCriticidade($cNivelCriticidade);
            $chamado->setSolucaoProblema($cSolucaoProblema);

            $usuario = new Usuario();
            $usuario->setCodigo($uCodigo);
            $usuario->setNomeUsuario($uNomeUsuario);

            $sala = new Sala();
            $sala->setCodigo($sCodigo);
            $sala->setNumero($sNumero);

            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);

            return $chamado;
        } else {

            return null;
        }
    }

    public static function getChamadosByUsuario($nomeUsuario) {

        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status, "
                . " c.nivelCriticidade, c.tecnicoResponsavel, c.solucaoProblema, "
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " WHERE u.nomeUsuario = '" . $nomeUsuario . "'";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        if (mysqli_num_rows($result) > 0) {

            while (list($cCodigo, $cDescricaoProblema, $cDataHora, $cStatus,
            $cNivelCriticidade, $cTecnicoResponsavel, $cSolucaoProblema,
            $uCodigo, $uNomeUsuario, $sCodigo, $sNumero) = mysqli_fetch_row($result)) {

                $chamado = new Chamado();
                $chamado->setCodigo($cCodigo);
                $chamado->setDescricaoProblema($cDescricaoProblema);
                $chamado->setDataHora($cDataHora);
                $chamado->setStatus($cStatus);
                $chamado->setNivelCriticidade($cNivelCriticidade);
                $chamado->setTecnicoResponsavel($cTecnicoResponsavel);
                $chamado->setSolucaoProblema($cSolucaoProblema);

                $usuario = new Usuario();
                $usuario->setCodigo($uCodigo);
                $usuario->setNomeUsuario($uNomeUsuario);

                $sala = new Sala();
                $sala->setCodigo($sCodigo);
                $sala->setNumero($sNumero);

                $chamado->setUsuario($usuario);
                $chamado->setSala($sala);

                $lista->append($chamado);
            }
        }

        return $lista;
    }

}
