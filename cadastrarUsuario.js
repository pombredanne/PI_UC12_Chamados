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

var enviarSenha = function() {
    
        document.getElementById('txtSenhaIncorreta').style.color = 'green';
        document.getElementById('txtSenhaIncorreta').innerHTML = 'As senhas não coincidem!';
        
};