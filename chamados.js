//$( document ).ready(function() {
//    
//    var scrollPosition = $.cookie('scrollPosition');
//    
//    if (scrollPosition) {
//        
//        $(window).scrollTop(scrollPosition);
//        $.removeCookie('scrollPosition');
//    }
//    
//});

function ajax() {
//    var selectStatus = document.getElementById("selectStatus");
//    var index = selectStatus.options[selectStatus.selectedIndex].value;
//    
//    if (select === 'selectStatus') {
//        Cookies.set('select', 'selectStatus');
//        Cookies.set('status', index);
//    }
//
//    window.location.reload();

    $.ajax({
        type: 'POST',
        url: "functions.php",
        datatype: 'json',
        success: function (data) {
//            data = data.split(',');
            var dataKeys = jQuery.parseJSON(data);
//var chaveUsuarioNomeUsuario1 = variavel.chaveUsuarioNomeUsuario1;
//            $('#lblStatus').html(data['chaveUsuarioNomeUsuario1']);
//            $('#lblStatus').html(data[0]);
//            alert(variavel.chaveChamadoAtivo1);

            var chaveChamadoCodigo = 'chaveChamadoCodigo';
            var chaveChamadoDataHoraAbertura = 'chaveChamadoDataHoraAbertura';
            var chaveChamadoDescricaoProblema = 'chaveChamadoDescricaoProblema';
            var chaveChamadoStatus = 'chaveChamadoStatus';
            var chaveChamadoHistoricoStatus = 'chaveChamadoHistoricoStatus';
            var chaveChamadoNivelCriticidade = 'chaveChamadoNivelCriticidade';
            var chaveChamadoSolucaoProblema = 'chaveChamadoSolucaoProblema';
            var chaveChamadoPausar = 'chaveChamadoPausar';
            var chaveChamadoRetomar = 'chaveChamadoRetomar';
            var chaveChamadoPausado = 'chaveChamadoPausado';
            var chaveChamadoResolvido = 'chaveChamadoResolvido';
            var chaveChamadoAtivo = 'chaveChamadoAtivo';

            var chaveTecnicoCodigo = 'chaveTecnicoCodigo';
            var chaveTecnicoNomeUsuario = 'chaveTecnicoNomeUsuario';

            var chaveUsuarioCodigo = 'chaveUsuarioCodigo';
            var chaveUsuarioNomeUsuario = 'chaveUsuarioNomeUsuario';

            var chaveSalaCodigo = 'chaveSalaCodigo';
            var chaveSalaNumero = 'chaveSalaNumero';

            var allTds = "";

            for (var i = 0; i < dataKeys.length; i++) {

                let tr = "<tr>";
                tr += +"<td>" + dataKeys['chaveChamadoCodigo0'] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoDataHoraAbertura + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoDescricaoProblema + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoStatus + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoHistoricoStatus + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoNivelCriticidade + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoSolucaoProblema + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoPausar + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoRetomar + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoPausado + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoResolvido + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveChamadoAtivo + i] + "</td>";
//    
//    tr += "<td>" + dataKeys[chaveTecnicoCodigo + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveTecnicoNomeUsuario + i] + "</td>";
//    
//    tr += "<td>" + dataKeys[chaveUsuarioCodigo + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveUsuarioNomeUsuario + i] + "</td>";
//    
//    tr += "<td>" + dataKeys[chaveSalaCodigo + i] + "</td>";
//    tr += "<td>" + dataKeys[chaveSalaNumero + i] + "</td>";

                tr += "</tr>";

                allTds += tr;

                document.createElement('td');
                document.getElementsByTagName("td")[i].innerHTML = 'sss';

            }

            var divTable = document.getElementById("divTable");

            var table = document.createElement('table');
            table.border = '1';

  var tableHeader = document.createElement('thead');
  table.appendChild(tableHeader);
  
  var tr = document.createElement('tr');
    tableHeader.appendChild(tr);
  
  for (var i = 0; i < 13; i++) {
      
      var th = document.createElement('th');
//      th.
      
  }
  
  
  th.appendChild('Número');
  th.appendChild('Usuário');
  th.appendChild('Sala');
  th.appendChild('Descrição do problema');
  th.appendChild('Status atual');
  th.appendChild('Histórico de status');
  th.appendChild('Nível de criticidade');
  th.appendChild('Técnico responsável');
  th.appendChild('Data e hora de abertura');
  th.appendChild('Editar');
  th.appendChild('Pausar/Retomar');
  th.appendChild('Cancelar');
  th.appendChild('Encerrar');

            var tableBody = document.createElement('tbody');
            table.appendChild(tableBody);

            for (var i = 0; i < dataKeys.rows; i++) {

                var tr = document.createElement('tr');
                tableBody.appendChild(tr);

                for (var j = 0; j < 13; j++) {

                    var td = document.createElement('td');
                    td.appendChild(document.createTextNode(dataKeys.chaveUsuarioNomeUsuario1));
                    tr.appendChild(td);

                }
            }
            divTable.appendChild(table);

//var string = "";
//for (var i = 0; i < data.length; i++) {
//    string = string + data[i];
//}
//
//alert(dataKeys.chaveUsuarioNomeUsuario1);

//            alert(data[0] + data[1]+ data[2]+ data[3]+ data[4]
//                    + data[5]+ data[6]+ data[7]+ data[8]+ data[9]);
//            console.log(variavel.chaveChamadoAtivo1);
//            console.log(chaveUsuarioNomeUsuario1);
//console.log(data);

        }
    });

