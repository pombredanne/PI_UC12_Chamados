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