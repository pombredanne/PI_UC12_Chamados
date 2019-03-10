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

            <link rel="stylesheet" type="text/css" href="abrirChamado.css">

        </head>
        <body>

            <div id="divContainer">
                <form action="controller/salvarChamado.php?<?php echo $action; ?>" method="POST">

                    <label id="labelAberturaChamados">Abertura de chamados</label>

                    <div id="divContainerInputForm">

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
                            <textarea name="taDescricaoProblema" id="textareaDescricaoProblema" required><?php echo $descricaoProblema; ?></textarea><br><br>
                            <label id="labelTextareaDescricaoProblema">Descrição do problema</label>
                        </div>
                        <?php
                        if (isset($_GET['editar']) && $_SESSION['admin'] == 1) {
                            ?>

                            <label>Status atual:</label><br><br>
                            <textarea name="taStatusAtual" placeholder="Status atual"><?php echo $statusAtual; ?></textarea><br><br>

                            <label>Histórico de Status:</label><br><br>
                            <textarea placeholder="Histórico de Status" disabled><?php echo $historicoStatus; ?></textarea><br><br>

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

                                <label>Solução do problema:</label><br><br>
                                <textarea name="taSolucaoProblema" placeholder="Solução do Problema"><?php echo $solucaoProblema; ?></textarea><br><br>

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
