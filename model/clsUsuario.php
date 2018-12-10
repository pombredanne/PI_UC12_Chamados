<?php

class Usuario {
    
    private $codigo, $nomeCompleto, $nomeUsuario, $senha, $admin, $email;

    function __construct($codigo = null, $nomeCompleto = null, $nomeUsuario = null, $senha = null, $admin = null, $email = null) {
        
        $this->codigo = $codigo;
        $this->nomeCompleto = $nomeCompleto;
        $this->nomeUsuario = $nomeUsuario;
        $this->senha = $senha;
        $this->admin = $admin;
        $this->email = $email;
    }
    
    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getAdmin() {
        return $this->admin;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    function setNomeCompleto($nomeCompleto) {
        $this->nomeCompleto = $nomeCompleto;
    }

    function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    function setNomeUsuario($usuario) {
        $this->nomeUsuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

}