<?php

include_once 'clsConexao.php';
include_once '../model/clsSala.php';

class SalaDAO {

    public static function inserir($sala) {

        $sql = "INSERT INTO salas (numero, descricao) VALUES"
                . "("
                . " '" . $sala->getNumero() . "' , "
                . " '" . $sala->getDescricao() . "' "
                . ");";

        Conexao::executar($sql);
    }

    public static function excluir($sala) {

        $sql = " DELETE FROM salas"
                . " WHERE codigo = " . $sala->getCodigo();

        Conexao::executar($sql);
    }

    public static function getSalas() {

        $sql = "SELECT codigo, numero, descricao"
                . " FROM salas"
                . " ORDER BY numero";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        while (list($codigo, $numero, $descricao) = mysqli_fetch_row($result)) {

            $sala = new sala();
            $sala->setCodigo($codigo);
            $sala->setNumero($numero);
            $sala->setDescricao($descricao);

            $lista->append($sala);
        }

        return $lista;
    }

    public static function getSalaById($codigo) {

        $sql = "SELECT codigo, numero, descricao"
                . " FROM salas"
                . " WHERE codigo = " . $codigo;

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        $sala = new Sala();
        $sala->setCodigo($dados['codigo']);
        $sala->setNumero($dados['numero']);
        $sala->setDescricao($dados['descricao']);

        return $sala;
    }

}
