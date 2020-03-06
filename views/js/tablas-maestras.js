var table =	$('.tablasMaestras').DataTable({	    
	"language" : {
  		"url": "spanish.json"
		},
	'columnDefs': [
		{
			"targets": 2,
			"className": "text-center"
		}
	]
});//DataTable
$("#seleccioneTablas").change(function(){
	var codTablaMaestra = $(this).val();
	$(".divAgregar").html('');
	$(".modalAgregar").html('');
	var datos = new FormData();
	datos.append("codTablaMaestra",codTablaMaestra);
	$.ajax({
		url: "ajax/tablaMaestra.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			if(respuesta.bd_tabla_maestra == 'vtama_tipo_producto'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarTipoProducto" data-toggle="modal" data-target="#modalTipoProducto">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalTipoProducto" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formTipoProducto" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 class="modal-title" id="modalTituloTipoProducto" style="font-weight: bold;">Agregar tipo de producto</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Descripción"><i class="fa fa-product-hunt"></i></span>'+
                									'<input type="text" class="form-control input-lg" name="nombreTipoProducto" id="nombreTipoProducto" placeholder="Ingresar la descripción" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button id="guardarTipoProducto" type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoTipoProducto" name="codigoTipoProducto">'+
        							'<input type="hidden" id="accionTipoProducto" name="accionTipoProducto" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'        			
				);
				$(document).on("click","button.btnAgregarTipoProducto", function(){
					$('#formTipoProducto').trigger("reset");
					$("#modalTituloTipoProducto").html('Agregar tipo producto');
					$("#guardarTipoProducto").html('Guardar');
					$("#accionTipoProducto").val("crear");
				});//click btnAgregarCategoriaCliente
				$(".tablasMaestras tbody").on("click","button.btnEditarTipoProducto", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloTipoProducto").html('Editar tipo producto');
					$("#guardarTipoProducto").html('Guardar');
					$("#accionTipoProducto").val("editar");
					var codTipoProducto = $(this).attr("codTipoProducto");
					var datos = new FormData();
					datos.append("codTipoProducto",codTipoProducto);
					datos.append("accionTipoProducto","mostrar");
					$.ajax({
						url:"ajax/tipoProducto.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoTipoProducto").val(respuesta["cod_tipo_producto"]);
							$("#nombreTipoProducto").val(respuesta["dsc_tipo_producto"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarTipoProducto
				$(".tablasMaestras").on("click", ".btnEliminarTipoProducto", function(){
					var codigoTipoProducto = $(this).attr("codTipoProducto");
					$("#accionTipoProducto").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el tipo de producto?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar tipo de producto!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				              url:"ajax/tipoProducto.ajax.php",
				              method: "POST",
				              data: "accionTipoProducto="+$("#accionTipoProducto").val()+"&codigoTipoProducto="+codigoTipoProducto,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar este tipo de producto porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	});//then
				});//click btnEliminarTipoProducto
				//CREAR,EDITAR
				$(document).on("submit", "#formTipoProducto", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/tipoProducto.ajax.php",
					    method: "POST",
					    data: $("#formTipoProducto").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El tipo producto ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formTipoProducto').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formTipoProducto
			}else if(respuesta.bd_tabla_maestra == 'vtama_tipo_documento'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarTipoDocumento" data-toggle="modal" data-target="#modalTipoDocumento">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalTipoDocumento" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formTipoDocumento" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 class="modal-title" id="modalTituloTipoDocumento" style="font-weight: bold;">Agregar tipo de documento</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Descripción"><i class="fa fa-book"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreTipoDocumento" name="nombreTipoDocumento" placeholder="Ingresar la descripción" autofocus required>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoTipoDocumento" name="codigoTipoDocumento">'+
        							'<input type="hidden" id="accionTipoDocumento" name="accionTipoDocumento" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarTipoDocumento", function(){
					$('#formTipoDocumento').trigger("reset");
					$("#modalTituloTipoDocumento").html('Agregar tipo de documento');
					$("#guardarTipoDocumento").html('Guardar');
					$("#accionTipoDocumento").val("crear");
				});//click btnAgregarCategoriaCliente
				$(".tablasMaestras tbody").on("click","button.btnEditarTipoDocumento", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloTipoDocumento").html('Editar tipo de documento');
					$("#accionTipoDocumento").val("editar");
					var codTipoDocumento = $(this).attr("codTipoDocumento");
					var datos = new FormData();
					datos.append("codTipoDocumento",codTipoDocumento);
					datos.append("accionTipoDocumento","mostrar");
					$.ajax({
						url:"ajax/tipoDocumento.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoTipoDocumento").val(respuesta["cod_tipo_documento"]);
							$("#nombreTipoDocumento").val(respuesta["dsc_tipo_documento"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarTipoDocumento
				$(".tablasMaestras").on("click", ".btnEliminarTipoDocumento", function(){
					var codigoTipoDocumento = $(this).attr("codTipoDocumento");
					$("#accionTipoDocumento").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el tipo de documento?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar tipo de documento!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				              url:"ajax/tipoDocumento.ajax.php",
				              method: "POST",
				              data: "accionTipoDocumento="+$("#accionTipoDocumento").val()+"&codigoTipoDocumento="+codigoTipoDocumento,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar este tipo de documento porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	});//then
				});//click btnEliminarTipoDocumento
				//CREAR,EDITAR
				$(document).on("submit", "#formTipoDocumento", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/tipoDocumento.ajax.php",
					    method: "POST",
					    data: $("#formTipoDocumento").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El tipo de documento ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formTipoDocumento').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formCategoriaCliente
			}else if(respuesta.bd_tabla_maestra == 'vtama_categoria_cliente'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarCategoriaCliente" data-toggle="modal" data-target="#modalCategoriaCliente">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalCategoriaCliente" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formCategoriaCliente" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloCategoriaCliente" class="modal-title" style="font-weight: bold;">Agregar categoría de cliente</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-creative-commons"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreCategoriaCliente" name="nombreCategoriaCliente" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoCategoriaCliente" name="codigoCategoriaCliente">'+
        							'<input type="hidden" id="accionCategoriaCliente" name="accionCategoriaCliente" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarCategoriaCliente", function(){
					$('#formCategoriaCliente').trigger("reset");
					$("#modalTituloCategoriaCliente").html('Agregar categoría cliente');
					$("#guardarCategoriaCliente").html('Guardar');
					$("#accionCategoriaCliente").val("crear");
				});//click btnAgregarCategoriaCliente
				$(".tablasMaestras tbody").on("click","button.btnEditarCategoriaCliente", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloCategoriaCliente").html('Editar categoría cliente');
					$("#guardarCategoriaCliente").html('Guardar');
					$("#accionCategoriaCliente").val("editar");
					var codCategoriaCliente = $(this).attr("codCategoriaCliente");
					var datos = new FormData();
					datos.append("codCategoriaCliente",codCategoriaCliente);
					datos.append("accionCategoriaCliente","mostrar");
					$.ajax({
						url:"ajax/categoriaCliente.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoCategoriaCliente").val(respuesta["cod_categoria_cliente"]);
							$("#nombreCategoriaCliente").val(respuesta["dsc_categoria_cliente"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarCategoriaCliente
				$(".tablasMaestras").on("click", ".btnEliminarCategoriaCliente", function(){
					var codigoCategoriaCliente = $(this).attr("codCategoriaCliente");
					$("#accionCategoriaCliente").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar la categoría de cliente?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar categoría de cliente!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				              url:"ajax/categoriaCliente.ajax.php",
				              method: "POST",
				              data: "accionCategoriaCliente="+$("#accionCategoriaCliente").val()+"&codigoCategoriaCliente="+codigoCategoriaCliente,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar esta categoria de cliente porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarCategoriaCliente
				//CREAR,EDITAR
				$(document).on("submit", "#formCategoriaCliente", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/categoriaCliente.ajax.php",
					    method: "POST",
					    data: $("#formCategoriaCliente").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "La categoría cliente ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formCategoriaCliente').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formCategoriaCliente
			}else if(respuesta.bd_tabla_maestra == 'vtama_pais'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarPais" data-toggle="modal" data-target="#modalPais">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalPais" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formPais" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloPais" class="modal-title" style="font-weight: bold;">Agregar país</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-flag-o"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombrePais" name="nombrePais" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button id="guardarPais" type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoPais" name="codigoPais">'+
        							'<input type="hidden" id="accionPais" name="accionPais" value="crear">'+
     							'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarPais", function(){
					$('#formPais').trigger("reset");
					$("#modalTituloPais").html('Agregar país');
					$("#accionPais").val("crear");
				});//click btnAgregarPais
				$(".tablasMaestras tbody").on("click","button.btnEditarPais", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloPais").html('Editar país');
					$("#accionPais").val("editar");
					var codPais = $(this).attr("codPais");
					var datos = new FormData();
					datos.append("codPais",codPais);
					datos.append("accionPais","mostrar");
					$.ajax({
						url:"ajax/pais.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoPais").val(respuesta["cod_pais"]);
							$("#nombrePais").val(respuesta["dsc_pais"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarPais
				$(".tablasMaestras").on("click", ".btnEliminarPais", function(){
					var codigoPais = $(this).attr("codPais");
					$("#accionPais").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el pais?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar el país!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				            	url:"ajax/pais.ajax.php",
				              	method: "POST",
				              	data: "accionPais="+$("#accionPais").val()+"&codigoPais="+codigoPais,
				              	success:function(respuesta2){
				                	if(respuesta2 == 'ok'){
				                  		table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                	}else{
					                  	swal({
					                    	type: "error",
					                    	title: "No se puede eliminar éste país porque está siendo utilizado en otra ventana.",
					                    	showConfirmButton: true,
					                    	confirmButtonText: "Cerrar"
					                  	});
				                	}//else
				              	}//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarPais
				//CREAR,EDITAR
				$(document).on("submit", "#formPais", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/pais.ajax.php",
					    method: "POST",
					    data: $("#formPais").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El país ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formPais').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formPais
			}else if(respuesta.bd_tabla_maestra == 'vtama_estado_cotizacion'){
				$(".modalAgregar").append(
					'<div id="modalEstadoCotizacion" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formEstadoCotizacion" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 class="modal-title" style="font-weight: bold;">Editar estado cotización</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-lightbulb-o"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreEstadoCotizacion" name="nombreEstadoCotizacion" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
            								'<div class="form-group">'+
                   								'<div class="input-group" id="colorpickerEstadoCotizacion">'+
                									'<div class="input-group-addon">'+
									                	'<i></i>'+
									                '</div>'+
                									'<input type="text" id="colorEstadoCotizacion" name="colorEstadoCotizacion" class="form-control input-lg" placeholder="Seleccionar el color">'+
              									'</div>'+
            								'</div>'+
            								'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Detalle"><i class="fa fa-book"></i></span>'+
                									'<textarea class="form-control input-lg" placeholder="Ingresar el detalle" id="detalleEstadoCotizacion" name="detalleEstadoCotizacion"></textarea>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoEstadoCotizacion" name="codigoEstadoCotizacion">'+
        							'<input type="hidden" id="accionEstadoCotizacion" name="accionEstadoCotizacion" value="editar">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);//append modalAgregar
				$(".tablasMaestras tbody").on("click","button.btnEditarEstadoCotizacion", function(){
					$(".overlay").removeClass('hidden');
					var codEstadoCotizacion = $(this).attr("codEstadoCotizacion");
					var datos = new FormData();
					datos.append("codEstadoCotizacion",codEstadoCotizacion);
					datos.append("accionEstadoCotizacion","mostrar");
					$.ajax({
						url:"ajax/estadoCotizacion.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoEstadoCotizacion").val(respuesta["cod_estado_cotizacion"]);
							$("#nombreEstadoCotizacion").val(respuesta["dsc_estado_cotizacion"]);
							if(respuesta["dsc_color"] != null){
								$("#colorEstadoCotizacion").val(respuesta["dsc_color"]).trigger("change");
							}else{
								$("#colorEstadoCotizacion").val('#fff').trigger("change");
								$("#colorEstadoCotizacion").val(respuesta["dsc_color"])
							}
							$("#detalleEstadoCotizacion").val(respuesta["dsc_detalle"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
					$('#colorpickerEstadoCotizacion').colorpicker();
				});//Click btnEditarTipoDocumento
				//CREAR,EDITAR
				$(document).on("submit", "#formEstadoCotizacion", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/estadoCotizacion.ajax.php",
					    method: "POST",
					    data: $("#formEstadoCotizacion").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El estado cotización ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formEstadoCotizacion').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formCategoriaCliente
			}else if(respuesta.bd_tabla_maestra == 'vtama_perfil'){
				$(".modalAgregar").append(
					'<div id="modalPerfil" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formPerfil" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 class="modal-title" style="font-weight: bold;">Editar perfil</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre del perfil"><i class="fa fa-bar-chart"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombrePerfil" name="nombrePerfil" placeholder="Ingresar el nombre del perfil" required autofocus>'+
              									'</div>'+
            								'</div>'+            								
            								'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Detalle"><i class="fa fa-book"></i></span>'+
                									'<textarea class="form-control input-lg" placeholder="Ingresar el detalle" id="detallePerfil" name="detallePerfil"></textarea>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoPerfil" name="codigoPerfil">'+
        							'<input type="hidden" id="accionPerfil" name="accionPerfil" value="editar">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);//append modalAgregar
				$(".tablasMaestras tbody").on("click","button.btnEditarPerfil", function(){
					$(".overlay").removeClass('hidden');
					var codPerfil = $(this).attr("codPerfil");
					var datos = new FormData();
					datos.append("codPerfil",codPerfil);
					datos.append("accionPerfil","mostrar");
					$.ajax({
						url:"ajax/perfil.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoPerfil").val(respuesta["cod_perfil"]);
							$("#nombrePerfil").val(respuesta["dsc_perfil"]);
							$("#detallePerfil").val(respuesta["dsc_detalle"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarPerfil
				//CREAR,EDITAR
				$(document).on("submit", "#formPerfil", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/perfil.ajax.php",
					    method: "POST",
					    data: $("#formPerfil").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El perfil ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formPerfil').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formPerfil
			}else if(respuesta.bd_tabla_maestra == 'vtama_moneda'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarMoneda" data-toggle="modal" data-target="#modalMoneda">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalMoneda" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formMoneda" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloMoneda" class="modal-title" style="font-weight: bold;">Agregar moneda</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-money"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreMoneda" name="nombreMoneda" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
            								'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Símbolo"><i class="fa fa-gg"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="simboloMoneda" name="simboloMoneda" placeholder="Ingresar el símbolo">'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoMoneda" name="codigoMoneda">'+
        							'<input type="hidden" id="accionMoneda" name="accionMoneda" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);//append modalAgregar
				$(document).on("click","button.btnAgregarMoneda", function(){
					$('#formMoneda').trigger("reset");
					$("#modalTituloMoneda").html('Agregar moneda');
					$("#accionMoneda").val("crear");
				});//click btnAgregarPais
				$(".tablasMaestras tbody").on("click","button.btnEditarMoneda", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloMoneda").html('Editar país');
					$("#accionMoneda").val("editar");
					var codMoneda = $(this).attr("codMoneda");
					var datos = new FormData();
					datos.append("codMoneda",codMoneda);
					datos.append("accionMoneda","mostrar");
					$.ajax({
						url:"ajax/moneda.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoMoneda").val(respuesta["cod_moneda"]);
							$("#nombreMoneda").val(respuesta["dsc_moneda"]);
							$("#simboloMoneda").val(respuesta["dsc_simbolo"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarMoneda
				$(".tablasMaestras").on("click", ".btnEliminarMoneda", function(){
					var codigoMoneda = $(this).attr("codMoneda");
					$("#accionMoneda").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar la moneda?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar la moneda!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				            	url:"ajax/moneda.ajax.php",
				              	method: "POST",
				              	data: "accionMoneda="+$("#accionMoneda").val()+"&codigoMoneda="+codigoMoneda,
				              	success:function(respuesta2){
				                	if(respuesta2 == 'ok'){
				                  		table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                	}else{
					                  	swal({
					                    	type: "error",
					                    	title: "No se puede eliminar ésta moneda porque está siendo utilizado en otra ventana.",
					                    	showConfirmButton: true,
					                    	confirmButtonText: "Cerrar"
					                  	});
				                	}//else
				              	}//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarMoneda
				//CREAR,EDITAR
				$(document).on("submit", "#formMoneda", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/moneda.ajax.php",
					    method: "POST",
					    data: $("#formMoneda").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "La moneda ha sido guardada correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formMoneda').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formMoneda
			}else if(respuesta.bd_tabla_maestra == 'vtama_forma_pago'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarFormaPago" data-toggle="modal" data-target="#modalFormaPago">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalFormaPago" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formFormaPago" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloFormaPago" class="modal-title" style="font-weight: bold;">Agregar forma de pago</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-shopping-cart"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreFormaPago" name="nombreFormaPago" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoFormaPago" name="codigoFormaPago" value="crear">'+
        							'<input type="hidden" id="accionFormaPago" name="accionFormaPago" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);//append modalAgregar
				$(document).on("click","button.btnAgregarFormaPago", function(){
					$('#formFormaPago').trigger("reset");
					$("#modalTituloFormaPago").html('Agregar forma de pago');
					$("#accionFormaPago").val("crear");
				});//click btnAgregarFormaPago
				$(".tablasMaestras tbody").on("click","button.btnEditarFormaPago", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloFormaPago").html('Editar forma de pago');
					$("#accionFormaPago").val("editar");
					var codFormaPago = $(this).attr("codFormaPago");
					var datos = new FormData();
					datos.append("codFormaPago",codFormaPago);
					datos.append("accionFormaPago","mostrar");
					$.ajax({
						url:"ajax/formaPago.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoFormaPago").val(respuesta["cod_forma_pago"]);
							$("#nombreFormaPago").val(respuesta["dsc_forma_pago"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarFormaPago
				$(".tablasMaestras").on("click", ".btnEliminarFormaPago", function(){
					var codigoFormaPago = $(this).attr("codFormaPago");
					$("#accionFormaPago").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar la forma de pago?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar el país!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				            	url:"ajax/formaPago.ajax.php",
				              	method: "POST",
				              	data: "accionFormaPago="+$("#accionFormaPago").val()+"&codigoFormaPago="+codigoFormaPago,
				              	success:function(respuesta2){
				                	if(respuesta2 == 'ok'){
				                  		table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                	}else{
					                  	swal({
					                    	type: "error",
					                    	title: "No se puede eliminar ésta forma de pago porque está siendo utilizado en otra ventana.",
					                    	showConfirmButton: true,
					                    	confirmButtonText: "Cerrar"
					                  	});
				                	}//else
				              	}//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarPais
				//CREAR,EDITAR
				$(document).on("submit", "#formFormaPago", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/formaPago.ajax.php",
					    method: "POST",
					    data: $("#formFormaPago").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "La forma de pago ha sido guardada correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formFormaPago').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formFormaPago
			}else if(respuesta.bd_tabla_maestra == 'vtama_canal_contacto'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarCanalContacto" data-toggle="modal" data-target="#modalCanalContacto">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalCanalContacto" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formCanalContacto" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloCanalContacto" class="modal-title" style="font-weight: bold;">Agregar canal contacto</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Descripción"><i class="fa fa-creative-commons"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreCanalContacto" name="nombreCanalContacto" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button id="guardarCanalContacto" type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoCanalContacto" name="codigoCanalContacto">'+
        							'<input type="hidden" id="accionCanalContacto" name="accionCanalContacto" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarCanalContacto", function(){
					$('#formCanalContacto').trigger("reset");
					$("#modalTituloCanalContacto").html('Agregar canal contacto');
					$("#guardarCanalContacto").html('Guardar');
					$("#accionCanalContacto").val("crear");
				});//click btnAgregarCanalContacto
				$(".tablasMaestras tbody").on("click","button.btnEditarCanalContacto", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloCanalContacto").html('Editar canal contacto');
					$("#guardarCanalContacto").html('Guardar');
					$("#accionCanalContacto").val("editar");
					var codCanalContacto = $(this).attr("codCanalContacto");
					var datos = new FormData();
					datos.append("codCanalContacto",codCanalContacto);
					datos.append("accionCanalContacto","mostrar");
					$.ajax({
						url:"ajax/canalContacto.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoCanalContacto").val(respuesta["cod_canal_contacto"]);
							$("#nombreCanalContacto").val(respuesta["dsc_canal_contacto"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarCanalContacto
				$(".tablasMaestras").on("click", ".btnEliminarCanalContacto", function(){
					var codigoCanalContacto = $(this).attr("codCanalContacto");
					$("#accionCanalContacto").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el canal de contacto?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar canal de contacto!'
				      }).then(function(result){
				        if (result.value) {
				            $.ajax({
				              url:"ajax/canalContacto.ajax.php",
				              method: "POST",
				              data: "accionCanalContacto="+$("#accionCanalContacto").val()+"&codigoCanalContacto="+codigoCanalContacto,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar este canal de contacto porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarCanalContacto
				//CREAR,EDITAR
				$(document).on("submit", "#formCanalContacto", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/canalContacto.ajax.php",
					    method: "POST",
					    data: $("#formCanalContacto").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El canal contacto ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formCanalContacto').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formCanalContacto
			}else if(respuesta.bd_tabla_maestra == 'vtama_estado_contacto'){
				$(".divAgregar").append(		
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarEstadoContacto" data-toggle="modal" data-target="#modalEstadoContacto">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalEstadoContacto" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formEstadoContacto" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloEstadoContacto" class="modal-title" style="font-weight: bold;">Agregar estado contacto</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-bolt"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreEstadoContacto" name="nombreEstadoContacto" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button id="guardarEstadoContacto" type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoEstadoContacto" name="codigoEstadoContacto">'+
        							'<input type="hidden" id="accionEstadoContacto" name="accionEstadoContacto" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarEstadoContacto", function(){
					$('#formEstadoContacto').trigger("reset");
					$("#modalTituloEstadoContacto").html('Agregar estado contacto');
					$("#guardarEstadoContacto").html('Guardar');
					$("#accionEstadoContacto").val("crear");
				});//click btnAgregarEstadoContacto
				$(".tablasMaestras tbody").on("click","button.btnEditarEstadoContacto", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloEstadoContacto").html('Editar estado contacto');
					$("#guardarEstadoContacto").html('Guardar');
					$("#accionEstadoContacto").val("editar");
					var codEstadoContacto = $(this).attr("codEstadoContacto");
					var datos = new FormData();
					datos.append("codEstadoContacto",codEstadoContacto);
					datos.append("accionEstadoContacto","mostrar");
					$.ajax({
						url:"ajax/estadoContacto.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoEstadoContacto").val(respuesta["cod_estado_contacto"]);
							$("#nombreEstadoContacto").val(respuesta["dsc_estado_contacto"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarEstadoContacto
				$(".tablasMaestras").on("click", ".btnEliminarEstadoContacto", function(){
					var codigoEstadoContacto = $(this).attr("codEstadoContacto");
					$("#accionEstadoContacto").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el estado de contacto?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar estado de contacto!'
				      }).then(function(result){
				        if (result.value) {				          
				            $.ajax({
				              url:"ajax/estadoContacto.ajax.php",
				              method: "POST",
				              data: "accionEstadoContacto="+$("#accionEstadoContacto").val()+"&codigoEstadoContacto="+codigoEstadoContacto,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar este estado de contacto porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarEstadoContacto
				//CREAR,EDITAR
				$(document).on("submit", "#formEstadoContacto", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/estadoContacto.ajax.php",
					    method: "POST",
					    data: $("#formEstadoContacto").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El estado contacto ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formEstadoContacto').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formEstadoContacto
			}else if(respuesta.bd_tabla_maestra == 'vtama_tipo_contacto'){
				$(".divAgregar").append(
					'<br><button class="btn btn-primary btn-agregar-kq btnAgregarTipoContacto" data-toggle="modal" data-target="#modalTipoContacto">Agregar</button>'
				);
				$(".modalAgregar").append(
					'<div id="modalTipoContacto" class="modal fade" role="dialog">'+
						'<div class="modal-dialog">'+
							'<div class="modal-content">'+
     							'<form id="formTipoContacto" role="form" method="post">'+
     								'<div class="overlay overlay-kq hidden">'+
					                    '<i class="fa fa-refresh fa-spin fa-spin-kq"></i>'+
					                '</div>'+
        							'<div class="modal-header modal-header-kq-2">'+
        								'<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>'+
          								'<h4 id="modalTituloTipoContacto" class="modal-title" style="font-weight: bold;">Agregar tipo contacto</h4>'+
        							'</div>'+
        							'<div class="modal-body">'+
        								'<div class="box-body">'+          									
				            				'<div class="form-group">'+
                   								'<div class="input-group">'+
                									'<span class="input-group-addon" title="Nombre"><i class="fa fa-reorder"></i></span>'+
                									'<input type="text" class="form-control input-lg" id="nombreTipoContacto" name="nombreTipoContacto" placeholder="Ingresar el nombre" required autofocus>'+
              									'</div>'+
            								'</div>'+
				            			'</div>'+
				            		'</div>'+
				            		'<div class="modal-footer">'+
        								'<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>'+
        								'<button id="guardarTipoContacto" type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>'+
        							'</div>'+
        							'<input type="hidden" id="codigoTipoContacto" name="codigoTipoContacto">'+
        							'<input type="hidden" id="accionTipoContacto" name="accionTipoContacto" value="crear">'+
        						'</form>'+
        					'</div>'+
        				'</div>'+
        			'</div>'
				);
				$(document).on("click","button.btnAgregarTipoContacto", function(){
					$('#formTipoContacto').trigger("reset");
					$("#modalTituloTipoContacto").html('Agregar tipo contacto');
					$("#guardarTipoContacto").html('Guardar');
					$("#accionTipoContacto").val("crear");
				});//click btnAgregarTipoContacto
				$(".tablasMaestras tbody").on("click","button.btnEditarTipoContacto", function(){
					$(".overlay").removeClass('hidden');
					$("#modalTituloTipoContacto").html('Editar tipo contacto');
					$("#guardarTipoContacto").html('Guardar');
					$("#accionTipoContacto").val("editar");
					var codTipoContacto = $(this).attr("codTipoContacto");
					var datos = new FormData();
					datos.append("codTipoContacto",codTipoContacto);
					datos.append("accionTipoContacto","mostrar");
					$.ajax({
						url:"ajax/tipoContacto.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							$("#codigoTipoContacto").val(respuesta["cod_tipo_contacto"]);
							$("#nombreTipoContacto").val(respuesta["dsc_tipo_contacto"]);
							$(".overlay").addClass('hidden');
						}//success
					});//ajax
				});//Click btnEditarTipoContacto
				$(".tablasMaestras").on("click", ".btnEliminarTipoContacto", function(){
					var codigoTipoContacto = $(this).attr("codTipoContacto");
					$("#accionTipoContacto").val("eliminar");					
					swal({
				        title: '¿Está seguro de borrar el tipo de contacto?',
				        text: "¡Si no lo está puede cancelar la acción!",
				        type: 'warning',
				        showCancelButton: true,
				        confirmButtonColor: '#3085d6',
				        cancelButtonColor: '#d33',
				        cancelButtonText: 'Cancelar',
				        confirmButtonText: 'Si, borrar tipo de contacto!'
				      }).then(function(result){
				        if (result.value) {
				            $.ajax({
				              url:"ajax/tipoContacto.ajax.php",
				              method: "POST",
				              data: "accionTipoContacto="+$("#accionTipoContacto").val()+"&codigoTipoContacto="+codigoTipoContacto,
				              success:function(respuesta2){
				                if(respuesta2 == 'ok'){
				                  table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
				                }else{
				                  swal({
				                    type: "error",
				                    title: "No se puede eliminar este tipo de contacto porque está siendo utilizado en otra ventana.",
				                    showConfirmButton: true,
				                    confirmButtonText: "Cerrar"
				                  })
				                }
				              }//success
				            });//ajax
				        }//if
				  	})//then
				});//click btnEliminarTipoContacto
				//CREAR,EDITAR
				$(document).on("submit", "#formTipoContacto", function(e){
					e.preventDefault();
					$(".overlay").removeClass('hidden');
					$.ajax({
					    url:"ajax/tipoContacto.ajax.php",
					    method: "POST",
					    data: $("#formTipoContacto").serialize(),
					    success: function(respuesta2){
					    	if(respuesta2 == "ok"){
						        swal({
						            type: "success",
						            title: "El tipo contacto ha sido guardado correctamente",
						            showConfirmButton: true,
						          	confirmButtonText: "Cerrar"
						        }).then(function(result){
						            if (result.value) {
						            	$("[data-dismiss=modal]").trigger("click");
						            	table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
						            	$('#formTipoContacto').trigger("reset");
						         	}
						        })
						    }//if 
						    $(".overlay").addClass('hidden');
					    }//success
					});//ajax
				});//submit formTipoContacto
			}
			table.ajax.url('ajax/datatable-tablasMaestras.ajax.php?bd='+respuesta.bd_tabla_maestra).load();
		}//success
	});//ajax
});//seleccioneTablas

