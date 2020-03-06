$("#fechaAtencionContacto,#fechaRegistroContacto,#fechaInformeContacto,#fechaProgramadaInformeContacto").datepicker({
  format: 'dd-mm-yyyy',
  autoclose: true
});

/*if($("#perfilAdministradorContacto").val() == 'SI'){
  var table = $('#tablaListaContacto').DataTable( {    
    "ajax": 'ajax/datatable-contacto.ajax.php',
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
        "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [0,2,3,4,5],
        "className":"vertical-middle-kq"
        },    
      {
        "targets": [1,6,7],
        "className":"text-center vertical-middle-kq"
      }
    ]
  });//DataTable
}else{
  var table = $('#tablaListaContacto').DataTable( {    
    "ajax": 'ajax/datatable-contacto.ajax.php',
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
        "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [0,2,3,4,5],
        "className":"vertical-middle-kq"
      },    
      {
        "targets": [1,6],
        "className":"text-center vertical-middle-kq"
      },
      {
        "targets": [7],
        "className":"hidden"
      }
    ]
  });//DataTable
}*/
var table = $('#tablaClienteCnto').DataTable( {    
    "ajax": 'ajax/datatable-contacto.ajax.php?entrada=vtnCntoAgrupCte',
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
        "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [0],
        "className":"text-center btnVerDtableCnto crsPointer tblCntoCteWidthCorl"
      },    
      {
        "targets": [1],
        "className":"btnVerDtableCnto crsPointer tblCntoCteWidthDsc"
      },
      {
        "targets": [2],
        "className":"hidden tdCteDtableCnto"
      }
    ]
  });//DataTable
