$('#imgFile').click(function (){
    
    $('#inputFile').trigger('click');
    
});

function readURL(input) {
    
    var reader = new FileReader();
        reader.onload = function (e) {
            $('#imgFile').attr('src', e.target.result);
        };

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgFile').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$("#inputFile").change(function(){
    readURL(this);
});

$(document).on("keyup", "#inputEmail", function(){
   
    if ($(this).val().length > 0)
    {
        $("#labelEmail").css("transform", "translate(-1%,-120%)");
        $("#labelEmail").css("color", "rgb(255,140,0)");
        $("#labelEmail").css("font-size", "12px");
        $("#labelEmail").css("font-weight", "bold");
        
    }
    
    else
    {
        $("#labelEmail").css("transform", "none");
        $("#labelEmail").css("left", "12%");
        $("#labelEmail").css("top", "25%");
        $("#labelEmail").css("color", "rgba(255,140,0,.5)");
        $("#labelEmail").css("font-size", "20px");
        $("#labelEmail").css("font-weight", "normal");
    }
    
});

var verificarSenha = function(){
    
    document.getElementById('txtSenhaIncorreta').style.fontSize = '20px';
    
    if (document.getElementById('inputSenha').value ===
            document.getElementById('inputConfirmarSenha').value) {
        
        if (document.getElementById('inputSenha').value === '') {
            document.getElementById('txtSenhaIncorreta').innerHTML = '';
        } else {
            document.getElementById('txtSenhaIncorreta').style.color = 'green';
            document.getElementById('txtSenhaIncorreta').innerHTML = 'As senhas são idênticas';
        }
        
    } else {
        document.getElementById('txtSenhaIncorreta').style.color = 'red';
        document.getElementById('txtSenhaIncorreta').innerHTML = 'As senhas não coincidem!';
    }

};