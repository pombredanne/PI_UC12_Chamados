function defaultIndexSelectTecnicos() {

    var url = new URL(window.location.href);
    url.searchParams.set('tecnico', 'todos');
    window.location.href = url.href;

}

function defaultIndexSelectUsuarios() {

    var url = new URL(window.location.href);
    url.searchParams.set('usuario', 'todos');
    window.location.href = url.href;

}

function defaultIndexSelectStatus() {

    var url = new URL(window.location.href);
    url.searchParams.set('status', 'todos');
    window.location.href = url.href;

}

function removeKeysUrl() {

    var selectTodosChamados = document.getElementById("selectTodosChamados");

    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;

    var url = new URL(window.location.href);
    var params = new URLSearchParams(url.search.slice(1));

//    url.searchParams.set('codigo', index);
//    url.searchParams.set('status', 'todos');
    
    if (index == 0) {
        window.location.href = 'chamados.php?codigo=' + index + '&status=todos';
    } else if (index == 1) {
        window.location.href = 'chamados.php?codigo=' + index + '&status=todos&tecnico=todos';
    } else if (index == 2) {
        window.location.href = 'chamados.php?codigo=' + index + '&status=todos&usuario=todos';
    }

}

function changeUrlSelectTodosChamados() {

    //pegando o select
    var selectTodosChamados = document.getElementById("selectTodosChamados");
    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;

    var url = new URL(window.location.href);
    //nome da var, valor da var
    url.searchParams.set('codigo', index);
    url.searchParams.set('status', 'todos');
    
    window.location.href = url.href;

    selectedOptionStatus();

}

function changeUrlSelectTecnicos() {

    var selectTecnicos = document.getElementById("selectTecnicos");
    var index = selectTecnicos.options[selectTecnicos.selectedIndex].value;

    var url = new URL(window.location.href);
    url.searchParams.set('tecnico', index);
    window.location.href = url.href;

}

function changeUrlSelectUsuarios() {

    var selectUsuarios = document.getElementById("selectUsuarios");
    var index = selectUsuarios.options[selectUsuarios.selectedIndex].value;

    var url = new URL(window.location.href);
    url.searchParams.set('usuario', index);
    window.location.href = url.href;

}

function changeUrlSelectStatus() {

    var selectStatus = document.getElementById("selectStatus");
    var index = selectStatus.options[selectStatus.selectedIndex].value;

    var url = new URL(window.location.href);
    url.searchParams.set('status', index);
    window.location.href = url.href;

}

function selectVisible() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var codigo = url.searchParams.get("codigo");

    if (codigo == 1) {

        var selectTecnicos = document.getElementById("selectTecnicos");
        selectTecnicos.style.visibility = "visible";

    } else if (codigo == 2) {

        var selectUsuarios = document.getElementById("selectUsuarios");
        selectUsuarios.style.visibility = "visible";

    }
}

function selectInvisible() {

    var divSelectTecnicos = document.getElementById("divSelectTecnicos");
    divSelectTecnicos.style.visibility = "hidden";

    var divSelectUsuarios = document.getElementById("divSelectUsuarios");
    divSelectUsuarios.style.visibility = "hidden";

}

function selectedOptionTecnicos() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var tecnico = url.searchParams.get("tecnico");

    var selectTodosChamados = document.getElementById("selectTecnicos");

    if (tecnico == null) {

        selectTodosChamados.value = 0;

    } else {

        selectTodosChamados.value = tecnico;

    }
}

function selectedOptionChamados() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var codigo = url.searchParams.get("codigo");

    var selectTodosChamados = document.getElementById("selectTodosChamados");

    if (codigo == null) {

        selectTodosChamados.value = 0;

    } else {

        selectTodosChamados.value = codigo;

    }

}

function selectedOptionUsuarios() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var usuario = url.searchParams.get("usuario");

    var selectUsuarios = document.getElementById("selectUsuarios");

    if (usuario == null) {

        selectUsuarios.value = 0;

    } else {

        selectUsuarios.value = usuario;

    }

}

function selectedOptionStatus() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var status = url.searchParams.get("status");

    var selectStatus = document.getElementById("selectStatus");

    if (status == null) {

        selectStatus.value = 0;

    } else {

        selectStatus.value = status;

    }

}