/*=============================================
ELEGIR UN CLIENTE
=============================================*/
$("#tablaClienteCnto").on("click", "td.btnVerDtableCnto", function(){
  $("#tablaClienteCnto tbody tr td").removeClass('tblFilaSelec');
  $(this).parent().children('td').addClass('tblFilaSelec');
  var codCliente = $(this).parent().children('td.tdCteDtableCnto').html();
  mostrarDtbleContactoXCte(codCliente);  
  $(".divListadoCntoXCte").removeClass("hidden");
});//click btnVerDtableCnto
/*=============================================
MOSTRAR DATATABLE CONTACTOS X CLIENTE
=============================================*/
function mostrarDtbleContactoXCte(codCliente){
  $("#tablaListaCntoXCte").DataTable().destroy();
  $('#tablaListaCntoXCte').DataTable({    
    "ajax": 'ajax/datatable-contacto.ajax.php?entrada=vntCntoXCte&cliente='+codCliente,
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
        "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [0,2,3,4,5],
        "className":"vertical-middle-kq"
        },    
      {
        "targets": [1,6,7],
        "className":"text-center vertical-middle-kq"
      }
    ]
  });//DataTable
}//function mostrarDtbleContactoXCte
/*=============================================
MOSTRAR DATOS AL EDITAR
=============================================*/
var cont = 0;
var contOrig = 0;
var contTablaInformeContacto = 1;
var contOriginalInformalContacto = 0;
var contDetalleNumLinea = 0;
var contDetalleNumLineaOrig = 0;
var contadorAgregar = 0;
if($("#codigoContacto").length && $("#codigoContacto").val()){
  if($("#codigoContacto").val() != ''){
  	$("#clienteContacto").val($("#codClienteContacto").val()).trigger('change');
  	$("#canalContacto").val($("#codCanalContacto").val());
  	$("#tipoContacto").val($("#codTipoContacto").val());
  	$("#estadoContacto").val($("#codEstadoContacto").val());
  	$("#trabajadorAtencionContacto").val($("#codTrabajadorAtencionContacto").val()).trigger('change');
    //MOSTRAR DATOS TIPO INFORME
    var codTipoContacto = $("#codTipoContacto").val().split('|');
    if(codTipoContacto[1] == 'SI'){
      $(".boxDetalleInformeContacto").removeClass("hidden");
      var datosConInf = new FormData();
      datosConInf.append("codContacto",$("#codigoContacto").val());
      datosConInf.append("accionInformeContacto","mostrar");
      var listaInformeContactoOriginal = [];
      $.ajax({
        url: "ajax/contacto.ajax.php",
        method: "POST",
        data: datosConInf,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
          console.log("respuesta", respuesta);
          $.each(respuesta,function(index,value){
            cont++;
            contOrig++;
            contOriginalInformalContacto++;
            $(".tablaInformeContacto tbody").append(
              '<tr class="trInformeContacto_'+value["num_linea"]+'">'+
                '<td class="text-center vertical-middle-kq"><span class="detalleArchivoInformeContacto"><a href="archivos/contacto/informe/'+value["dsc_ruta_archivo_adjunto"]+'" target="_blank">'+value["dsc_archivo_adjunto"]+'</span></a></td>'+
                '<td class="text-center vertical-middle-kq tdDetalleFechaInformeContacto"><span class="detalleFechaInformeContacto">'+value["fch_informe"]+'</span></td>'+
                '<td class="vertical-middle-kq tdDetalleActividadInforme"><span class="detalleActividadInforme">'+value["dsc_actividad"]+'</span></td>'+
                '<td class="vertical-middle-kq tdDetalleTextoResponsableIndelatInforme"><span class="detalleTextoResponsableIndelatInforme">'+value["dsc_nombres"]+' '+value["dsc_apellido_paterno"]+'</span></td>'+
                '<td class="vertical-middle-kq"><span class="detalleTextoAreaInformeContacto">'+value["dsc_area"]+'</span></td>'+
                '<td class="text-center vertical-middle-kq"><span class="detalleFechaProgramadaInformeContacto">'+value["fch_programada"]+'</span></td>'+
                '<td class="vertical-middle-kq"><span class="detalleTextoStatusInformeContacto">'+value["dsc_status"]+'</span></td>'+
                '<td class="vertical-middle-kq"><div class="btn-group"><button type="button" class="btn btn-sm btn-editarContacto btnEditarContactoInforme" data-toggle="modal" data-target="#modalInformeContacto" numLinea="'+value["num_linea"]+'" title="Editar"><i class="fa fa-pencil-square-o"></i></button><button type="button" class="btn btn-sm btn-danger quitarItemInformeContacto" title="Eliminar"><i class="fa fa-times"></i></button></div></td>'+
                '<td class="hidden"><span class="detalleLugarInformeContacto">'+value["dsc_lugar"]+'</span></td>'+
                '<td class="hidden"><span class="detalleParticipantesClienteInformeContacto">'+value["dsc_participantes_cliente"]+'</span></td>'+
                '<td class="hidden"><span class="detalleParticipantesIndelatInformeContacto">'+value["dsc_participantes_indelat"]+'</span></td>'+
                '<td class="hidden"><span class="detalleAcuerdoInformeContacto">'+value["dsc_acuerdo"]+'</span></td>'+
                '<td class="hidden"><span class="detalleObjetivoInformeContacto">'+value["dsc_objetivo"]+'</span></td>'+
                '<td class="hidden"><span class="detalleResponsableIndelatInforme">'+value["cod_responsable_indelat"]+'</span></td>'+
                '<td class="hidden"><span class="detalleAreaInformeContacto">'+value["cod_area"]+'</span></td>'+
                '<td class="hidden"><span class="detalleStatusInformeContacto">'+value["cod_status"]+'</span></td>'+
                '<td class="hidden"><span class=""><input type="file" name="archivoCont'+cont+'" value=""></span></td>'+
                '<input type="hidden" class="contadorTablaInformeContacto" value="'+contTablaInformeContacto+'" >'+
                /*'<input type="hidden" class="contadorOriginalTablaInformeContacto" value="'+contOriginalInformalContacto+'" >'+*/
                '<input type="hidden" class="contadorOriginalTablaInformeContacto" value="'+value["num_linea"]+'" >'+
                '<input type="hidden" class="detalleNombreArchivoInformeContacto" value="'+value["dsc_archivo_adjunto"]+'">'+
                '<input type="hidden" class="detalleNumLineaInformeContacto" value='+value["num_linea"]+'>'+
                '<input type="hidden" class="detalleNumLineaOrigInformeContacto" value='+value["num_linea"]+'>'+                
              '</tr>'
            );
            $("#contadorListaInformeContacto").val(cont);
            /*$("#contadorListaInformeContacto").after("<input class='hidden' type='file' id='archivoInformeContacto"+cont+"' name='archivoInformeContacto"+cont+"' value='"+value["dsc_ruta_archivo_adjunto"]+"'>");*/
            //$("#contadorListaOriginalInformeContacto").val(contOrig);
            contOrig = value["num_linea"];
            $("#contadorListaOriginalInformeContacto").val(contOrig);
            contTablaInformeContacto++;
            contDetalleNumLinea = value["num_linea"];
            contadorAgregar = contDetalleNumLinea;
            contDetalleNumLineaOrig = value["num_linea"];
          });//each
          listarInformeContacto();
        }//success
      });//ajax
    }//if
  }//if
}//if
$("#tipoContacto").change(function(){
	var flgInforme =  $(this).val().split('|');	
  console.log("flgInforme", flgInforme);
	if(flgInforme[1] == "SI"){
		$(".boxHeaderContacto, .boxDetalleInformeContacto").removeClass("hidden");
	}else{
		$(".boxHeaderContacto, .boxDetalleInformeContacto").addClass("hidden");
	}
});
/*=============================================
AGREGANDO FILAS AL CONTACTO
=============================================*/
/*$(".boxDetalleInformeContacto").on("click", ".agregarFilaContacto", function(){
  	$(".tablaContacto tbody").append(
    	'<tr class="trContacto">'+
	      	'<td style="width: 5%;" class="text-center vertical-middle-kq">'+
	      		'<label for="file-upload" class="subir"><i class="fas fa-cloud-upload-alt"></i>Subir archivo</label><input id="file-upload" onchange="cambiar()" type="file" style="display: none;"/><div id="info"></div>'+
	      	'</td>'+
	      	'<td style="width: 9.5%;"><input type="text" class="form-control fechaDetalleContacto" data-inputmask="\'alias\': \'dd/mm/yyyy\'" data-mask></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control actividadDetalleContacto"></textarea></td>'+
	      	'<td style="width: 8%;"><input type="text" class="form-control lugarDetalleContacto"></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control participantesClientesDetalleContacto"></textarea></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control participantesIndelatDetalleContacto"></textarea></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control acuerdoDetalleContacto"></textarea></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control objetivoDetalleContacto"></textarea></td>'+
	      	'<td style="width: 8%;"><select class="form-control responsableIndelatDetalleContacto"><option>Usuario 1</option><option>Usuario 2</option><option>Usuario 3</option></select></td>'+
	      	'<td style="width: 9.5%;"><input type="text" class="form-control fechaProgramadaDetalleContacto" data-inputmask="\'alias\': \'dd/mm/yyyy\'" data-mask></td>'+
	      	'<td style="width: 8%;"><select class="form-control estadoDetalleContacto"><option>Estado 1</option><option>Estado 2</option><option>Estado 3</option></select></td>'+
	      	'<td style="width: 8%;"><textarea class="form-control areaInformeDetalleContacto"></textarea></td>'+
	      	'<td style="width: 4%;" class="text-center" title="Eliminar">'+
		        '<button type="button" class="btn btn-sm btn-danger quitarItemContacto">'+
		          '<i class="fa fa-times"></i>'+
		        '</button>'+
		    '</td>'+
      	'</tr>'
    );
    $('[data-mask]').inputmask();
});*/
/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

