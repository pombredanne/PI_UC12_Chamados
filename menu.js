$(document).ready(function(){
   
    $("#divMenuToogle").click(function (){
       
        $("nav").toggleClass('active');
        $("i").toggleClass('fa-times');
    });
    
    $('ul li').hover(function() {
       
//       Faz com que não seja possível ter 2 submenu ativados
//       ao mesmo tempo
        $(this).siblings().removeClass('active');
        $(this).toggleClass('active');
        
    });
    
});