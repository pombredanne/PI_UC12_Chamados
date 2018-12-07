<?php


class SalaDAO {
public static function cadastrar($sala){
    $sql = " INSERT INTO salas "
            . "(numero) VALUES"
            . "( .$sala->getNumero().)";
    
}



public static function excluir($sala){
    $sql = " DELETE FROM salas "
            . " WHERE numero = ".$sala->getNumero();
    Conexao::executar($sql);
}
public static function getSalas(){
    $sql = " SELECT numero"
            . " FROM salas "
            . " ORDER BY numero ";
    
    $result = Conexao::consultar($sql);
    $lista = new ArrayObject();
    
    while ( list($numero) = mysqli_fetch_row($result)){
        $sala = new sala();
        $sala->setNumero($numero);
        
        $lista->append($sala);
        
    }
    return $lista;
}

public static function getSalaByNumero( $numero){
    $sql = " SELECT numero"
            . " FROM salas "
            . " WHERE numero = ".$numero
            . " ORDER BY sala ";
    $result = Conexao::consultar($sql);
    list( $numero )= mysqli_fatch_row($result);
    $sala = new Sala();
    $sala->setNumero($numero);
    
    return $sala;
    
}
}