/*function listarDetalleInforme(){

  var listaDetalleInforme = [];
  //Almacena todos los input o select que tenga esta clase
  var fecha = $(".codProductoCotizacion");
  var actividad

}*///function listarDetalleInforme
$(".overlay").addClass('hidden');
/*=============================================
OBTENER DATOS EDITAR CONTACTO
=============================================*/
$("#tablaListaCntoXCte").on("click", ".btnEditarContacto", function(){
  var codContacto = $(this).attr("codContacto");
  window.location = "index.php?ruta=contacto&codigo="+codContacto;
});//Click btnEditarCotizacion
/*=============================================
ELIMINAR CONTACTO
=============================================*/
$("#tablaListaCntoXCte").on("click", ".btnEliminarContacto", function(){
  var codigoContacto = $(this).attr("codContacto");
  var accionContacto = "eliminar";
  swal({
    title: '¿Está seguro de borrar el contacto?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar el contacto!'
  }).then(function(result){
    if (result.value) {
      $.ajax({
        url:"ajax/contacto.ajax.php",
        method: "POST",
        data: "accionContacto="+accionContacto+"&codigoContacto="+codigoContacto,
        success:function(respuesta){
          console.log("respuesta", respuesta);
          if(respuesta == 'ok'){
            table.ajax.url('ajax/datatable-contacto.ajax.php?entrada=vtnCntoAgrupCte').load();
            $(".divListadoCntoXCte").addClass("hidden");
          }
        }//success
      });//ajax
    }//if
  })
});//Click btnEliminarCotizacion
/*=============================================
CANCELAR CONTACTO
=============================================*/
$("#cancelarContacto").click(function(){
  var accionInformeContactoCancelar = "cancelar";
  $.ajax({
    url:"ajax/contacto.ajax.php",
    method: "POST",
    data: "codigoContacto="+$("#codigoContacto").val()+"&accionInformeContacto="+accionInformeContactoCancelar,
    success:function(respuesta){
      //console.log("respuesta", respuesta);
      window.location = "contactos";
    }//success
  });//ajax  
});//click cancelarContacto
/*=============================================
CREAR,EDITAR CONTACTO
=============================================*/
$("#formContacto").submit(function(e){
	e.preventDefault();
  $(".overlay").removeClass('hidden');
	var accionContacto  = $("#accionContacto").val();
	var formData = new FormData($("#formContacto")[0]);
	$.ajax({
		url:"ajax/contacto.ajax.php",
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
          title: "El contacto ha sido guardado correctamente",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
              window.location = "contactos";
            }
        });//swall
      }//if
      $(".overlay").addClass('hidden');
	  }//success
	});//ajax
});//submit formContacto

