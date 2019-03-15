$(document).on("keyup", "input", function () {

    var senha = $("#inputSenha").val();
    var confirmarSenha = $("#inputConfirmarSenha").val();

    $("span").css("display", "block");

    if (senha == confirmarSenha) {

        if (senha == '') {

            $("span").text("As senhas não são idênticas");
            $("span").css("color", "red");

        } else {
            $("span").text("As senhas são idênticas");
            $("span").css("color", "green");
        }

    } else {
        $("span").text("As senhas não são idênticas");
        $("span").css("color", "red");
    }

});

$(document).on("click", "button", function(){
   
    
    
});
