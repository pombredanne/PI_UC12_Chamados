<?php
session_start();

if ($_SESSION['logado'] == true && $_SESSION['admin'] == 1) {
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Usuários</title>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

            <link rel="stylesheet" type="text/css" href="usuarios.css">

        </head>

    <?php
    error_reporting(0);

    require_once 'menu.php';

    include_once 'dao/clsConexao.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'model/clsUsuario.php';
    ?>

        <body>

            <button id="btCadastrarUsuario"><a href="cadastrarUsuario.php">Cadastrar usuário</a></button>

            <table border="1">
                <th>Foto</th>
                <th>Código</th>
                <th>Nome completo</th>
                <th>Nome de usuário</th>
                <th>E-mail</th>
                <th>Administrador</th>
                <th>Editar</th>
                <th>Excluir</th>

    <?php
//          valor default pra diferenciar do 0 ou 1
    $admin = 2;

    $lista = UsuarioDAO::getAllUsuarios($admin);

    if ($lista->count() < 0) {

        echo '<h1><b>Nenhum usuário cadastrado!</b></h1>';
    } else {

        foreach ($lista as $usuario) {

            echo '<tr>'
            . '<td><img src="fotos/' . $usuario->getFoto() . '"></td>'
            . '<td class="tdPadding" id="tdCodigo">' . $usuario->getCodigo() . '</td>'
            . '<td class="tdPadding">' . $usuario->getNomeCompleto() . '</td>'
            . '<td class="tdPadding" id="tdNomeUsuario">' . $usuario->getNomeUsuario() . '</td>'
            . '<td class="tdPadding">' . $usuario->getEmail() . '</td>'
            . '<td class="tdPadding">' . $usuario->getAdmin() . '</td>'
            . '<td class="tdFakeButton" id="tdEditar">Editar</td>'
            . '<td class="tdFakeButton" id="tdExcluir">Excluir</td>'
            . '</tr>';
        }
    }
    ?>

            </table>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="usuarios.js"></script>

            <div id="divContainerAlert">
                <h1>Excluir o usuário <span id="spanAlert"></span>?</h1>

                <button id="buttonAlertCancelar">
                    <i class="fas fa-times"></i>
                    <label>Cancelar</label></button>

                <button id="buttonAlertConfirmar">
                    <i class="fas fa-check"></i>
                    <label>Excluir</label></button>

            </div>

            <div class="divError">
                <label>O usuário <span id="spanError"></span> já pertence a um chamado!</label>
                <i class="fas fa-times"></i>
                <button id="buttonError">Fechar</button>
            </div>

    <?php
} else {

    header("Location: chamados.php");
}
?>

    </body>
</html>