/*=============================================
INFORME CONTACTO
=============================================*/

/*=============================================
AGREGAR INFORME CONTACTO
=============================================*/
//var contadorAgregar = 1;

$(".tablaInformeContacto").on("click", ".btnEditarContactoInforme", function(){
  var codContacto = $("#codigoContacto").val();
  var numLineaInforme = $(this).attr("numLinea");  
  console.log("numLineaInforme", numLineaInforme);
  var accionInformeContacto = "mostrar";
  var datos = new FormData();
  datos.append("codContacto",codContacto);
  datos.append("numLineaInforme",numLineaInforme);
  datos.append("accionInformeContacto",accionInformeContacto);
  $.ajax({
    url: "ajax/contacto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
      console.log("respuesta", respuesta);
      $("#fechaInformeContacto").val(respuesta["fch_informe"]);
      $("#actividadInformeContacto").val(respuesta["dsc_actividad"]);
      $("#lugarInformeContacto").val(respuesta["dsc_lugar"]);
      $("#participantesClienteInformeContacto").val(respuesta["dsc_participantes_cliente"]);
      $("#participantesIndelatInformeContacto").val(respuesta["dsc_participantes_indelat"]);
      $("#acuerdoInformeContacto").val(respuesta["dsc_acuerdo"]);
      $("#objetivoInformeContacto").val(respuesta["dsc_objetivo"]);
      $("#fechaProgramadaInformeContacto").val(respuesta["fch_programada"]);
      $("#statusInformeContacto").val(respuesta["cod_status"]);
      $("#areaInformeContacto").val(respuesta["cod_area"]);
      $("#responsableIndelatInformeContacto").val(respuesta["cod_responsable_indelat"]).trigger('change');
      $("#numLineaInformeModal").val(respuesta["num_linea"]);
    }//success
  });//ajax
});//click btnEditarContactoInforme

