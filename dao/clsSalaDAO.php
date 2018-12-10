<?php

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
                . " WHERE id = " . $sala->getId();

        Conexao::executar($sql);
    }

    public static function getSalas() {

        $sql = "SELECT id, numero, descricao"
                . " FROM salas"
                . " ORDER BY numero";

        $result = Conexao::consultar($sql);

        $lista = new ArrayObject();

        while (list($id, $numero, $descricao) = mysqli_fetch_row($result)) {

            $sala = new sala();
            $sala->setId($id);
            $sala->setNumero($numero);
            $sala->setDescricao($descricao);

            $lista->append($sala);
        }

        return $lista;
    }

    public static function getSalaById($id) {

        $sql = "SELECT id, numero, descricao"
                . " FROM salas"
                . " WHERE id = " . $id;

        $result = Conexao::consultar($sql);

        $dados = mysqli_fetch_assoc($result);

        $sala = new Sala();
        $sala->setId($dados['id']);
        $sala->setNumero($dados['numero']);
        $sala->setDescricao($dados['descricao']);

        return $sala;
    }

}
