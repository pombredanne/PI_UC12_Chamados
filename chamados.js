//$(document).ready(function () {
//
//    $("#botaoTeste").click(function () {
//
//        $.ajax({url: "demo_texto.txt", async: false, success: function (resultado) {
//    
//                $("#divTeste").html(resultado);
//    
//            }});
//    });
//});

function changeUrl() {
    
    //pegando o select
    var selectTodosChamados = document.getElementById("selectTodosChamados");
    //pegando o index do option selecionado no select
    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;
  
      var url = new URL(window.location.href);
    //nome da var, valor da var
    url.searchParams.set('codigo', index);
    window.location.href = url.href;
      
};