console.log("contDetalleNumLinea", contDetalleNumLinea);
var diferenciaModalHidden = 1;
$("#fechaInformeContacto,#fechaProgramadaInformeContacto").focus(function(){
  //console.log('hid 3');
  diferenciaModalHidden = 3;
})
$(".btnAgregarInformeContacto").click(function(){
  
  console.log("contadorAgregar", contadorAgregar);
  contadorAgregar++;
  console.log("contadorAgregar", contadorAgregar);
  diferenciaModalHidden = 1;
  $("#modalTituloInformeContacto").html('Agregar informe');
  //$('#formInformeContacto').trigger("reset");
  $(".inputFormInforme").val('');
  $(".selectFormInforme").val('').trigger('change');
  $("#fechaInformeContacto,#fechaProgramadaInformeContacto").val($("#fechaHoyInformeContacto").val());
  $("#nombreArchivoInformeContacto").html('');
  $("#accionInformeContacto").val("crear");
  $("#contadorListaInformeContacto").after("<input class='hidden' type='file' id='archivoInformeContacto"+contadorAgregar+"' name='archivoInformeContacto"+contadorAgregar+"'>");

  $("#numLineaInformeModal").val('');

  console.log("contadorAgregar", contadorAgregar);  
});//click btnAgregarInformeContacto
//$("[data-dismiss=modal]").trigger("click");
$("#modalInformeContacto").on("hide.bs.modal", function () {
  console.log('diferenciaModalHidden',diferenciaModalHidden);
    if(diferenciaModalHidden == 1){
      $("#archivoInformeContacto"+contadorAgregar).remove();
      contadorAgregar = contadorAgregar-1;
    }
    /*if(diferenciaModalHidden == 3){
      contadorAgregar--;
    }*/
  //contadorAgregar++;
  diferenciaModalHidden = 1;
  });
/*=============================================
CREAR,EDITAR INFORME CONTACTO
=============================================*/
// $("#formInformeContacto").submit(function(e){
$("#botonGuardarContacto").click(function(){
  //console.log('hid 2');
  diferenciaModalHidden = 2;
  $("#formInformeContacto [data-dismiss=modal]").trigger("click");
  console.log('numLinea',$("#numLineaInformeModal").val());
  //Cuando ponga en agregar item
  if($("#numLineaInformeModal").val() == ''){
    mostrarTablaInforme();
  }else{
    editarTablaInforme();
  }  
});//submit formInformeContacto
$("#botonArchivoInformeContacto").click(function(){
  /*console.log('a1');
  console.log("contadorAgregar", contadorAgregar);*/
  $("#archivoInformeContacto"+contadorAgregar).click();
  $("#archivoInformeContacto"+contadorAgregar).change(function(){
    $("#nombreArchivoInformeContacto").html(this.files[0].name);
  });//change archivoInformeContacto
});//click botonArchivoInformeContacto
//console.log("contadorAgregar",contadorAgregar);

/*$("#formInformeContacto").on("keypress","input.inputFormInforme",function(){
  mostrarTablaInforme();
});*/

function editarTablaInforme(){
  var filaInforme = $(".trInformeContacto_"+$("#numLineaInformeModal").val());
  console.log("filaInforme:", filaInforme);
  console.log("tdDetalleActividadInforme:",filaInforme.children('.tdDetalleActividadInforme').children('span').html());
  filaInforme.children('.tdDetalleActividadInforme').children('span.detalleActividadInforme').html($("#actividadInformeContacto").val());
  filaInforme.children('.tdDetalleFechaInformeContacto').children('span.detalleFechaInformeContacto').html($("#fechaInformeContacto").val());
  filaInforme.children('.tdDetalleTextoResponsableIndelatInforme').children('span.tdDetalleTextoResponsableIndelatInforme').html($("#fechaInformeContacto").val());
  tdDetalleTextoResponsableIndelatInforme
  
  listarInformeContacto();
}//function editarTablaInforme

