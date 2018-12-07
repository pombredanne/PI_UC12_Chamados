<?php

session_start();

require_once 'menu.php';

include_once 'dao/clsConexao.php';
include_once 'dao/clsChamadoDAO.php';
include_once 'dao/clsUsuarioDAO.php';
include_once 'model/clsChamado.php';
include_once 'model/clsUsuario.php';

$idChamado = 0;
$sala = "";
$descricaoProblema = "";
$dataHora = "";
$status = "";
$usuario = "";
$nivelCriticidade = "";
$tecnicoResponsavel = "";
$action = "inserir";

if (isset($_SESSION['logado']) && $_SESSION['logado']) {

    if (isset($_GET['editar'])) {

        $idChamado = $_GET['idChamado'];

        $chamado = ChamadoDAO::getChamadoById($idChamado);
        $sala = $chamado->getSala();
        $descricaoProblema = $chamado->getDescricaoProblema();
        $dataHora = $chamado->getDataHora();
        $status = $chamado->getStatus();
        $usuario = $chamado->getUsuario();
        $nivelCriticidade = $chamado->getNivelCriticidade();
        $tecnicoResponsavel = $chamado->getTecnicoResponsavel();
        $action = 'editar&idChamado=' . $idChamado;
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Cadastro de Usuário</title>
        </head>
        <body>

            <img src="fotos/logotipo_senac.jpg">

            <form action="controller/salvarChamado.php?<?php echo $action; ?>" method="POST">
                <label>Sala:</label>

                <?php
                
//                $lista = SalaDAO::getSalas();
                
                $selected = "";
                
//                foreach ($lista as $idSala) {
                    
//                    if ($idSala == $sala) {
                        
                        $selected = "selected";
                        
//                    }
//                }
                
                ?>

                <select name="selectSala" <?php echo $selected; ?>>
                    <option>Selecione...</option>
                    <option>201</option>
                    <option>308</option>
                </select><br><br>
                <label>Descrição do Problema:</label><br><br>
                <textarea name="taDescricaoProblema" placeholder="Descrição do Problema"></textarea><br><br>

                <?php
                if (isset($_GET['editar']) && $_SESSION['logado'] && $_SESSION['tipo'] != 'Docente') {
                    ?>

                    <label>Status:</label>
                    <select name="selectStatus">
                        <option>Em aberto</option>
                        <option>Resolvido</option>
                        <option>Cancelado</option>
                    </select><br><br>

                    <label>Nível de criticidade:</label>

                    <select name="selectNivelCriticidade">
                        <option>Leve</option>
                        <option>Moderado</option>
                        <option>Crítico</option>
                    </select><br><br>

                    <label>Técnico Responsável:</label>
                    <select name="selectTecnicoResponsavel">

                        <?php
                        $lista = UsuarioDAO::getUsuarioTecnico();

                        if ($lista->count() == 0) {

                            echo '<option>Nenhum técnico cadastrado</option>';
                        } else {

                            foreach ($lista as $tecnico) {

                                echo '<option value="' . $tecnico->getId() . '">' . $tecnico->getNome() . '</option>';
                            }
                        }
                        ?>

                    </select><br><br>

                    <label>Solução do problema:</label>
                    <input type="text" name="txtSolucaoProblema"><br><br>

                    <input type="submit" value="Enviar">

                </form>

                <?php
            }
        }
        ?>

    </body>
</html>
