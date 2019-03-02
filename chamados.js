function changeUrlSelectTodosChamados() {

    var selectTodosChamados = document.getElementById("selectTodosChamados");

    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;

    var baseUrl = 'chamados.php?codigo=' + index + '&status=todos';

    if (index == 0) {
        window.location.href = baseUrl;
    } else {

        baseUrl = baseUrl + '&usuario=todos';

        if (index == 1) {
            window.location.href = baseUrl + '&tipo=tecnico';
        } else if (index == 2) {
            window.location.href = baseUrl + '&tipo=docente';
        }
    }
    
}

function changeUrlSelectTecnicosUsuarios() {

    var selectTecnicosUsuarios = document.getElementById("selectTecnicosUsuarios");
    var index = selectTecnicosUsuarios.options[selectTecnicosUsuarios.selectedIndex].value;

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

    if (codigo != 0) {

        var selectTecnicosUsuarios = document.getElementById("divSelectTecnicosUsuarios");
        selectTecnicosUsuarios.style.display = "block";    

    }

}

function selectInvisible() {

    var divSelectTecnicosUsuarios = document.getElementById("divSelectTecnicosUsuarios");
    divSelectTecnicosUsuarios.style.display = "none";

}

function selectedOptionTecnicosUsuarios() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var tecnicoUsuario = url.searchParams.get("usuario");

    var selectTecnicosUsuarios = document.getElementById("selectTecnicosUsuarios");

    if (tecnicoUsuario == null) {

        selectTecnicosUsuarios.value = 'todos';

    } else {

        selectTecnicosUsuarios.value = tecnicoUsuario;

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

function selectedOptionStatus() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var status = url.searchParams.get("status");

    var selectStatus = document.getElementById("selectStatus");

    if (status == null) {

        selectStatus.value = 'todos';

    } else {

        selectStatus.value = status;

    }

}
