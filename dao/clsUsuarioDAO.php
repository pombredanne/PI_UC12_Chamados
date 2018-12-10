<?php

include_once '../model/clsUsuario.php';
include_once 'clsConexao.php';

class UsuarioDAO {

    public static function inserir($usuario) {

        $sql = "INSERT INTO usuarios (nomeCompleto, nomeUsuario, senha, email, admin) VALUES"
                . "("
                . " '" . $usuario->getNomeCompleto() . "' , "
                . " '" . $usuario->getNomeUsuario() . "' , "
                . " '" . $usuario->getSenha() . "' , "
                . " '" . $usuario->getEmail() . "' , "
                . " " . $usuario->getAdmin() . " "
                . ");";

        Conexao::executar($sql);
    }
    
    public static function getUsuarioAdmin() {
        
        $sql = "SELECT codigo, nomeCompleto, nomeUsuario, senha, email, admin"
                . " FROM usuarios"
                . " WHERE admin = 1";
        
        $result = Conexao::consultar($sql);
        
        $lista = new ArrayObject();
        
        if ($result != null) {
            
            while(list($codigo, $nomeCompleto, $nomeUsuario, $senha, $email, $admin) = mysqli_fetch_row($result)) {
                
                $usuario = new Usuario();
                $usuario->setCodigo($codigo);
                $usuario->setNomeCompleto($nomeCompleto);
                $usuario->setNomeUsuario($nomeUsuario);
                $usuario->setSenha($senha);
                $usuario->setEmail($email);
                $usuario->setAdmin($admin);
                
                $lista->append($usuario);
                
            }
        }
        
        return $lista;
        
    }

    public static function login($nomeUsuario, $senha) {

        $sql = "SELECT codigo, nomeCompleto, nomeUsuario, senha, email, admin"
                . " FROM usuarios"
                . " WHERE nomeUsuario = '" . $nomeUsuario . "'"
                . " AND senha = '" . $senha . "'";
        
        $result = Conexao::consultar($sql);

        if (mysqli_num_rows($result) > 0) {

            $dados = mysqli_fetch_assoc($result);

            $usuario = new Usuario();
            $usuario->setCodigo($dados['codigo']);
            $usuario->setNomeCompleto($dados['nomeCompleto']);
            $usuario->setNomeUsuario($dados['nomeUsuario']);
            $usuario->setSenha($dados['senha']);
            $usuario->setEmail($dados['email']);
            $usuario->setAdmin($dados['admin']);

            return $usuario;
        } else {

            return null;
        }
    }

}
