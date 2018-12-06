<?php

class Usuario {
    
    private $id, $nome, $nomeUsuario, $senha, $admin, $tipo;

    function __construct($id = null, $nome = null, $nomeUsuario = null, $senha = null, $admin = null, $tipo = null) {
        
        $this->id = $id;
        $this->nome = $nome;
        $this->nomeUsuario = $nomeUsuario;
        $this->senha = $senha;
        $this->admin = $admin;
    }
    
    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function getAdmin() {
        return $this->admin;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNomeUsuario($usuario) {
        $this->nomeUsuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

}