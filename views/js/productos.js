if($("#perfilAdministradorProducto").val() == 'SI'){
  var table = $('.tablaProducto').DataTable( {
    "ajax": "ajax/datatable-productos.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
      "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": 4,
        "className": "text-center"
      }
    ]
  });//DataTable tablaProducto
}else{
  var table = $('.tablaProducto').DataTable( {
    "ajax": "ajax/datatable-productos.ajax.php",
    "deferRender": true,
    "retrieve": true,
    "processing": true,
    "language" : {
      "url": "spanish.json"
    },
    'columnDefs': [
      {
        "targets": 4,
        "className": "hidden"
      }
    ]
  });//DataTable tablaProducto
}//else
/*=============================================
EDITAR PRODUCTO
=============================================*/
$(".tablaProducto").on("click", ".btnEditarProducto", function(){
  $(".overlay").removeClass('hidden');
  $("#modalTituloProducto").html('Editar producto');
  $("#accionProducto").val("editar");
	var codProducto = $(this).attr("codProducto");
	var datos = new FormData();
	datos.append("codProducto",codProducto);
	$.ajax({
		url:"ajax/productos.ajax.php",
  	method: "POST",
  	data: datos,
  	cache: false,
  	contentType: false,
  	processData: false,
  	dataType:"json",
  	success:function(respuesta){
  		$("#codigoProducto").val(respuesta["cod_producto"]);
  		$("#tipoProducto").val(respuesta["cod_tipo_producto"]).trigger('change');
  		$("#nombreProducto").val(respuesta["dsc_producto"]);
  		$("#observacionProducto").val(respuesta["dsc_detalle"]);
      $(".overlay").addClass('hidden');    
    }//success
	});//ajax
});//tablas click btnEditarProducto
/*=============================================
ELIMINAR PRODUCTO
=============================================*/
$(".tablaProducto").on("click", ".btnEliminarProducto", function(){
	var codigoProducto = $(this).attr("codProducto");
  $("#accionProducto").val("eliminar");	
	swal({
    title: '¿Está seguro de borrar el producto?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar producto!'
  }).then(function(result){
      if (result.value) {        
        $.ajax({
          url:"ajax/productos.ajax.php",
          method: "POST",
          data: "accionProducto="+$("#accionProducto").val()+"&codigoProducto="+codigoProducto,
          success:function(respuesta){
            if(respuesta == 'ok'){
              table.ajax.url('ajax/datatable-productos.ajax.php').load();
            }else{
              swal({
                type: "error",
                title: "No se puede eliminar este producto porque está siendo utilizado en otra ventana.",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
              })
            }
          }//success
        });//ajax        
      }
  });//then
});//click btnEliminarProducto
/*=============================================
AGREGAR PRODUCTO
=============================================*/
$(".btnAgregarProducto").click(function(){
  $('#formProducto').trigger("reset");
  $("#tipoProducto").val('').trigger('change');
  $("#modalTituloProducto").html('Agregar producto');
  $("#accionProducto").val("crear");
});//click btnAgregarProducto
/*=============================================
CREAR,EDITAR PRODUCTO
=============================================*/
$("#formProducto").submit(function(e){
  e.preventDefault();
  $(".overlay").removeClass('hidden');
  $.ajax({
    url:"ajax/productos.ajax.php",
    method: "POST",
    data: $("#formProducto").serialize(),
    success:function(respuesta){
      //console.log("respuesta", respuesta);
      if(respuesta == "ok"){
        swal({
          type: "success",
          title: "El producto ha sido guardado correctamente",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            $("[data-dismiss=modal]").trigger("click");
            table.ajax.url('ajax/datatable-productos.ajax.php').load();
            $('#formProducto').trigger("reset");
            $("#tipoProducto").val('').trigger('change');
          }
        })
      }else if(respuesta == "nombreRepetido"){
        swal({
          type: "error",
          title: "La descripción que has ingresado ya existe, por favor ingrese otra descripción.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
              $("#nombreProducto").focus();
            }
        });
        }
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//click guardarProducto