/*=============================================
LISTAR INFORME
=============================================*/
// var contTablaInformeContacto = 1;
// var contOriginalInformalContacto = 0;
function mostrarTablaInforme(){
  cont++;
  contOrig++;
  contOriginalInformalContacto++;
  contDetalleNumLinea++;
  contDetalleNumLineaOrig++;
  $(".tablaInformeContacto tbody").append(
    '<tr class="trInformeContacto">'+
      '<td class="text-center vertical-middle-kq"><span class="detalleArchivoInformeContacto">'+$("#nombreArchivoInformeContacto").html()+'</span></td>'+
      '<td class="text-center vertical-middle-kq"><span class="detalleFechaInformeContacto">'+$("#fechaInformeContacto").val()+'</span></td>'+
      '<td class="vertical-middle-kq"><span class="detalleActividadInforme">'+$("#actividadInformeContacto").val()+'</span></td>'+       
      '<td class="vertical-middle-kq"><span class="detalleTextoResponsableIndelatInforme">'+$("#responsableIndelatInformeContacto option:selected").text()+'</span></td>'+
      '<td class="vertical-middle-kq"><span class="detalleTextoAreaInformeContacto">'+$("#areaInformeContacto option:selected").text()+'</span></td>'+
      '<td class="text-center vertical-middle-kq"><span class="detalleFechaProgramadaInformeContacto">'+$("#fechaProgramadaInformeContacto").val()+'</span></td>'+
      '<td class="vertical-middle-kq"><span class="detalleTextoStatusInformeContacto">'+$("#statusInformeContacto option:selected").text()+'</span></td>'+
      '<td class="vertical-middle-kq"><div class="btn-group"><button type="button" class="btn btn-sm btn-editarContacto" data-toggle="modal" data-target="#modalInformeContacto" title="Editar"><i class="fa fa-pencil-square-o"></i></button><button type="button" class="btn btn-sm btn-danger quitarItemInformeContacto" title="Eliminar"><i class="fa fa-times"></i></button></div></td>'+
      '<td class="hidden"><span class="detalleLugarInformeContacto">'+$("#lugarInformeContacto").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleParticipantesClienteInformeContacto">'+$("#participantesClienteInformeContacto").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleParticipantesIndelatInformeContacto">'+$("#participantesIndelatInformeContacto").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleAcuerdoInformeContacto">'+$("#acuerdoInformeContacto").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleObjetivoInformeContacto">'+$("#objetivoInformeContacto").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleResponsableIndelatInforme">'+$("#responsableIndelatInformeContacto option:selected").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleAreaInformeContacto">'+$("#areaInformeContacto option:selected").val()+'</span></td>'+
      '<td class="hidden"><span class="detalleStatusInformeContacto">'+$("#statusInformeContacto option:selected").val()+'</span></td>'+
      '<td class="hidden"><span class=""><input type="file" name="archivoCont'+cont+'" value="'+$("#botonArchivoInformeContacto").files+'"></span></td>'+
      '<input type="hidden" class="contadorTablaInformeContacto" value="'+contTablaInformeContacto+'" >'+
      '<input type="hidden" class="contadorOriginalTablaInformeContacto" value="'+contOriginalInformalContacto+'" >'+
      '<input type="hidden" class="detalleNombreArchivoInformeContacto" value="'+$("#nombreArchivoInformeContacto").html()+'">'+
      '<input type="hidden" class="detalleNumLineaInformeContacto" value="'+contDetalleNumLinea+'">'+
      
      '<input type="hidden" class="detalleNumLineaOrigInformeContacto" value="'+contDetalleNumLineaOrig+'">'+
      
    '</tr>'
  );
  
  /*console.log("contDetalleNumLineaOrigSinModif", contDetalleNumLineaOrigSinModif);
  console.log("numLineaInformeModal", numLineaInformeModal);
  console.log("contDetalleNumLinea", contDetalleNumLinea);
  console.log("contDetalleNumLineaOrig", contDetalleNumLineaOrig);*/

  //console.log("numLineaInformeModal", $("#numLineaInformeModal").val());

  var numLineaInformeOrig = $(".detalleNumLineaOrigInformeContacto");
  /*for (var i = 0; i < numLineaInformeOrig.length; i++) {
    //console.log('a',$(numLineaInformeOrig[i]).val());
    if($("#numLineaInformeModal").val() == $(numLineaInformeOrig[i]).val()){
      console.log('entro:',$(numLineaInformeOrig[i]).val());
    }
  }*/


  $("#contadorListaInformeContacto").val(cont);
  $("#contadorListaOriginalInformeContacto").val(contOrig);
  contTablaInformeContacto++;
  listarInformeContacto();
}//function mostrarTablaInforme

