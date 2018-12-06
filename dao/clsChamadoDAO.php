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
                . " '" . $chamado->getUsuario() . "'  "
                . ");";

        Conexao::executar($sql);
    }

    public static function getChamados() {
        
        $sql = " SELECT id, sala, descricaoProblema, dataHora, status, usuario, nivelCriticidade, tecnicoResponsavel "
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
        $sql = " SELECT p.id, p.nome, p.foto, p.preco, p.quantidade, c.id, c.nome "
                . " FROM chamados "
                . "ORDER BY datahora ";
    }

}
