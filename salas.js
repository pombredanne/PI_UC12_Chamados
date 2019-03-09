$(document).ready(function(){
   
    $("#divContainerAlert").hide();
    
});

$(document).on("click", "#buttonTableDelete", function(){
   
   $("#divContainerAlert").show();
   
    $(function () {
        $("#divContainerAlert").draggable();
    });
    
    var row = $(this).closest("tr");
    var tdText = row.find(".tdCodigo").text();
    
    $(document).on("click", "#buttonAlertDelete", function(){
       
       $("#divContainerAlert").hide();
       
        $.ajax({
           
            type: 'GET',
            url: 'functions.php?excluirSala&codigoSala=' + tdText,
            datatype: 'json',
            success: function(data)
            {
                if (data == "")
                {
                    alert('lixo');
                }
                else
                {
                    row.remove();
                }
            }
        });
    });
    
    $(document).on("click", "#buttonAlertCancel", function(){
      
        $("#divContainerAlert").hide();
        
    });
    
});