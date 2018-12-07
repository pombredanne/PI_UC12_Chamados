<?php

include_once 'clsConexao.php';
include_once '../model/clsChamado.php';

class ChamadoDAO {

    public static function inserir($chamado) {

        $sql = "INSERT INTO chamados (sala, descricaoProblema, dataHora, status, usuario)"
                . " VALUES"
                . "("
                . " '" . $chamado->getSala() . "' , "
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHora() . "' , "
                . " '" . $chamado->getStatus() . "' , "
                . " '" . $chamado->getUsuarioTecnico() . "'  "
                . ");";

        Conexao::executar($sql);
    }

    public static function getChamados() {
        
        $sql = " SELECT id, sala, descricaoProblema, dataHora, status, usuario, nivelCriticidade, tecnicoResponsavel"
                . " FROM chamados "
                . " ORDER BY datahora DESC ";

        $result = Conexao::consultar($sql);
        $lista = new ArrayObject();

        while (list($id, $sala, $descricaoProblema, $datahora, $status, $usuario, $nivelCriticidade, $tecnicoResponsavel) = mysqli_fetch_row($result)) {
            
            $chamado = new Chamado();
            $chamado->setId($id);
            $chamado->setSala($sala);
            $chamado->setDescricaoProblema($descricaoProblema);
            $chamado->setDataHora($datahora);
            $chamado->setStatus($status);
            $chamado->setUsuario($usuario);
            $chamado->setNivelCriticidade($nivelCriticidade);
            $chamado->setTecnicoResponsavel($tecnicoResponsavel);

            $lista->append($chamado);
        }
        return $lista;
    }

    public static function getChamadoById($id) {
        
        $sql = "SELECT id, sala, descricaoProblema, dataHora, status, usuario,"
                . " nivelCriticidade, tecnicoResponsavel"
                . " FROM chamados"
                . " WHERE id = " . $id;
        
        $result = Conexao::consultar($sql);
        
        $chamado = new Chamado();
        
        if (mysqli_num_rows($result) > 0) {
            
            $dados = mysqli_fetch_assoc($result);
            
            $chamado->setId($dados['id']);
            $chamado->setSala($dados['sala']);
            $chamado->setDescricaoProblema($dados['descricaoProblema']);
            $chamado->setDataHora($dados['dataHora']);
            $chamado->setStatus($dados['status']);
            $chamado->setUsuario($dados['usuario']);
            $chamado->setNivelCriticidade($dados['nivelCriticidade']);
            $chamado->setTecnicoResponsavel($dados['tecnicoResponsavel']);
            
        }
        
        return $chamado;
    }

}
