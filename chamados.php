<?php
session_start();

error_reporting(0);

if (isset($_SESSION['logado']) && $_SESSION['logado']) {
    include_once 'model/clsChamado.php';
    include_once 'model/clsUsuario.php';
    include_once 'model/clsSala.php';
    include_once 'dao/clsChamadoDAO.php';
    include_once 'dao/clsUsuarioDAO.php';
    include_once 'dao/clsSalaDAO.php';
    include_once 'dao/clsConexao.php';
    ?>
    <!DOCTYPE html>

    <html>
        <head>
            
            <script lang="javascript" type="text/javascript">
            
            //declarando a variável 'requisicao' como nula que será
            //responsável por armazenar o objeto de solicitação
//            var requisicao = null;
//            
//            function criarRequisicao() {
//                
//                try {
//                    
//                    //tentativa de criação do objeto de solicitação
//                    //XMLHttpRequest é o tipo do objeto de solicitação
//                    requisicao = new XMLHttpRequest();
//                    
//                } catch (excecaoInternetExplorer1) {
//                    
//                    try {
//                        
//                        //
//                        requisicao = new ActiveXObject("Msxml2.XMLHTTP");
//                        
//                    } catch (excecaoInternetExplorer2) {
//                        
//                        try {
//                            
//                            requisicao = new ActiveXObject("Microsft.XMLHTTP");
//                            
//                        } catch (falha) {
//                            
//                            //caso falhe todas tentativas de criação do objeto
//                            //de solicitação, a variavel 'requisicao' será nula
//                            requisicao = null;
//                            
//                        }
//                        
//                    }
//                    
//                }
//                
//                if (requisicao == null) {
//                    
//                    alert("Erro ao criar a requisicão do objeto!");
//                    
//                }
//                
//            }
//            
//            function getDataFromDatabase() {
//                
//                //chamando a funcao 'criarRequisicao'
//                criarRequisicao();
//                
//                //URL que será necessária para se conectar e obter os dados
//                //*deve retornar apenas o dado bruto e não um HTML
//                var url = "getDataFromDatabase-ajax.php";
//                //inicialização da conexão e informação ao objeto de
//                //solicitação de como se conectar ao banco de dados
//                request.open("GET", url, true);
//                //recebe a configuração dos valores na página, a função
//                //atualizaPagina
//                request.onreadystatechange = atualizaPagina();
//                //nenhum dado será enviado na solicitação pois o script
//                //apenas retornará o resultado esperado
//                request.send(null);                
//                
//            }
//            
//            function atualizaPagina() {
//                
//                if (requisicao.readyState == 4) {
//                    
//                    //'responseText' contém a resposta retornada do servidor
//                    var respostaServidor = requisicao.responseText;
//                    
//                }
//                
//            }
            
            </script>
            
            <meta charset="UTF-8">
            <title>chamados</title>
            
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
                  integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            
            <?php
            
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                
            ?>
            
            <link rel="stylesheet" type="text/css" href="chamadosAdmin.css">
            
            <?php
            
            } else {
                
            ?>
            
            <link rel="stylesheet" type="text/css" href="chamadosDocente.css">
            
            <?php
            
            }
            
            ?>
            
        </head>
        <body>

            <?php
            require_once 'menu.php';
            ?>
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
            <script src="chamados.js"></script>
            
            <select id="selectTodosChamados" onchange="changeUrl();">
                <option value="0">Selecione...</option>
                <option value="1">Todos chamados</option>
                <option value="2">Chamados por técnico</option>
            </select>
            
            <!--
            botoes
            -->
            
            <a href="abrirChamado.php">
                <h1 align="center"><button id="btSolicitarNovoChamado">Solicitar novo chamado</button></a></h1>
        <br><br>

        <?php
        
        if ($_GET['codigo'] == 1) {
            
        date_default_timezone_set('America/Sao_Paulo');
        echo '<h2 align="center">' . date("d/m/Y") . "</h2><br><br>";

        $lista = new ArrayObject();

        if ($_SESSION['admin'] == 0) {

            $lista = ChamadoDAO::getChamadosByUsuario($_SESSION['nomeUsuario']);

        } else {
//            mercadobitcoin
            $lista = ChamadoDAO::getChamados();

            }
                
        if ($lista->count() == 0) {
            echo '<h3><b>Nenhuma solicitação de chamado</b></h3>';
        } else {

            echo '<h3>Total de chamados: ' . $lista->count() . '</h3>';

            echo '<label>Status: </label>'
            . '<select id="selectFiltroStatus">'
            . '<option>Selecione...</option>'
            . '<option value="Em aberto">Em aberto</option>'
            . '<option value="Resolvido">Resolvido</option>'
            . '<option value="Cancelado">Cancelado</option>'
            . '</select><br><br>';
            ?> 

            <table>
                <tr>
                    <th>Número</th>
                    <th>Usuário</th>
                    <th>Sala</th>
                    <th>Descrição do problema</th>
                    <th>Status atual</th>
                    <th>Histórico de Status</th>
                    <th>Nível de criticidade</th>
                    <th>Técnico responsável</th>
                    <th>Data e hora de abertura</th>
                    <th>Data e hora de encerramento</th>
                    <th>Solução do problema</th>
                    <th>Tempo utilizado</th>
                    <th>Editar</th>
                    <th>Pausar</th>
                    <th>Cancelar</th>
                    <th>Encerrar</th>
                </tr>
        <?php
        foreach ($lista as $chamado) {

            echo '<tr>'
            . '<td>' . $chamado->getCodigo() . '</td>'
            . '<td>' . $chamado->getUsuario()->getNomeUsuario() . '</td>'
            . '<td>' . $chamado->getSala()->getNumero() . '</td>'
            . '<td>' . $chamado->getDescricaoProblema() . '</td>'
            . '<td>' . $chamado->getStatus() . '</td>'
            . '<td>' . $chamado->getHistoricoStatus() . '</td>'
            . '<td>' . $chamado->getNivelCriticidade() . '</td>';
            
            if ($chamado->getTecnicoResponsavel() != null) {
                
                echo '<td>' . $chamado->getTecnicoResponsavel()->getNomeUsuario() . '</td>';
                
            } else {
                
                echo '<td></td>';
            }
            
            echo '<td>' . $chamado->getDataHoraAbertura() . '</td>'
            . '<td></td>'
            . '<td>' . $chamado->getSolucaoProblema() . '</td>'
            . '<td></td>'
            . '<td>'
            . '<a href="abrirChamado.php?editar&codigoChamado=' . $chamado->getCodigo() . '"><button>Editar</button></a>'
            . '</td>';
            
            if ($chamado->getPausado() == 0) {
                
                echo '<td><a href="controller/salvarChamado.php?pausar&codigoChamado=' . $chamado->getCodigo() . '"><button>Pausar</button></a>'
            . '</td>';
                
            } else {
                
                echo '<td><a href="controller/salvarChamado.php?retomar&codigoChamado=' . $chamado->getCodigo() . '"><button>Retomar</button></a>'
            . '</td>';
                
            }
            
            echo '<td>'
            . '<a href="controller/salvarChamado.php?cancelar&codigoChamado=' . $chamado->getCodigo() . '"><button>Cancelar</button></a>'
            . '</td>';
            
            echo '<td>'
            . '<a href="controller/salvarChamado.php?encerrar&codigoChamado=' . $chamado->getCodigo() . '"><button>Encerrar</button></a>'
            . '</td>'
            . '</tr>';
            
        }
        ?>
            </table>
                <?php
            }
        }

        } else {
            header("Location: index.php");
        }
        ?>
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" 
integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" 
integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        
</body>
</html>
