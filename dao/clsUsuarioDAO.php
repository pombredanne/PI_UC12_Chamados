<?php

include_once '../model/clsUsuario.php';
include_once './clsConexao.php';

class UsuarioDAO {

    public static function inserir($usuario) {

        $sql = "INSERT INTO usuarios (nome, nomeUsuario, senha, admin) VALUES"
                . "("
                . " '" . $usuario->getNome() . "' , "
                . " '" . $usuario->getNomeUsuario() . "' , "
                . " '" . $usuario->getSenha() . "' , "
                . " " . $usuario->getAdmin() . "  "
                . ");";

        Conexao::executar($sql);
    }

    public static function login($nomeUsuario, $senha) {

        $sql = "SELECT id, nome, nomeUsuario, senha, admin"
                . " FROM usuarios"
                . " WHERE nomeUsuario = '" . $nomeUsuario
                . "' AND senha = '" . $senha . "'";
        
        $result = Conexao::consultar($sql);

        if (mysqli_num_rows($result) > 0) {

            $dados = mysqli_fetch_assoc($result);

            $usuario = new Usuario();
            $usuario->setId($dados['id']);
            $usuario->setNome($dados['nome']);
            $usuario->setNomeUsuario($dados['nomeUsuario']);
            $usuario->setSenha($dados['senha']);
            $usuario->setAdmin($dados['admin']);

            return $usuario;
        } else {

            return null;
        }
    }

}
