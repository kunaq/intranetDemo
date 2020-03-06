$("#listaPoliticaProcedimiento").jstree({
	'core' : {
    	data : {
  	    url: "ajax/jstree-politicaProcedimiento.ajax.php",
        dataType: "json"
    	}
	},
  "plugins" : [ "types" ],
	"types" : {
    "file" : {
      "icon" : "fa fa-file-archive-o"
    }      
  }  
});//jstree listaPoliticaProcedimiento
/*$('#listaPoliticaProcedimiento').on('changed.jstree', function (e, data) {	
  if(data.node.type == "file"){
    //alert(data.node.id);
    //console.log(data.selected);
    //$("#0001-1-asignacion-equipos-computo.pdf_anchor").css("color","#000000");
    //$(data.node.id+'_anchor').addClass("background","red");
    //window.open("archivos/politica-procedimiento/"+data.node.id, "_blank"); 

  }//if
});
$('#listaPoliticaProcedimiento').on("hover_node.jstree", function (node) {
    //alert($(this).attr("class"))
});*/
var a;
function popitup(a)
{
  //alert(a)
    window.open(a,
    'open_window',
    'menubar=no, toolbar=no, location=no, directories=no, status=no, scrollbars=no, resizable=no, dependent, width=800, height=620, left=0, top=0')
}
/*=============================================
AGREGAR POLITICA/PROCEDIMIENTO
=============================================*/
$("#btnAgregarPoliticaProcedimiento").click(function(){
  $('#formPoliticaProcedimiento').trigger("reset");
  $("#modalTituloPoliticaProcedimiento").html('Agregar política/procedimiento');
  $("#accionPoliticaProcedimiento").val("crear");
});//click btnAgregarPoliticaProcedimiento
/*=============================================
EDITAR POLITICA/PROCEDIMIENTO
=============================================*/
$("#listaPoliticaProcedimiento").on("click", ".btnEditarPoliticaProcedimiento", function(){
  $(".overlay").removeClass('hidden');
  $("#modalTituloPoliticaProcedimiento").html('Editar política/procedimient');
  $("#accionPoliticaProcedimiento").val("editar");
  var codPoliticaProcedimiento = $(this).attr("codPoliticaProcedimiento");
  var datos = new FormData();
  datos.append("codPoliticaProcedimiento",codPoliticaProcedimiento);
  datos.append("accionPoliticaProcedimiento","mostrar");
  $.ajax({
    url:"ajax/politicaProcedimiento.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
    	console.log("respuesta", respuesta);
    	$("#codigoPoliticaProcedimiento").val(respuesta["cod_politica"]);
    	$("#nombrePoliticaProcedimiento").val(respuesta["dsc_politica"]);
    	$(".overlay").addClass('hidden');
    }//success
  });//ajax
});//click btnEditarPoliticaProcedimiento
/*=============================================
MOSTRAR DATO ADJUNTO POLITICA/PROCEDIMIENTO DETALLE
=============================================*/
$("#listaPoliticaProcedimiento").on("click", ".aDatoAdjuntoPolitica", function(){
  $(this).trigger("click");
});
/*=============================================
ELIMINAR POLITICA/PROCEDIMIENTO
=============================================*/
$("#listaPoliticaProcedimiento").on("click", ".btnEliminarPoliticaProcedimiento", function(){
  var codigoPoliticaProcedimiento = $(this).attr("codPoliticaProcedimiento");
  var accionPoliticaProcedimiento = "eliminar";
  swal({
    title: '¿Está seguro de borrar esta política/procedimiento?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar!'
  }).then(function(result){
    if (result.value) {
      $.ajax({
        url:"ajax/politicaProcedimiento.ajax.php",
        method: "POST",
        data: "accionPoliticaProcedimiento="+accionPoliticaProcedimiento+"&codigoPoliticaProcedimiento="+codigoPoliticaProcedimiento,
        success:function(respuesta){
          console.log("resp",respuesta);
          if(respuesta == 'ok'){
            $('#listaPoliticaProcedimiento').jstree(true).refresh();
          }else{
            swal({
              type: "error",
              title: "Ha ocurrido un problema al eliminar este archivo, por favor intente de nuevo.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            });//swal
          }
        }//success
      });//ajax
    }//if
  })
});//Click btnEliminarPoliticaProcedimientoDetalle
/*=============================================
ELIMINAR POLITICA/PROCEDIMIENTO DETALLE
=============================================*/
$("#listaPoliticaProcedimiento").on("click", ".btnEliminarPoliticaProcedimientoDetalle", function(){
  var codigoPoliticaProcedimiento = $(this).attr("codPoliticaProcedimiento");
  var numLineaPoliticaProcedimiento = $(this).attr("numLinea");
  var archivoPoliticaProcedimiento = $(this).attr("archivo");
  var accionPoliticaProcedimientoDetalle = "eliminar";
  swal({
    title: '¿Está seguro de borrar este archivo?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar el archivo!'
  }).then(function(result){
    if (result.value) {
      $.ajax({
        url:"ajax/politicaProcedimiento.ajax.php",
        method: "POST",
        data: "accionPoliticaProcedimientoDetalle="+accionPoliticaProcedimientoDetalle+"&codigoPoliticaProcedimiento="+codigoPoliticaProcedimiento+"&numLineaPoliticaProcedimiento="+numLineaPoliticaProcedimiento+"&archivoPoliticaProcedimiento="+archivoPoliticaProcedimiento,
        success:function(respuesta){
          console.log("resp",respuesta);
          if(respuesta == 'ok'){
            $('#listaPoliticaProcedimiento').jstree(true).refresh();
          }else{
            swal({
              type: "error",
              title: "Ha ocurrido un problema al eliminar este archivo, por favor intente de nuevo.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            });//swal
          }
        }//success
      });//ajax
    }//if
  })
});//Click btnEliminarPoliticaProcedimientoDetalle
/*=============================================
CREAR,EDITAR POLITICA/PROCEDIMIENTO
=============================================*/
$("#formPoliticaProcedimiento").submit(function(e){
	e.preventDefault();
	$(".overlay").removeClass('hidden');
	var formData = new FormData($("#formPoliticaProcedimiento")[0]);
	$.ajax({
		url:"ajax/politicaProcedimiento.ajax.php",
  	type: "POST",
  	data: formData,
    cache:false,
    contentType: false,
    processData: false,
    success:function(respuesta){
      console.log("respuesta", respuesta);
      if(respuesta == "ok"){
        swal({
          type: "success",
          title: "La política/procedimiento ha sido guardado correctamente",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            $("[data-dismiss=modal]").trigger("click");
            $('#listaPoliticaProcedimiento').jstree(true).refresh();
            $('#formPoliticaProcedimiento').trigger("reset");
          }
        });
		  }else if(respuesta == "nombreRepetido"){
        swal({
          type: "error",
          title: "El título que has ingresado ya existe, por favor ingrese otro título.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
                $("#nombrePoliticaProcedimiento").focus();
            }
        });
      }else{
        swal({
          type: "error",
          title: "Ha ocurrido un problema al crear la política/procedimiento, por favor intente de nuevo.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            $("[data-dismiss=modal]").trigger("click");
            $('#listaPoliticaProcedimiento').jstree(true).refresh();
            $('#formPoliticaProcedimiento').trigger("reset");
          }
        });
      }//else
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//submit formPoliticaProcedimiento