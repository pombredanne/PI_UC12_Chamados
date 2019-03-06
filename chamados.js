$(document).ready(function () {

    $('#selectTecnicosUsuarios').empty().append('<option value="todos">Todos</option>');

    ajax();

});

$(document).on('click', '.btEditar', function () {

    var row = $(this).closest("tr");
    var tdText = row.find(".tdCodigo").text();

    window.location.href = 'abrirChamado.php?editar&codigoChamado=' + tdText;


});

$(document).on('click', '.btPausarRetomar', function () {

    var row = $(this).closest("tr");
    var tdText = row.find(".tdCodigo").text();



    window.location.href = 'controller/salvarChamado.php?verificadorPausarRetomar&codigoChamado=' + tdText;

});

$(document).on('click', '.btCancelar', function () {

    var row = $(this).closest("tr");
    var tdText = row.find(".tdCodigo").text();

    window.location.href = 'controller/salvarChamado.php?cancelar&codigoChamado=' + tdText;

});

$(document).on('click', '.btEncerrar', function () {

    var row = $(this).closest("tr");
    var tdText = row.find(".tdCodigo").text();

    window.location.href = 'controller/salvarChamado.php?encerrar&codigoChamado=' + tdText;

});

$(document).on('change', 'select', function () {

    ajax();

});

function ajax() {

    var selectTodosChamados = document.getElementById("selectTodosChamados");
    var selectStatus = document.getElementById("selectStatus");
    var selectTecnicosUsuarios = document.getElementById("selectTecnicosUsuarios");

    var indexSelectTodosChamados = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;
    var indexSelectStatus = selectStatus.options[selectStatus.selectedIndex].value;
    var indexSelectTecnicosUsuarios = selectTecnicosUsuarios.options[selectTecnicosUsuarios.selectedIndex].value;

    var divSelectTecnicosUsuarios = document.getElementById("divSelectTecnicosUsuarios");

    if (indexSelectTodosChamados == 0) {

        divSelectTecnicosUsuarios.style.display = "none";

    } else {

        divSelectTecnicosUsuarios.style.display = "block";

    }

    $.ajax({
        type: 'GET',
        url: "functions.php?indexSelectTodosChamados=" + indexSelectTodosChamados
                + "&indexSelectStatus=" + indexSelectStatus
                + "&indexSelectTecnicosUsuarios=" + indexSelectTecnicosUsuarios,
        datatype: 'json',
        success: function (data) {

            var dataKeys = jQuery.parseJSON(data);

            createTable(dataKeys);

            if (indexSelectTodosChamados != 0)
                fillSelectTecnicosUsuarios(dataKeys);

//            setLabelTecnicosUsuarios(data);

        }
    });

}
;

function setLabelTecnicosUsuarios(data)
{
}

function fillSelectTecnicosUsuarios(dataKeys)
{

    var selectTodosChamados = document.getElementById("selectTodosChamados");
    var indexSelectTodosChamados = selectTodosChamados.options[selectTodosChamados.selectedIndex].value;

    var selected = 'todos';
    
    //verficicao inacabd  pra quando ta selecionado o chamados por tecnico/usuario
    //e ta selecionado no o utro select um tecnico/usuario e muda o
    //selecttodoschamados de chamados por tecnico pra chamados por usuario
    //ou vice versa
    
    if (dataKeys['chaveUsuarioAdmin'] == 1 && indexSelectTodosChamados == 1
            || dataKeys['chaveUsuarioAdmin'] == 0 && indexSelectTodosChamados == 2) {
        
        var row = $("table").children("tbody").children("tr:first");
        var tdText = row.find(".tdNomeUsuario").text();
    
        if (dataKeys.includes(tdText) == true) {
            selected = $("#selectTecnicosUsuarios").val();
        }
            
    }
    
//    alert(dataKeys['chaveUsuarioAdmin'] + indexSelectTodosChamados);

    $('#selectTecnicosUsuarios').empty().append('<option value="todos">Todos</option>');

    for (let i = 0; i < dataKeys.countUsuarios; i++)
    {

        let option = '<option value="' + dataKeys['chaveTecnicosUsuarios' + i] + '">'
                + dataKeys['chaveTecnicosUsuarios' + i] + '</option>';

        $('#selectTecnicosUsuarios').append(option);

    }

    $("#selectTecnicosUsuarios option").removeAttr('selected')
        .filter('[value=' + selected + ']')
        .attr('selected', true);

}

