<?php

include_once '../model/clsUsuario.php';
include_once './clsConexao.php';

class UsuarioDAO {

    public static function inserir($usuario) {

        $sql = "INSERT INTO usuarios (nome, usuario, senha) VALUES"
                . "("
                . " '" . $usuario->getNome() . "' , "
                . " '" . $usuario->getUsuario() . "' , "
                . " '" . $usuario->getSenha() . "'  "
                . ");";

        Conexao::executar($sql);
    }

    public static function login($nomeUsuario, $senha) {

        $sql = "SELECT id, nome, nomeUsuario, senha"
                . " FROM usuarios"
                . " WHERE (nomeUsuario = " . $id
                . " AND senha = " . $senha . ")";

        $result = Conexao::consultar($sql);

        if (mysqli_num_rows($result) > 0) {

            $dados = mysqli_fetch_assoc($result);

            $usuario = new Usuario();
            $usuario->setId($dados['id']);
            $usuario->setNome($dados['nome']);
            $usuario->setUsuario($dados['nomeUsuario']);
            $usuario->setSenha($dados['senha']);

            return $usuario;
        } else {

            return null;
        }
    }

}
