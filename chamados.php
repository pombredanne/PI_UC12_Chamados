<?php
session_start();
if(isset($_SESSION['logado']) && $_SESSION['logado']){
    include_once 'model/clsChamado.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsConexao.php';
    ?>
<!DOCTYPE html>

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>chamados</title>
    </head>
    <body>
        
        <?php
            require_once 'menu.php';
        ?>
        <h1 align="center">Chamdos</h1>
        <br><br>
        <a href="abrirChamado.php">
            <h1 align="center"><button>Solicitar novo chamado<</button></a></h1>
        <br><br>
        
        <?php
            
        $lista = ChamadoDAO::getChamados();
        if($lista->count() ==0){
        echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
        } else {
       ?> 
        
            <table border="2"
            <tr>
            <th>Número do chamado</th>
            <th>Usuario</th>
            <th>Sala</th>
            <th>Descrição do problema</th>
            <th>Status</th>
            <th>Data e Hora</th>
            </tr>
        <?php
            foreach ($lista as $cha){
                
           echo '<tr> ';
           echo ' <td>'.$cha->getId().'</td>' ;
           echo '<td>'.$cha->getUsuario().'</td>';
          echo '<td>'.$cha->getSala().'</td>';
          echo '<td>'.$cha->getDescricaoProblema().'</td>';
          echo '<td>'.$cha->getStatus().'</td>';
          echo '<td>'.$cha->getDataHora().'</td>';
             
            }
            
	 echo '   <td><a href="abrirChamado.php?editar&IdChamado='.$cha->getid().'" ><button> Editar</button></a></td>';  
echo '</tr>';

            
        }
        ?>
            </table>
        <?php
}
?>
    </body>
</html>