function createTable(dataKeys)
{

    var divTable = document.getElementById("divTable");

    $("table").remove();

    var table = document.createElement('table');

    var tableHeader = document.createElement('thead');
    table.appendChild(tableHeader);

    var tr = document.createElement('tr');
    tableHeader.appendChild(tr);

    var ths = new Array('Número', 'Usuário', 'Sala', 'Descrição do problema',
            'Status atual', 'Histórico de status', 'Nível de criticidade',
            'Técnico responsável', 'Data e hora de abertura', 'Editar',
            'Pausar/Retomar', 'Cancelar', 'Encerrar');

    for (let i = 0; i < ths.length; i++) {

        let th = document.createElement('th');
        th.appendChild(document.createTextNode(ths[i]));
        tr.appendChild(th);

    }

    var tableBody = document.createElement('tbody');
    table.appendChild(tableBody);

    var cont = 0;

    for (let i = 0; i < dataKeys.countRows; i++) {

        let tr = document.createElement('tr');
        tableBody.appendChild(tr);

        for (let j = 0; j < 1; j++) {

            let arrayTds = new Array('tdChamadoCodigo', 'tdUsuarioNomeUsuario',
                    'tdSalaNumero', 'tdChamadoDescricaoProblema', 'tdChamadoStatus',
                    'tdChamadoHistoricoStatus', 'tdChamadoNivelCriticidade',
                    'tdChamadoTecnicoNomeUsuario', 'tdChamadoDataHoraAbertura',
                    'tdBtEditar', 'tdBtPausarRetomar', 'tdBtCancelar', 'tdBtEncerrar');

            let arrayBts = new Array('btEditar', 'btPausarRetomar',
                    'btCancelar', 'btEncerrar');

//                    criar laço aki

            arrayTds[0] = document.createElement('td');
            arrayTds[0].appendChild(document.createTextNode(dataKeys['chaveChamadoCodigo' + cont]));
            arrayTds[0].classList.add('tdCodigo');

            arrayTds[1] = document.createElement('td');
            arrayTds[1].appendChild(document.createTextNode(dataKeys['chaveUsuarioNomeUsuario' + cont]));
            arrayTds[1].classList.add('tdNomeUsuario');

            arrayTds[2] = document.createElement('td');
            arrayTds[2].appendChild(document.createTextNode(dataKeys['chaveSalaNumero' + cont]));

            arrayTds[3] = document.createElement('td');
            arrayTds[3].appendChild(document.createTextNode(dataKeys['chaveChamadoDescricaoProblema' + cont]));

            arrayTds[4] = document.createElement('td');
            arrayTds[4].appendChild(document.createTextNode(dataKeys['chaveChamadoStatus' + cont]));

            arrayTds[5] = document.createElement('td');
            arrayTds[5].appendChild(document.createTextNode(dataKeys['chaveChamadoHistoricoStatus' + cont]));

            arrayTds[6] = document.createElement('td');
            arrayTds[6].appendChild(document.createTextNode(dataKeys['chaveChamadoNivelCriticidade' + cont]));

            arrayTds[7] = document.createElement('td');
            arrayTds[7].appendChild(document.createTextNode(dataKeys['chaveChamadoTecnicoNomeUsuario' + cont]));

            arrayTds[8] = document.createElement('td');
            arrayTds[8].appendChild(document.createTextNode(dataKeys['chaveChamadoDataHoraAbertura' + cont]));

            arrayTds[9] = document.createElement('td');
            arrayBts[0] = document.createElement('button');
            arrayBts[0].appendChild(document.createTextNode('Editar'));
            arrayBts[0].classList.add('btEditar');
            arrayTds[9].appendChild(arrayBts[0]);

            arrayTds[10] = document.createElement('td');
            arrayBts[1] = document.createElement('button');
            arrayBts[1].appendChild(document.createTextNode('Pausar/Retomar'));
            arrayBts[1].classList.add('btPausarRetomar');
            arrayTds[10].appendChild(arrayBts[1]);

            arrayTds[11] = document.createElement('td');
            arrayBts[2] = document.createElement('button');
            arrayBts[2].appendChild(document.createTextNode('Cancelar'));
            arrayBts[2].classList.add('btCancelar');
            arrayTds[11].appendChild(arrayBts[2]);

            arrayTds[12] = document.createElement('td');
            arrayBts[3] = document.createElement('button');
            arrayBts[3].appendChild(document.createTextNode('Encerrar'));
            arrayBts[3].classList.add('btEncerrar');
            arrayTds[12].appendChild(arrayBts[3]);

            //verificao de segurança adicional
            for (let l = 0; l < arrayTds.length; l++)
            {
                if (arrayTds[l] === null)
                {
                    arrayTds[l] = "";
                }
            }

            //adicionando os <td> nas <tr>
            for (let p = 0; p < arrayTds.length; p++)
            {
                tr.appendChild(arrayTds[p]);
            }

            cont++;
        }
        divTable.appendChild(table);
    }

}