function loginInvalido() {

    document.getElementById('spanLoginInvalido').innerHTML = 'Usuário ou senha inválidos!';
};

function validacaoUsuario(input) {
    
    if (input.value === '') {
        input.setCustomValidity('Insira o nome de usuário!');
    }

}   

function validacaoSenha(input) {
    
    if (input.value === '') {
        input.setCustomValidity('Insira a senha!');
    }

}   