//xhttp = new XMLHttpRequest();
//xhttp.onreadystatechange = function () {
//    document.getElementById("btSolicitarNovoChamado").innerHTML = this.responseText;
//};
//
//xhttp.open("GET", "functions.php?index=" + index, true);
//xhttp.send();

}
;


//function changeUrlSelectTodosChamados() {
//
//    var selectTodosChamados = document.getElementById("selectTodosChamados");
//
//    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;
//
//    var baseUrl = 'chamados.php?codigo=' + index + '&status=todos';
//
//    if (index == 0) {
//        window.location.href = baseUrl;
//    } else {
//
//        baseUrl = baseUrl + '&usuario=todos';
//
//        if (index == 1) {
//            window.location.href = baseUrl + '&tipo=tecnico';
//        } else if (index == 2) {
//            window.location.href = baseUrl + '&tipo=docente';
//        }
//    }
//    
//}
//
//function changeUrlSelectTecnicosUsuarios() {
//
//    var selectTecnicosUsuarios = document.getElementById("selectTecnicosUsuarios");
//    var index = selectTecnicosUsuarios.options[selectTecnicosUsuarios.selectedIndex].value;
//
//    var url = new URL(window.location.href);
//    
//    url.searchParams.set('usuario', index);
//    window.location.href = url.href;
//
//}

//function getCookie() {
//    setando no cookie antes de recarregar a página pra
//    salvar o ponto de 'scroll' na página
//    $.cookie('scrollPosition', $(window).scrollTop());
//}
//
//function changeUrlSelectStatus() {
//
//    var selectStatus = document.getElementById("selectStatus");
//    var index = selectStatus.options[selectStatus.selectedIndex].value;
//
//    var url = new URL(window.location.href);
//    url.searchParams.set('status', index);
//    
//    window.location.href = url.href;
//
//}
//
//function selectVisible() {
//
//    var urlString = window.location.href;
//
//    var url = new URL(urlString);
//
//    var codigo = url.searchParams.get("codigo");
//
//    if (codigo != 0) {
//
//        var selectTecnicosUsuarios = document.getElementById("divSelectTecnicosUsuarios");
//        selectTecnicosUsuarios.style.display = "block";    
//
//    }
//
//}
//
//function selectInvisible() {
//
//    var divSelectTecnicosUsuarios = document.getElementById("divSelectTecnicosUsuarios");
//    divSelectTecnicosUsuarios.style.display = "none";
//
//}
//
//function selectedOptionTecnicosUsuarios() {
//
//    var urlString = window.location.href;
//
//    var url = new URL(urlString);
//
//    var tecnicoUsuario = url.searchParams.get("usuario");
//
//    var selectTecnicosUsuarios = document.getElementById("selectTecnicosUsuarios");
//
//    if (tecnicoUsuario == null) {
//
//        selectTecnicosUsuarios.value = 'todos';
//
//    } else {
//
//        selectTecnicosUsuarios.value = tecnicoUsuario;
//
//    }
//}
//
//function selectedOptionChamados() {
//
//    var urlString = window.location.href;
//
//    var url = new URL(urlString);
//
//    var codigo = url.searchParams.get("codigo");
//
//    var selectTodosChamados = document.getElementById("selectTodosChamados");
//
//    if (codigo == null) {
//
//        selectTodosChamados.value = 0;
//
//    } else {
//
//        selectTodosChamados.value = codigo;
//
//    }
//
//}
//
//function selectedOptionStatus() {
//
//    var urlString = window.location.href;
//
//    var url = new URL(urlString);
//
//    var status = url.searchParams.get("status");
//
//    var selectStatus = document.getElementById("selectStatus");
//
//    if (status == null) {
//
//        selectStatus.value = 'todos';
//
//    } else {
//
//        selectStatus.value = status;
//
//    }
//
//}
