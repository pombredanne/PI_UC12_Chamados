<?php

class Chamado {
    
    private $id, $dataHora, $descricaoProblema, $sala, $status, $usuario, $nivelCriticidade, $tecnicoResponsavel;
    
    function __construct($id = null, $dataHora = null, $descricaoProblema = null, $sala = null, $status = null, $usuario = null, $nivelCriticidade = null, $tecnicoResponsavel = null) {
        $this->id = $id;
        $this->dataHora = $dataHora;
        $this->descricaoProblema = $descricaoProblema;
        $this->sala = $sala;
        $this->status = $status;
        $this->usuario = $usuario;
        $this->nivelCriticidade = $nivelCriticidade;
        $this->tecnicoResponsavel = $tecnicoResponsavel;
    }
    
    function getTecnicoResponsavel() {
        return $this->tecnicoResponsavel;
    }

    function setTecnicoResponsavel($tecnicoResponsavel) {
        $this->tecnicoResponsavel = $tecnicoResponsavel;
    }
    
    function getNivelCriticidade() {
        return $this->nivelCriticidade;
    }

    function setNivelCriticidade($nivelCriticidade) {
        $this->nivelCriticidade = $nivelCriticidade;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function getId() {
        return $this->id;
    }

    function getDataHora() {
        return $this->dataHora;
    }

    function getDescricaoProblema() {
        return $this->decricaoProblema;
    }

    function getSala() {
        return $this->sala;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }

    function setDescricaoProblema($decricaoProblema) {
        $this->decricaoProblema = $decricaoProblema;
    }

    function setSala($sala) {
        $this->sala = $sala;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
}
