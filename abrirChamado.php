<?php
error_reporting(0);

session_start();

if (isset($_SESSION['logado']) && $_SESSION['logado']) {

    require_once 'menu.php';

    include_once 'dao/clsConexao.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'dao/clsSalaDAO.php';
    include_once 'model/clsChamado.php';
    include_once 'model/clsUsuario.php';
    include_once 'model/clsSala.php';

    $codigoSala = 0;
    $usuario = 0;
    $descricaoProblema = "";
    $statusAtual = "";
    $historicoStatus = "";
    $nivelCriticidade = "";
    $codigoTecnicoResponsavel = 0;
    $solucaoProblema = "";
    $action = "inserir";

    if (isset($_GET['editar'])) {

        $codigoChamado = $_GET['codigoChamado'];

        $chamado = ChamadoDAO::getChamadoByCodigo($codigoChamado);

        if ($chamado->getTecnicoResponsavel() != null) {

            $codigoTecnicoResponsavel = $chamado->getTecnicoResponsavel()->getCodigo();
        }

        $codigoSala = $chamado->getSala()->getCodigo();
        $descricaoProblema = $chamado->getDescricaoProblema();
        $statusAtual = $chamado->getStatus();
        $historicoStatus = $chamado->getHistoricoStatus();
        $nivelCriticidade = $chamado->getNivelCriticidade();
        $solucaoProblema = $chamado->getSolucaoProblema();
        $action = 'editar&codigoChamado=' . $codigoChamado;
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Abertura de chamados</title>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

            <link rel="stylesheet" type="text/css" href="abrirChamado.css">

        </head>
        <body>

            <div id="divContainer">
                <form action="controller/salvarChamado.php?<?php echo $action; ?>" method="POST">

                    <label id="labelAberturaChamados">Abertura de chamados</label>

                    <div id="divContainerForm">

                        <div id="divLabelSala">
                            <label>Sala</label>
                        </div>
                        <div id="divSelectSala" class="divInput">
                            <select name="selectSala" id="selectSala">
                                <?php
                                $listaSalas = SalaDAO::getSalas();

                                if ($listaSalas->count() == 0) {

                                    echo '<option>Nenhuma sala cadastrada</option>';
                                } else {

                                    echo '<option value="0">Selecione...</option>';

                                    foreach ($listaSalas as $sala) {

                                        $selected = "";

                                        if ($sala->getCodigo() == $codigoSala) {

                                            $selected = " selected ";
                                        }

                                        echo '<option' . $selected . ' value="' . $sala->getCodigo() . '">' . $sala->getNumero() . '</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>

                        <div class="divInput" id="divTextareaDescricaoProblema">
                            <textarea name="taDescricaoProblema" id="taDescricaoProblema" required><?php echo $descricaoProblema; ?></textarea>
                            <label id="labelTextareaDescricaoProblema">Descrição do problema</label>
                        </div>
                        <?php
                        if (isset($_GET['editar']) && $_SESSION['admin'] == 1) {
                            ?>

                        <div class="divInput" id="divTextareaStatusAtual">
                            <textarea name="taStatusAtual" id="taStatusAtual" required><?php echo $statusAtual; ?></textarea>
                            <label id="labelTextareaStatusAtual">Status atual</label>
                        </div>
                            
                        <div class="divInput" id="divTextareaHistoricoStatus">
                            <textarea id="taHistoricoStatus" disabled required><?php echo $historicoStatus; ?></textarea>
                            <label id="labelTextareaHistoricoStatus">Histórico de Status</label>
                        </div>
                            
                            <?php
                        }   

                        if ($_SESSION['admin'] == 1) {
                            ?>


                            <label id="labelNivelCriticidade">Nível de criticidade</label>

                            <div class="divInput" id="divSelectNivelCriticidade">
                                <select name="selectNivelCriticidade" id="selectNivelCriticidade">
                                    <option value="">Selecione...</option>

                                    <?php
                                    $arrayNivelCriticidade = ['Leve', 'Moderado', 'Crítico'];

                                    foreach ($arrayNivelCriticidade as $itemNivelCriticidade) {

                                        $selected = "";

                                        if ($itemNivelCriticidade == $nivelCriticidade) {
                                            $selected = " selected ";
                                        }

                                        echo '<option' . $selected . ' value="' . $itemNivelCriticidade . '">' . $itemNivelCriticidade . '</option>';
                                    }
                                    ?>

                                </select>
                            </div>

                            <label id="labelTecnicoResponsavel">Técnico responsável</label>

                            <div class="divInput" id="divSelectTecnicoResponsavel">
                                <select name="selectTecnicoResponsavel" id="selectTecnicoResponsavel">

                                    <?php
                                    $listaTecnico = UsuarioDAO::getUsuarioAdmin();

                                    if ($listaTecnico->count() == 0) {

                                        echo '<option>Nenhum técnico cadastrado</option>';
                                    } else {

                                        echo '<option value="null">Selecione...</option>';

                                        foreach ($listaTecnico as $tecnico) {

                                            $selected = "";

                                            if ($tecnico->getCodigo() == $codigoTecnicoResponsavel) {

                                                $selected = " selected ";
                                            }

                                            echo '<option ' . $selected . ' value="' . $tecnico->getCodigo() . '">' . $tecnico->getNomeUsuario() . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </div>

                            <?php
                            if (isset($_GET['editar']) && $_SESSION['admin'] == 1) {
                                ?>
                            
                            <div class="divInput" id="divTextareaSolucaoProblema">
                                <textarea id="taSolucaoProblema" name="taSolucaoProblema" required><?php echo $solucaoProblema; ?></textarea>
                                <label id="labelTextareaSolucaoProblema">Solução do problema</label>
                            </div>
                                
                                <?php
                            }
                        }
                        ?>

                        <input type="submit" value="Salvar" id="btSalvar">
                    </div>
                </form>
            </div>

            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="abrirChamado.js"></script>
            
            <?php
        } else {
            header("Location: index.php");
        }
        ?>

    </body>
</html>
