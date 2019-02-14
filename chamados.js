function changeUrl() {
    
    //pegando o select
    var selectTodosChamados = document.getElementById("selectTodosChamados");
    //pegando o index do option selecionado no select
    var index = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;
    
    if (index == 2) {
        
        var selectTecnicos = document.getElementById("selectTecnicos");
        selectTecnicos.style.visibility = "visible";
        
    }
  
      var url = new URL(window.location.href);
    //nome da var, valor da var
    url.searchParams.set('codigo', index);
    window.location.href = url.href;
    
};
