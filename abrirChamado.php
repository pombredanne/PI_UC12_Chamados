<?php

error_reporting(0);

if (!isset($_COOKIE['redirect'])) {
    
    setcookie('redirect', 'abrirChamado.php', time() + 20);

?>

<script src="abrirChamado.js"></script>

<script>

    onload();

</script>

<?php

} else {
    setcookie('redirect', '', time() - 3600);
    unset($_COOKIE['redirect']);
}

?>

<?php

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
            <title>Cadastro de Usuário</title>

            <link rel="stylesheet" type="text/css" href="abrirChamado.css">

        </head>
        <body>

                <!--<img src="fotos/logotipo_senac.jpg">-->

            <form action="controller/salvarChamado.php?<?php echo $action; ?>" method="POST">

                <label>Sala:</label>
                <select name="selectSala">

                    <?php
                    $listaSalas = SalaDAO::getSalas();

                    if ($listaSalas->count() == 0) {

                        echo '<option>Nenhuma sala cadastrada</option>';
                    } else {

                        echo '<option>Selecione...</option>';

                        foreach ($listaSalas as $sala) {

                            $selected = "";

                            if ($sala->getCodigo() == $codigoSala) {

                                $selected = " selected ";
                            }

                            echo '<option' . $selected . ' value="' . $sala->getCodigo() . '">' . $sala->getNumero() . '</option>';
                        }
                    }
                    ?>

                </select><br><br>

                <label>Descrição do Problema:</label><br><br>
                <textarea name="taDescricaoProblema" placeholder="Descrição do Problema"><?php echo $descricaoProblema; ?></textarea><br><br>

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

                    <label>Nível de criticidade:</label>
                    <select name="selectNivelCriticidade">
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

                    </select><br><br>

                    <label>Técnico Responsável:</label>
                    <select name="selectTecnicoResponsavel">

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

                    </select><br><br>

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

            </form>

    <?php
} else {
    header("Location: index.php");
}
?>

    </body>
</html>
