<?php

include_once 'clsConexao.php';

class ChamadoDAO {

    public static function inserir($chamado) {

        $sql = "INSERT INTO chamados (sala, descricaoProblema, dataHora, status, usuario)"
                . " VALUES"
                . "("
                . " '" . $chamado->getSala() . "' , "
                . " '" . $chamado->getDescricaoProblema() . "' , "
                . " '" . $chamado->getDataHora() . "' , "
                . " '" . $chamado->getStatus() . "' , "
                . " '" . $chamado->getUsuario() . "' "
                . ");";

        Conexao::executar($sql);
    }
public static function getChamados(){
    $sql = " SELECT id, sala, DescricaoProblema, datahora, status, usuario "
            . " FROM chamados "
            . " ORDER BY datahora DESC ";
    
    $result = Conexao::consultar(sql);
    $lista = ArrayObject();
    
    while ( $list( $sala, $descricaodoproblema, $datahora, $status, $usuario)
            = mysqli_fetch_row($result)){
        $chamado = new Chamado();
        $chamado->setId($id);
        $chamado->getSala($sala);
        $chamado->setDescricaoProblema($decricaoProblema);
        $chamado->getDataHora($datahora);
        $chamado->setStatus($status);
        $chamado->setUsuario($usuario);
        
        $lista->append($chamado);
    }
    return $lista;
    
    
}
public static function getChamadoById( $id ){
		$sql = " SELECT p.id, p.nome, p.foto, p.preco, p.quantidade, c.id, c.nome "
		. " FROM chamados "
		. "ORDER BY datahora ";
                
                

}
}