$(document).ready(function () {

    $("#divContainerAlert").hide();
    $(".divError").hide();

});

$(document).on("click", "#tdEditar", function () {

    var tdCodigo = $(this).closest("tr").find("#tdCodigo").text();

    window.location.href =
            "cadastrarSala.php?editar&codigoSala=" + tdCodigo;

});

$(document).on("click", "#tdExcluir", function () {

    var row = $(this).closest("tr");
    var tdCodigo = row.find("#tdCodigo").text();
    var tdNumero = row.find("#tdNumero").text();

    $(function () {
        $("#divContainerAlert").draggable();
    });

    $("#spanAlert").text(tdNumero);
    $("#divContainerAlert").show();

    $(document).on("click", "#buttonAlertDelete", function () {

        $("#divContainerAlert").hide();

        $.ajax({

            type: 'GET',
            url: 'functions.php?excluirSala&codigoSala=' + tdCodigo,
            datatype: 'json',
            success: function (data)
            {

                var json = $.parseJSON(data);

                if (json == 'error')
                {
                    $("#spanError").text(tdNumero);
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