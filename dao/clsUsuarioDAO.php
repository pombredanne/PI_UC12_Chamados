<?php

include_once '../model/clsUsuario.php';
include_once 'clsConexao.php';

class UsuarioDAO {

    public static function inserir($usuario) {

        $sql = "INSERT INTO usuarios (nomeCompleto, nomeUsuario, senha, email, admin, foto) VALUES"
                . "("
                . " '" . $usuario->getNomeCompleto() . "' , "
                . " '" . $usuario->getNomeUsuario() . "' , "
                . " '" . $usuario->getSenha() . "' , "
                . " '" . $usuario->getEmail() . "' , "
                . " " . $usuario->getAdmin() . " , "
                . " '" . $usuario->getFoto() . "' "
                . ");";

        Conexao::executar($sql);
    }
    
    public static function editar($usuario) {
        
        $sql = "UPDATE usuarios SET"
                . " nomeCompleto = '" . $usuario->getNomeCompleto() . "' , "
                . " nomeUsuario = '" . $usuario->getNomeUsuario() . "' , "
                . " email = '" . $usuario->getEmail() . "' , "
                . " admin = " . $usuario->getAdmin() . " , "
                . " foto = '" . $usuario->getFoto() . "' "
                . " WHERE codigo = " . $usuario->getCodigo();
        
        Conexao::executar($sql);
        
    }
    
    public static function getAllUsuarios($admin) {
        
        $sql = "SELECT codigo, nomeCompleto, nomeUsuario, email, admin, foto"
                . " FROM usuarios";
        
        if ($admin == 1) {
            
            $sql .= " WHERE admin = 1";
            
        } else if ($admin == 0) {
            
            $sql .= " WHERE admin = 0";
            
        }
        
        $result = Conexao::consultar($sql);
        
        $lista = new ArrayObject();
        
        if ($result != null) {
            
            while (list($codigo, $nomeCompleto, $nomeUsuario, $email, $admin, $foto) = mysqli_fetch_row($result)) {
                
                $usuario = new Usuario();
                $usuario->setCodigo($codigo);
                $usuario->setNomeCompleto($nomeCompleto);
                $usuario->setNomeUsuario($nomeUsuario);
                $usuario->setEmail($email);
                $usuario->setAdmin($admin);
                $usuario->setFoto($foto);
                
                $lista->append($usuario);
                
            }
        }
        
        return $lista;
        
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
    
    public static function getUsuarioByCodigo($codigo) {
        
        $sql = "SELECT codigo, nomeCompleto, nomeUsuario, senha, email, admin, foto"
                . " FROM usuarios"
                . " WHERE codigo = " . $codigo;
        
        $result = Conexao::consultar($sql);
        
        $usuario = new Usuario();
        
        if ($result != null) {
            
            list($codigo, $nomeCompleto, $nomeUsuario, $senha, $email, $admin, $foto) = mysqli_fetch_row($result); 
                
                $usuario->setCodigo($codigo);
                $usuario->setNomeCompleto($nomeCompleto);
                $usuario->setNomeUsuario($nomeUsuario);
                $usuario->setSenha($senha);
                $usuario->setEmail($email);
                $usuario->setAdmin($admin);
                $usuario->setFoto($foto);
            
        }
        
        return $usuario;
        
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
