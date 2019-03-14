<?php
error_reporting(0);

session_start();

if (isset($_SESSION['logado']) && $_SESSION['admin'] == 1) {

    include_once 'dao/clsConexao.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'model/clsUsuario.php';

    $nomeCompleto = "";
    $nomeUsuario = "";
    $admin = "";
    $email = "";
    $foto = "";
    $action = "inserir";

    if (isset($_GET['editar'])) {

        $usuario = UsuarioDAO::getUsuarioByCodigo($_GET['codigoUsuario']);

        $nomeCompleto = $usuario->getNomeCompleto();
        $nomeUsuario = $usuario->getNomeUsuario();
        $admin = $usuario->getAdmin();
        $email = $usuario->getEmail();
        $foto = $usuario->getFoto();

        $action = "editar&codigoUsuario=" . $_GET['codigoUsuario'];
    }
    ?>

    <!DOCTYPE html>

    <html>
        <head>
            <meta charset="UTF-8">
            <title>Cadastrar usuario</title>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

            <link rel="stylesheet" type="text/css" href="cadastrarUsuario.css">

        </head>

        <?php
        require_once 'menu.php';
        ?>

        <body>

            <script src="cadastrarUsuario.js"></script>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

            <div class="box">

                <h2>Cadastro de usuário</h2><br><br>

                <form action="controller/salvarUsuario.php?<?php echo $action; ?>" method="POST"
                      enctype="multipart/form-data" id="formCadastrarUsuario">

                    <div>
                        <input type="text" name="txtNomeCompleto" value="<?php echo $nomeCompleto; ?>" required>
                        <label>Nome</label><br><br>
                    </div>

                    <div>
                        <input type="text" name="txtNomeUsuario" value="<?php echo $nomeUsuario; ?>" required>
                        <label>Nome de usuário</label><br><br>
                    </div>

                    <?php
                    $checked = "";

                    if ($admin == 1)
                        $checked = "checked";
                    ?>

                    <input id="inputCheckbox" <?php echo $checked; ?> type="checkbox" name="cbAdmin">
                    <label for="inputCheckbox" id="labelAdmin">Admin</label><br><br>

                    <div>
                        <input id="inputEmail" type="email" name="txtEmail" value="<?php echo $email; ?>" required>
                        <label id="labelEmail">E-mail</label><br><br>
                    </div>

                    <?php
                    if (!isset($_GET['editar'])) {

                        $foto = "sem_foto.png";
                    }
                    ?>

                    <img id="imgFile" src="fotos/<?php echo $foto; ?>" width="200px">

                    <input type="file" name="txtFoto" id="inputFile">

                    <script src="cadastrarUsuario.js"></script>

                    <?php
                    if (!isset($_GET['editar'])) {
                        ?>

                        <div id="divSenha">
                            <input type="password" name="txtSenha" id="inputSenha" onkeyup="verificarSenha();" required>
                            <label>Senha</label><br><br>
                        </div>

                        <div>   
                            <input type="password" name="txtConfirmarSenha" id="inputConfirmarSenha" onkeyup="verificarSenha();" required>
                            <label>Confirmar senha</label><br><br>
                        </div>

                        <span id="txtSenhaIncorreta"></span>

                        <?php
                    }

                    if (isset($_GET['editar']))
                        $value = "Salvar";
                    else
                        $value = "Cadastrar";
                    ?>

                    <input type="submit" value="<?php echo $value; ?>">

                </form>

            </div>

            <script type="text/javascript" src="js-cookie/src/js.cookie.js"></script>


            <?php
        } else {
            header("Location: index.php");
        }
        ?>

    </body>

</html>
