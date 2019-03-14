$(document).on("keyup", "#inputEmail", function(){
   
    if ($(this).val().length > 0)
    {
        $("#labelEmail").css("transform", "translate(-5%,-120%)");
        $("#labelEmail").css("color", "rgb(255,140,0)");
        $("#labelEmail").css("font-size", "12px");
        $("#labelEmail").css("font-weight", "bold");
        
    }
    
    else
    {
        
        $("#labelEmail").css("transform", "none");
        $("#labelEmail").css("left", "8%");
        $("#labelEmail").css("top", "35%");
        $("#labelEmail").css("color", "rgba(255,140,0,.5)");
        $("#labelEmail").css("font-size", "20px");
        $("#labelEmail").css("font-weight", "normal");
    }
    
});

$(document).on("click", "button", function(){
   
   var nomeCompleto = $("#inputNomeCompleto").val();
   var nomeUsuario = $("#inputNomeUsuario").val();
   var email = $("#inputEmail").val();
   
    $.ajax({
        type: 'GET',
        url: 'functions.php?recuperarLogin&nomeCompleto='
            + nomeCompleto + '&nomeUsuario=' + nomeUsuario
            + '&email=' + email,
        datatype: 'json',
        success: function (data) {
            
            var json = jQuery.parseJSON(data);
            
            if (json == false) {
                $("span").css("display", "block");
            } else {
                $("span").css("display", "none");
            }
            
        }
    });
    
});