/*$(".formularioContacto").on("click","button.quitarItemInformeContacto", function(){
  contTablaInformeContacto--;
  cont--;
  $("#contadorListaInformeContacto").val(cont);
  var totalNumLinea = $(".contadorTablaInformeContacto");
  var numLineaELim = $(this).parent().parent().parent().children(".contadorTablaInformeContacto").val();
  var numOriginalNumLineaElim = $(this).parent().parent().parent().children(".contadorOriginalTablaInformeContacto").val();
  $("#archivoInformeContacto"+numOriginalNumLineaElim).remove();
  for (var i = 0; i < totalNumLinea.length; i++) {
    if(i > (numLineaELim-1)){
      $(totalNumLinea[i]).val(Number($(totalNumLinea[i]).val())-1);
    }
  }
  $(this).parent().parent().parent().remove();
  listarInformeContacto();
});*/
$(".formularioContacto").on("click","button.quitarItemInformeContacto", function(){  
  var numLineaBD = $(this).parent().parent().parent().children(".detalleNumLineaInformeContacto").val();
  var numLineaBD2 = $(this).parent().parent().parent().children(".detalleNumLineaOrigInformeContacto").val();
  console.log("numLineaBD2:", numLineaBD2);
  console.log("contDetalleNumLineaOrig:", contDetalleNumLineaOrig);
  if(contDetalleNumLineaOrig <= numLineaBD2){
    contDetalleNumLineaOrig--;
  }
  var accionInformeContacto = "eliminar";
  $.ajax({
    url:"ajax/contacto.ajax.php",
    method: "POST",
    data: "codigoContacto="+$("#codigoContacto").val()+"&numLinea="+numLineaBD2+"&accionInformeContacto="+accionInformeContacto,
    success:function(respuesta){
      console.log("respuesta", respuesta);
    }//success
  });//ajax
  contTablaInformeContacto--;
  contDetalleNumLinea--;
  cont--;
  $("#contadorListaInformeContacto").val(cont);
  var totalNumLinea = $(".detalleNumLineaInformeContacto");
  console.log("totalNumLinea", totalNumLinea.length);
  //var numLineaELim = $(this).parent().parent().parent().children(".contadorTablaInformeContacto").val();
  console.log("numLineaELim", numLineaBD);
  var numOriginalNumLineaElim = $(this).parent().parent().parent().children(".contadorOriginalTablaInformeContacto").val();
  //var numOriginalNumLineaElim = $(this).parent().parent().parent().children(".detalleNumLineaInformeContacto").val();
  console.log("numOriginalNumLineaElim", numOriginalNumLineaElim);
  $("#archivoInformeContacto"+numOriginalNumLineaElim).remove();
  //$("#archivoInformeContacto"+contadorAgregar).remove();
  
  for (var i = 0; i < totalNumLinea.length; i++) {
    //console.log('total:',$(totalNumLinea[i]).val());
    /*console.log('totalNumLinea', $(totalNumLinea[i]).val());
    console.log('numLineaBD:',numLineaBD);
    console.log('i:',i);*/
    if(($(totalNumLinea[i]).val()) > (numLineaBD-1)){
      //console.log('total2',$(totalNumLinea[i]).val());
      $(totalNumLinea[i]).val(Number($(totalNumLinea[i]).val())-1);
    }
  }

  $(this).parent().parent().parent().remove();
  listarInformeContacto();
  
  
});//button quitarItemInformeContacto

