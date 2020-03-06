if($("#permisoConsultasFrecuente").val() == 'SI'){
  var table = $('#tablaConsultaFrecuente').DataTable( {
    "ajax": "ajax/datatable-consultasFrecuentes.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
      "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": [3,4],
        "className": "text-center"
      }
    ]
  });//DataTable
}else{
  var table = $('#tablaConsultaFrecuente').DataTable( {
    "ajax": "ajax/datatable-consultasFrecuentes.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
      "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": 3,
        "className": "text-center"
      },
      {
        "targets": 4,
        "className": "hidden"
      }
    ]
  });//DataTable
}

/*=============================================
AGREGAR CONSULTA FRECUENTE
=============================================*/
$("#btnAgregarConsultaFrecuente").click(function(){
  $("#formConsultaFrecuente").trigger("reset");
  $("#modalTituloConsultaFrecuente").html("Agregar consulta");
  $("#accionConsultaFrecuente").val("crear");
});//click btnAgregarConsultaFrecuente
/*=============================================
EDITAR CONSULTA FRECUENTE
=============================================*/
$("#tablaConsultaFrecuente").on("click", ".btnEditarConsultaFrecuente", function(){
  $(".overlay").removeClass('hidden');
  $("#modalTituloConsultaFrecuente").html('Editar consulta');
  $("#accionConsultaFrecuente").val("editar");
  var codConsultaFrecuente = $(this).attr("codConsultaFrecuente");
  var datos = new FormData();
  datos.append("codConsultaFrecuente",codConsultaFrecuente);
  datos.append("accionConsultaFrecuente","mostrar");
  $.ajax({
    url:"ajax/consultaFrecuente.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
      //console.log("respuesta", respuesta);
      $("#codigoConsultaFrecuente").val(respuesta["cod_consulta"]);
      $("#nombreConsultaFrecuente").val(respuesta["dsc_consulta"]);
      $("#respuestaConsultaFrecuente").val(respuesta["dsc_respuesta"]);
      $("#archivoOriginalConsultaFrecuente").val(respuesta["dsc_ruta_archivo"]);
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//click btnEditarConsultaFrecuente
$("#tablaConsultaFrecuente").on("click", ".btnEliminarConsultaFrecuente", function(){
  var codigoConsultaFrecuente = $(this).attr("codConsultaFrecuente");
  var imagenConsultaFrecuente = $(this).attr("imagenConsultaFrecuente")
  $("#accionConsultaFrecuente").val("eliminar"); 
  swal({
    title: '¿Está seguro de borrar la consulta?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar consulta!'
  }).then(function(result){
      if (result.value) {        
        $.ajax({
          url:"ajax/consultaFrecuente.ajax.php",
          method: "POST",
          data: "accionConsultaFrecuente="+$("#accionConsultaFrecuente").val()+"&imagenConsultaFrecuente="+imagenConsultaFrecuente+"&codigoConsultaFrecuente="+codigoConsultaFrecuente,
          success:function(respuesta){
            if(respuesta == 'ok'){
              table.ajax.url('ajax/datatable-consultasFrecuentes.ajax.php').load();
            }else{
              swal({
                type: "error",
                title: "No se pudo eliminar esta consulta, por favot intente nuevamente.",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
              })
            }
          }//success
        });//ajax        
      }
  });//then
});//click btnEliminarProducto
//CREAR, EDITAR
$("#formConsultaFrecuente").submit(function(e){
  e.preventDefault();
  $(".overlay").removeClass('hidden');
  var formData = new FormData($("#formConsultaFrecuente")[0]);
  $.ajax({
    url: "ajax/consultaFrecuente.ajax.php",
    method: "POST",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta){
      console.log("respuesta", respuesta);
      if(respuesta == "ok"){
        swal({
          type: "success",
          title: "La consulta ha sido guardada correctamente",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
          }).then(function(result){
            if (result.value) {
                $("[data-dismiss=modal]").trigger("click");
                table.ajax.url('ajax/datatable-consultasFrecuentes.ajax.php').load();
                $('#formConsultaFrecuente').trigger("reset");                    
            }//if
          });//swall
      }else if(respuesta == "nombreRepetido"){
        swal({
          type: "error",
          title: "El título de la consulta que has ingresado ya existe, por favor ingrese otro título.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
                $("#nombreConsultaFrecuente").focus();
            }
        });
      }else{
        swal({
            type: "error",
            title: "Ha ocurrido un problema al crear esta consulta, por favor intente de nuevo.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
          });//swal
      }//else
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//submit formConsultaFrecuente