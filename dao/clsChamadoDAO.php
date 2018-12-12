<?php

include_once 'clsConexao.php';
include_once '../model/clsChamado.php';
include_once '../model/clsSala.php';
include_once '../model/clsUsuario.php';
include_once '../model/clsFakeTecnicoResponsavel.php';

class ChamadoDAO {

    public static function inserir($chamado) {

        $sql = "INSERT INTO chamados (descricaoProblema, dataHora, status, fkUsuario, fkSala)"
                . " VALUES"
                . "("
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHora() . "' , "
                . " '" . $chamado->getStatus() . "' , "
                . " " . $chamado->getUsuario()->getCodigo() . " , "
                . " " . $chamado->getSala()->getCodigo() . "  "
                . ");";

        Conexao::executar($sql);
    }
    
    public static function editar($chamado) {
        
        $sql = "UPDATE chamados SET"
                . " fkSala = " . $chamado->getSala()->getCodigo() . " , "
                . " descricaoProblema = '" . $chamado->getDescricaoProblema() . "' , "
                . " status = '" . $chamado->getStatus() . "' , "
                . " nivelCriticidade = '" . $chamado->getNivelCriticidade() . "' , "
                . " fakeFkTecnicoResponsavel = " . $chamado->getTecnicoResponsavel()->getCodigo() . " , "
                . " solucaoProblema = '" . $chamado->getSolucaoProblema() . "' "
                . " WHERE codigo = " . $chamado->getCodigo();
        
        Conexao::executar($sql);
    }

    public static function getChamados() {
        
        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status,"
                . " c.nivelCriticidade, c.solucaoProblema,"
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero, t.codigo, t.nomeCompleto"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios t ON c.fakeFkTecnicoResponsavel = t.codigo"
                . " ORDER BY datahora DESC ";

        $result = Conexao::consultar($sql);
        $lista = new ArrayObject();

        while (list($codigo, $descricaoProblema, $datahora, $status, $nivelCriticidade,
                $solucaoProblema, $uCodigo, $uNomeUsuario, 
                $sId, $sNumero, $tCodigo, $tNomeCompleto) = mysqli_fetch_row($result)) {
            
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
            $sala->setCodigo($sId);
            $sala->setNumero($sNumero);
            
            $tecnicoResponsavel = new FakeTecnicoResponsavel();
            $tecnicoResponsavel->setCodigo($tCodigo);
            $tecnicoResponsavel->setNomeCompleto($tNomeCompleto);
            
            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);
            $chamado->setTecnicoResponsavel($tecnicoResponsavel);

            $lista->append($chamado);
        }
        return $lista;
    }

    public static function getChamadoByCodigo($codigo) {
        
        $sql = " SELECT c.codigo, c.descricaoProblema, c.dataHora, c.status, "
                . " c.nivelCriticidade, c.solucaoProblema, "
                . " u.codigo, u.nomeUsuario, s.codigo, s.numero, t.codigo, t.nomeCompleto"
                . " FROM chamados c"
                . " INNER JOIN usuarios u ON c.fkUsuario = u.codigo"
                . " INNER JOIN salas s ON c.fkSala = s.codigo"
                . " INNER JOIN usuarios t ON c.fakeFkTecnicoResponsavel = t.codigo"
                . " WHERE c.codigo = " . $codigo;
        
        $result = Conexao::consultar($sql);
        
        $chamado = new Chamado();
        
        if (mysqli_num_rows($result) > 0) {
            
            list($cCodigo, $cDescricaoProblema, $cDataHora, $cStatus,
                $cNivelCriticidade, $cSolucaoProblema,
                $uCodigo, $uNomeUsuario, $sCodigo, $sNumero, $tCodigo, $tNomeCompleto) = mysqli_fetch_row($result);
            
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
            
            $tecnicoResponsavel = new FakeTecnicoResponsavel();
            $tecnicoResponsavel->setCodigo($tCodigo);
            $tecnicoResponsavel->setNomeCompleto($tNomeCompleto);
            
            $chamado->setUsuario($usuario);
            $chamado->setSala($sala);
            $chamado->setTecnicoResponsavel($tecnicoResponsavel);
            
        }
        
        return $chamado;
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
        
        $chamado = new Chamado();
        
        if (mysqli_num_rows($result) > 0) {
            
            list($cCodigo, $cDescricaoProblema, $cDataHora, $cStatus,
                $cNivelCriticidade, $cTecnicoResponsavel, $cSolucaoProblema,
                $uCodigo, $uNomeUsuario, $sCodigo, $sNumero) = mysqli_fetch_row($result);
            
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
            
        }
        
        return $chamado;
    }

}
