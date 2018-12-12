<?php

class FakeTecnicoResponsavel {
    
    private $codigo, $nomeCompleto;
    
    function __construct($codigo = null, $nomeCompleto = null) {
        $this->codigo = $codigo;
        $this->nomeCompleto = $nomeCompleto;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNomeCompleto() {
        return $this->nomeCompleto;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNomeCompleto($nome) {
        $this->nomeCompleto = $nome;
    }

}
