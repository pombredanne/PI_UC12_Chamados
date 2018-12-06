<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form action="controller/salvarUsuario.php?inserir" method="POST">

            <?php
            session_start();

if (isset($_SESSION['logado']) && $_SESSION['admin'] == 1) {

            echo '<input type="checkbox" name="cbAdmin">'
            . '<label>Admin</label><br><br>';
}
            ?>

            <label>Nome:</label>
            <input type="text" name="txtNome"><br><br>

            <label>Usuário:</label>
            <input type="text" name="txtUsuario"><br><br>

            <label>Tipo de usuário:</label>
            <select name="selectTipoUsuario">
                <option>Selecione...</option>
                <option>Docente</option>
                <option>Gerenciamento</option>
                <option>Técnico</option>
            </select><br><br>

            <label>Senha:</label>
            <input type="password" name="txtSenha"><br><br>

            <input type="submit" value="Cadastrar">
        </form>

    </body>
</html>
