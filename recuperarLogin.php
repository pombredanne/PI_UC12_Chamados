<?php

error_reporting(0);

session_start();
if (!$_SESSION['logado'] && !isset($_SESSION['logado'])) {

    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Recuperar login</title>

            <link rel="stylesheet" type="text/css" href="recuperarLogin.css">

        </head>
        <body>
            
            <?php
            
//        include_once './PHPMailer/src/Exception.php';
//        include_once './PHPMailer/src/PHPMailer.php';
//        include_once './PHPMailer/src/SMTP.php';
//
//        $email = new PHPMailer\PHPMailer\PHPMailer;
//        $email->isSMTP();
//        $email->Host = 'smtp.gmail.com';
//        $email->SMTPAuth = true;
//        $email->SMTPSecure = 'ssl';
//        $email->Username = 'senacinformaticapi@gmail.com';
//        $email->Password = 'senac2019Project';
//        $email->Port = 465;
//
//        $email->setFrom('senacinformaticapi@gmail.com');
//        $email->addReplyTo('senacinformaticapi@gmail.com');
//        $email->addAddress('lucas.o.silva9918@gmail.com', 'Lucas');
//
//        $email->isHTML(true);
//        $email->CharSet = 'UTF-8';
//        $email->Subject = 'Recuperação de senha';
//        $email->Body = 'lucasectos' . ', segue o link para'
//                        . ' redefinir a senha da sua conta:'
//                        . ' http://localhost/m171/PI_UC12_Chamados/novaSenha.php'
//                        . '?nomeUsuario=' . 'lucasectos';
//
//        //Texto alternativo para quem nao consegue visualizar o html
//        $email->AltBody = 'Nenhum';
//        //enviar arquivos em anexos
////        $email->addAttachment('fotos/adalto.jpg');
//
////        $email->send();
//
//        if (!$email->send()) {
//            echo 'Não foi possível enviar a mensagem';
//            echo 'Erro: ' . $email->ErrorInfo;
//        } else {
//            echo 'Mensagem enviada';
//        }
            
            ?>

            <div id="divContainerForm">
                
                <h1>Recuperação de senha</h1>

                <div>
                    <input type="text" id="inputNomeCompleto" required>
                    <label>Nome completo</label>
                </div>

                <div>
                    <input type="text" id="inputNomeUsuario" required>
                    <label>Nome de usuário</label>
                </div>

                <div>
                    <input type="email" id="inputEmail" required>
                    <label id="labelEmail">E-mail</label>
                </div>

                <span></span>
                
                <button>Verificar usuário</button>

            </div>

            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="recuperarLogin.js"></script>

        </body>
    </html>

    <?php
} else {
    header("Location: login.php");
}
