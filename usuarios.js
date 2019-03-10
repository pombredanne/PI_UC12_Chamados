$(document).ready(function () {

    $("#divContainerAlert").hide();
    $(".divError").hide();

});

$(document).on("click", "#tdEditar", function () {

    var tdCodigo = $(this).closest("tr").find("#tdCodigo").text();

    window.location.href =
            "cadastrarUsuario.php?editar&codigoUsuario=" + tdCodigo;

});

$(document).on("click", "#tdExcluir", function () {

    var row = $(this).closest("tr");
    var tdCodigo = row.find("#tdCodigo").text();
    var tdNomeUsuario = row.find("#tdNomeUsuario").text();

    $(function () {
        $("#divContainerAlert").draggable();
    });

    $("#spanAlert").text(tdNomeUsuario);
    $("#divContainerAlert").show();

    $(document).on("click", "#buttonAlertDelete", function () {

        $("#divContainerAlert").hide();

        $.ajax({

            type: 'GET',
            url: 'functions.php?excluirUsuario&codigoUsuario=' + tdCodigo,
            datatype: 'json',
            success: function (data)
            {

                var json = $.parseJSON(data);

                if (json == 'error')
                {
                    $("#spanError").text(tdNomeUsuario);
                    $(".divError").show();
                } else
                {
                    row.remove();
                }
            }
        });
    });

    $(document).on("click", "#buttonAlertCancel", function () {

        $("#divContainerAlert").hide();

    });

});

$(document).on("click", ".divError button", function () {

    $(".divError").hide();
    $("#spanError").text("");

});