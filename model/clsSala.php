<?php

class Sala {

    private $id, $numero, $descricao;

    function __construct($id = null, $numero = null, $descricao = null) {

        $this->id = $id;
        $this->numero = $numero;
        $this->descricao = $descricao;
    }

    function getNumero() {
        return $this->numero;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}
