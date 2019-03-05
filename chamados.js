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
var variavel = jQuery.parseJSON(data);
//var chaveUsuarioNomeUsuario1 = variavel.chaveUsuarioNomeUsuario1;
//            $('#lblStatus').html(data['chaveUsuarioNomeUsuario1']);
//            $('#lblStatus').html(data[0]);
//            alert(variavel.chaveChamadoAtivo1);
var string = "";
for (var i = 0; i < data.length; i++) {
    string = string + '|' + data[i];
}

alert(string);

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

};
    

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
