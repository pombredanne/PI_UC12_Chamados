<?php

class Chamado {
    
    private $codigo, $dataHora, $descricaoProblema, $sala, $status, $usuario, $nivelCriticidade, $tecnicoResponsavel, $solucaoProblema, $historicoStatus;
    
    function __construct($codigo = null, $dataHora = null, $descricaoProblema = null, $sala = null, $status = null, $usuario = null, $nivelCriticidade = null, $tecnicoResponsavel = null, $solucaoProblema = null, $historicoStatus = null) {
        $this->codigo = $codigo;
        $this->dataHora = $dataHora;
        $this->descricaoProblema = $descricaoProblema;
        $this->sala = $sala;
        $this->status = $status;
        $this->usuario = $usuario;
        $this->nivelCriticidade = $nivelCriticidade;
        $this->tecnicoResponsavel = $tecnicoResponsavel;
        $this->solucaoProblema = $solucaoProblema;
        $this->historicoStatus = $historicoStatus;
    }
    
    function getSolucaoProblema() {
        return $this->solucaoProblema;
    }

    function setSolucaoProblema($solucaoProblema) {
        $this->solucaoProblema = $solucaoProblema;
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

    function getCodigo() {
        return $this->codigo;
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

    function setCodigo($codigo) {
        $this->codigo = $codigo;
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
    
    function getHistoricoStatus() {
        return $this->historicoStatus;
    }

    function setHistoricoStatus($historicoStatus) {
        $this->historicoStatus = $historicoStatus;
    }

}
