$(document).ready(function () {

    $("#divMenuToogle").click(function () {

        $("nav").toggleClass('active');
        $("i").toggleClass('fa-times');
    });

    $('ul li').hover(function () {

//       Faz com que não seja possível ter 2 submenu ativados
//       ao mesmo tempo
        $(this).siblings().removeClass('active');
        $(this).toggleClass('active');

    });

    if (document.URL.indexOf("salas") != -1)
    {
        $("#aSalas").css("backgroundColor", "#1E64FF");
        $("#aSalas").css("color", "white");
    } else if (document.URL.indexOf("cadastrarSala") != -1)
    {
        $("#aSalas").css("backgroundColor", "#1E64FF");
        $("#aSalas").css("color", "white");
        $("#aCadastrarSala").css("backgroundColor", "#1E64FF");
        $("#aCadastrarSala").css("color", "white");
    } else if (document.URL.indexOf("chamados") != -1)
    {
        $("#aChamados").css("backgroundColor", "#1E64FF");
        $("#aChamados").css("color", "white");
    } else if (document.URL.indexOf("abrirChamado") != -1)
    {
        $("#aChamados").css("backgroundColor", "#1E64FF");
        $("#aChamados").css("color", "white");
        $("#aAbrirChamado").css("backgroundColor", "#1E64FF");
        $("#aAbrirChamado").css("color", "white");
    } else if (document.URL.indexOf("usuarios") != -1)
    {
        $("#aUsuarios").css("backgroundColor", "#1E64FF");
        $("#aUsuarios").css("color", "white");
    } else if (document.URL.indexOf("cadastrarUsuario") != -1)
    {
        $("#aUsuarios").css("backgroundColor", "#1E64FF");
        $("#aUsuarios").css("color", "white");
        $("#aCadastrarUsuario").css("backgroundColor", "#1E64FF");
        $("#aCadastrarUsuario").css("color", "white");
    }

});