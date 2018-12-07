<?php


class clsSalas {
    private $numero;
    
    function __construct($numero = NULL) {
        
    
    $this->numero = $numero;
    }
    
    function getNumero() {
        return $this->numero;
    
    }
    function setNumero($numero) {
        $this->numero = $numero;
    }



   
}