function listarInformeContacto(){
  //console.log('a3')
  var listarInforme = [];
  //var detalleArchivoInforme = $(".detalleArchivoInformeContacto");
  var numLineaInforme = $(".detalleNumLineaInformeContacto");
  var numLineaInformeOrig = $(".detalleNumLineaOrigInformeContacto");
  var detalleArchivoInforme = $(".detalleNombreArchivoInformeContacto");
  var detalleFechaInforme = $(".detalleFechaInformeContacto");
  var detalleActividadInforme = $(".detalleActividadInforme");
  var detalleLugarInforme = $(".detalleLugarInformeContacto");
  var detalleParticipantesClienteInforme = $(".detalleParticipantesClienteInformeContacto");
  var detalleParticipantesIndelatInforme = $(".detalleParticipantesIndelatInformeContacto");
  var detalleAcuerdoInforme = $(".detalleAcuerdoInformeContacto");
  var detalleAreaInforme = $(".detalleAreaInformeContacto");
  var detalleObjetivoInforme = $(".detalleObjetivoInformeContacto");
  var detalleResponsableIndelatInforme = $(".detalleResponsableIndelatInforme");
  var detalleFechaProgramadaInforme = $(".detalleFechaProgramadaInformeContacto");
  var detalleStatusInforme = $(".detalleStatusInformeContacto");
  for (var i = 0; i < detalleFechaInforme.length; i++) {
    /*listarInforme.push({"num_linea" : (i+1),
                        "dsc_actividad" : $(detalleActividadInforme[i]).html(),
                        "dsc_lugar" : $(detalleLugarInforme[i]).html(),
                        "dsc_participantes_cliente" : $(detalleParticipantesClienteInforme[i]).html(),
                        "dsc_participantes_indelat" : $(detalleParticipantesIndelatInforme[i]).html(),
                        "dsc_acuerdo" : $(detalleAcuerdoInforme[i]).html(),
                        "dsc_objetivo" : $(detalleObjetivoInforme[i]).html(),
                        "cod_area" : $(detalleAreaInforme[i]).html(),
                        "cod_status" : $(detalleStatusInforme[i]).html(),
                        "cod_responsable_indelat" : $(detalleResponsableIndelatInforme[i]).html(),
                        "dsc_archivo_adjunto" : $(detalleArchivoInforme[i]).val(),
                        "fch_informe" : $(detalleFechaInforme[i]).html(),
                        "fch_programada" : $(detalleFechaProgramadaInforme[i]).html()
                      });*/
      listarInforme.push({"num_linea" : $(numLineaInforme[i]).val(),
                          "num_linea_orig" : $(numLineaInformeOrig[i]).val(),
                          "dsc_actividad" : $(detalleActividadInforme[i]).html(),
                          "dsc_lugar" : $(detalleLugarInforme[i]).html(),
                          "dsc_participantes_cliente" : $(detalleParticipantesClienteInforme[i]).html(),
                          "dsc_participantes_indelat" : $(detalleParticipantesIndelatInforme[i]).html(),
                          "dsc_acuerdo" : $(detalleAcuerdoInforme[i]).html(),
                          "dsc_objetivo" : $(detalleObjetivoInforme[i]).html(),
                          "cod_area" : $(detalleAreaInforme[i]).html(),
                          "cod_status" : $(detalleStatusInforme[i]).html(),
                          "cod_responsable_indelat" : $(detalleResponsableIndelatInforme[i]).html(),
                          "dsc_archivo_adjunto" : $(detalleArchivoInforme[i]).val(),
                          "fch_informe" : $(detalleFechaInforme[i]).html(),
                          "fch_programada" : $(detalleFechaProgramadaInforme[i]).html()
                      });
  }//for
  $("#listaInformeContacto").val(JSON.stringify(listarInforme));
}//function listarInformeContacto