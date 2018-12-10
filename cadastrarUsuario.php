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

            <label>Nome de usuário:</label>
            <input type="text" name="txtNomeUsuario"><br><br>
            
            <label>E-mail:</label>
            <input type="email" name="txtEmail"><br><br>

            <label>Senha:</label>
            <input type="password" name="txtSenha"><br><br>

            <input type="submit" value="Cadastrar">
        </form>

    </body>
</html>
