<?php

class Conexao {

    private static function abrir() {

//        $nome = "m171_05_chamados";
//        $local = "senacinfo-db";
//        $usuario = "inf_m171";
//        $senha = "senacrs";
        
        $nome = "chamados_m171";
        $local = "localhost";
        $usuario = "root";
        $senha = "";

        $conn = mysqli_connect($local, $usuario, $senha, $nome);

        if ($conn)
            return $conn;
        else
            return null;
    }

    private static function fechar($conn) {
        mysqli_close($conn);
    }

    public static function executar($sql) {

        $conn = self::abrir();

        if ($conn) {
            $query = mysqli_query($conn, $sql);
            self::fechar($conn);
            
            if ($query) {
                return true;
            } else {
                return false;
            }
            
        }
        
    }

    public static function consultar($sql) {

        $conn = self::abrir();

        if ($conn) {

            $result = mysqli_query($conn, $sql);
            self::fechar($conn);
            return $result;
        } else {

            return null;
        }
    }

}
