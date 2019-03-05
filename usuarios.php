<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

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
                    . '<td><img src="fotos/' . $usuario->getFoto() . '" width="50px"></td>'
                    . '<td>' . $usuario->getCodigo() . '</td>'
                    . '<td>' . $usuario->getNomeCompleto() . '</td>'
                    . '<td>' . $usuario->getNomeUsuario() . '</td>'
                    . '<td>' . $usuario->getEmail() . '</td>'
                    . '<td>' . $usuario->getAdmin() . '</td>'
                    . '<td>'
                    . '<a href="cadastrarUsuario.php?editar&codigoUsuario='
                    . $usuario->getCodigo() . '">Editar</a>'
                    . '</td>'
                    . '<td>'
                    . '<a href="controller/salvarUsuario.php?excluir&codigoUsuario='
                    . $usuario->getCodigo() . '">Excluir</a>'
                    . '</td>'
                    . '</tr>';
                }
            }
            ?>

        </table>
        
        <script src="salas.js"></script>

    </body>
</html>
