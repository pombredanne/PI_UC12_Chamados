<?php

class Sala {

    private $codigo, $numero, $descricao;

    function __construct($codigo = null, $numero = null, $descricao = null) {

        $this->codigo = $codigo;
        $this->numero = $numero;
        $this->descricao = $descricao;
    }

    function getNumero() {
        return $this->numero;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}
