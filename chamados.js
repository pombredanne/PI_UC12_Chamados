function removeKeysUrl() {

    var antigaUrl = new URL(window.location.href);

    var novaUrl = antigaUrl.substring(0, antigaUrl.indexOf('?'));

//var novaUrl = antigaUrl.split('?')[0];

    window.location.href = novaUrl.href;
//var selectTecnicos = document.getElementById("selectTecnicos");
//    selectTecnicos.style.visibility = "hidden";

}

function changeUrlSelectTodosChamados() {

    //pegando o select
    var selectTodosChamados = document.getElementById("selectTodosChamados");
    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;

    var url = new URL(window.location.href);
    //nome da var, valor da var
    url.searchParams.set('codigo', index);
    window.location.href = url.href;

}

function changeUrlSelectTecnicos() {

    var selectTecnicos = document.getElementById("selectTecnicos");
    var index = selectTecnicos.options[selectTecnicos.selectedIndex].value;

    var url = new URL(window.location.href);
    url.searchParams.set('tecnico', index);
    window.location.href = url.href;

}

function selectVisible() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var codigo = url.searchParams.get("codigo");

    if (codigo == 2) {

        var selectTecnicos = document.getElementById("selectTecnicos");
        selectTecnicos.style.visibility = "visible";

    }
}

function selectInvisible() {

    var selectTecnicos = document.getElementById("selectTecnicos");
    selectTecnicos.style.visibility = "hidden";

}

function selectedOptionTecnicos() {

    var urlString = window.location.href;

    var url = new URL(urlString);

    var codigo = url.searchParams.get("tecnico");

    var selectTodosChamados = document.getElementById("selectTecnicos");

    if (codigo == null) {

        selectTodosChamados.value = 0;

    } else {

        selectTodosChamados.value = codigo;

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
