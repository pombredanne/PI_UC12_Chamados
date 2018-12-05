<?php

include_once 'clsConexao.php';

class ChamadoDAO {

    public static function inserir($chamado) {

        $sql = "INSERT INTO chamados (sala, descricaoProblema, dataHora, status, usuario)"
                . " VALUES"
                . "("
                . " '" . $chamado->getSala() . "' , "
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHora() . "' , "
                . " '" . $chamado->getStatus() . "' , "
                . " '" . $chamado->getUsuario() . "' "
                . ");";

        Conexao::executar($sql);
    }

}
