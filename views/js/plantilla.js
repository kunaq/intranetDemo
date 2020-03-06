$('.select2').select2();
/*=============================================
Data Table
=============================================*/
$(".tablas").DataTable({
  "language" : {
    "url": "spanish.json"
  }
});//DataTable
$('.sidebar-menu').tree();
/*=============================================
iCheck for checkbox and radio inputs
=============================================*/
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
});//iCheck
// Herramienta TOOLTIP
$('[data-toggle="tooltip"]').tooltip();
/*=============================================
 //input Mask
=============================================*/
//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()
$("#datepicker").datepicker({
  format: 'dd-mm-yyyy',
  autoclose: true
});//datepicker
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}//function escapeHtml
function check(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) {
        return true;
    }
    // Patron de entrada, en este caso solo acepta numeros y letras
    //patron = /[A-Za-z0-9]/;
    patron = /^[^$%&|<>#'"]*$/;
    tecla_final = String.fromCharCode(tecla);
    //alert(tecla_final);
    //return patron.test(tecla_final);
    if(!patron.test(tecla_final)){
       // Dimensiones del elemento al que se quiere añadir el tooltip
        anchoElemento = $("#contactoCotizacion").width();
        altoElemento = $("#contactoCotizacion").height();        
        // Coordenadas del elemento al que se quiere añadir el tooltip
        coordenadaXElemento = $(".box-body #contactoCotizacion").position().left;
        coordenadaYElemento = $("#contactoCotizacion").position().top;
        // Coordenadas en las que se colocara el tooltip
        x = coordenadaXElemento + anchoElemento + 20;
        y = coordenadaYElemento + altoElemento/2 + 10;
        // Crea el tooltip con sus atributos
        var tooltip = document.createElement('div');
        tooltip.id = $("#contactoCotizacion") + "tp";
        tooltip.className = 'toolTip';
        tooltip.innerHTML = "hola";
        tooltip.style.left = x + "px";
        tooltip.style.top = y + "px";
        // Añade el tooltip
        document.body.appendChild(tooltip);
        tooltip.style.display = "block";
        $("#contactoCotizacion").animate({"opacity" : 1});
    }//if    
    return patron.test(tecla_final);
}//function check
function pulsar(e){
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=45);
}//function pulsar
$(document).on("keypress","form input", function(e){
  tecla = (document.all) ? e.keyCode :e.which;
  if(tecla == 13){
    return false;
  }
});//formularioIngreso
function cambiar(){
  var pdrs = document.getElementById('file-upload').files[0].name;
  document.getElementById('info').innerHTML = pdrs;
}//function cambiar
$(".input2Decimales").number(true,2);
$(".inputFecha").datepicker({
  format: 'dd-mm-yyyy',
  autoclose: true
});//datepicker
Pace.on("done", function(){
  $(".card-body").removeClass('hidden');
});
function cargaGifDivForm(idDiv,modal=''){
  if(modal != 'sinOcultar'){
    $("#"+idDiv).addClass('hidden');
  }
  Pace.restart();
  if(modal == ''){
    Pace.on("done", function(){
      $("#"+idDiv).removeClass('hidden');
    });
  }else if(modal == 'confirm'){
    Pace.on("done", function(){
      $("#"+idDiv).addClass('hidden');
    });
  }else{
    Pace.on("done", function(){
      $("#"+idDiv).removeClass('hidden');
    });
  }
}//function cargaGifDivForm