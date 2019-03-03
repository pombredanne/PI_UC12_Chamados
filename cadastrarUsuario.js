function onload(){
   window.location.href = 'loading.php';
};

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

var inputFile = document.getElementById('inputFile');
var labelFile = document.getElementById('labelFile');

inputFile.addEventListener('change', function() {
    
    labelFile.textContent = this.files[0].name;
    labelFile.style.backgroundColor = "1E64FF";
    
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

//var enviarSenha = function() {
//    
//        document.getElementById('txtSenhaIncorreta').style.color = 'green';
//        document.getElementById('txtSenhaIncorreta').innerHTML = 'As senhas não coincidem!';
//        
//};