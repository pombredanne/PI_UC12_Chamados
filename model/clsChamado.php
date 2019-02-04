<?php

class Chamado {

    private $codigo,
            $dataHoraAbertura,
            $descricaoProblema,
            $sala,
            $status,
            $usuario,
            $nivelCriticidade,
            $tecnicoResponsavel,
            $solucaoProblema,
            $historicoStatus,
            $pausar, 
            $retomar, 
            $pausado, 
            $resolvido, 
            $ativo, 
            $tempoPausado,
            $dataHoraEncerramento;

    function __construct(
            $codigo = null, 
            $dataHoraAbertura = null, 
            $descricaoProblema = null, 
            $sala = null, 
            $status = null, 
            $usuario = null, 
            $nivelCriticidade = null, 
            $tecnicoResponsavel = null, 
            $solucaoProblema = null, 
            $historicoStatus = null, 
            $pausar = null, 
            $retomar = null, 
            $pausado = null, 
            $resolvido = null, 
            $ativo = null, 
            $tempoTotal = null,
            $dataHoraEncerramento = null) {
        
        $this->codigo = $codigo;
        $this->dataHoraAbertura = $dataHoraAbertura;
        $this->descricaoProblema = $descricaoProblema;
        $this->sala = $sala;
        $this->status = $status;
        $this->usuario = $usuario;
        $this->nivelCriticidade = $nivelCriticidade;
        $this->tecnicoResponsavel = $tecnicoResponsavel;
        $this->solucaoProblema = $solucaoProblema;
        $this->historicoStatus = $historicoStatus;
        $this->pausar = $pausar;
        $this->retomar = $retomar;
        $this->pausado = $pausado;
        $this->resolvido = $resolvido;
        $this->ativo = $ativo;
        $this->tempoPausado = $tempoTotal;
        $this->dataHoraEncerramento = $dataHoraEncerramento;
    }
    
    function getDataHoraEncerramento() {
        return $this->dataHoraEncerramento;
    }

    function setDataHoraEncerramento($dataHoraEncerramento) {
        $this->dataHoraEncerramento = $dataHoraEncerramento;
    }

    function getTempoPausado() {
        return $this->tempoPausado;
    }

    function setTempoPausado($tempoPausado) {
        $this->tempoPausado = $tempoPausado;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function getResolvido() {
        return $this->resolvido;
    }

    function setResolvido($resolvido) {
        $this->resolvido = $resolvido;
    }

    function getPausado() {
        return $this->pausado;
    }

    function setPausado($pausado) {
        $this->pausado = $pausado;
    }

    function getPausar() {
        return $this->pausar;
    }

    function getRetomar() {
        return $this->retomar;
    }

    function setPausar($pausar) {
        $this->pausar = $pausar;
    }

    function setRetomar($retomar) {
        $this->retomar = $retomar;
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

    function getDataHoraAbertura() {
        return $this->dataHoraAbertura;
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

    function setDataHoraAbertura($dataHoraAbertura) {
        $this->dataHoraAbertura = $dataHoraAbertura;
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
