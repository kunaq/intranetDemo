if($("#perfilAdministradorCliente").val() == 'SI'){
	var table = $('.tablaCliente').DataTable( {
	    "ajax": "ajax/datatable-clientes.ajax.php",
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
		'columnDefs': [
			{
				targets: [0,1,2,3,4,5,6,7],
				className: "vertical-middle-kq",
			},
			{
		        targets: 8,
		        className:"vertical-middle-kq text-center"
	      	}
		]
	});//DataTable tablaCliente
}else{
	var table = $('.tablaCliente').DataTable( {
	    "ajax": "ajax/datatable-clientes.ajax.php",
	    "deferRender": true,
		"retrieve": true,
		"processing": true,
		"language" : {
	      "url": "spanish.json"
	  	},
		'columnDefs': [
			{
				targets: [0,1,2,3,4,5,6,7],
				className: "vertical-middle-kq",
			},
			{
		        targets: 8,
		        className:"hidden"
	      	}
		]
	});//DataTable tablaCliente
}//eñlse
/*=============================================
CAPTURANDO EL PAIS PARA ASIGNAR LOS DEPARTAMENTOS
=============================================*/
var contadorPais = 0;
$("#paisCliente").change(function(){
	var codPais = $(this).val();
	var datos = new FormData();
	datos.append("codPais",codPais);
	$.ajax({
		url: "ajax/departamento.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(respuesta){
			$(".formDepartamentoCliente").children('.select2DepartamentoCliente').children("#departamentoCliente").children().remove();
			if(respuesta.length != 0){
				$(".formDepartamentoCliente").children(".vacioDepartamentoCliente").addClass('hide');
				$(".formDepartamentoCliente").children(".select2DepartamentoCliente").removeClass('hide');
				$("#departamentoCliente").append('<option disabled selected>Seleccione un departamento</option>');
				$.each(respuesta, function(key,value){
					$("#departamentoCliente").append(
						'<option value="'+value.cod_departamento+'">'+value.dsc_departamento+'</option>'
					)
				});//each
				if(contadorPais == 0 && $("#editarCodDepartamento").val() != ''){
					$("#departamentoCliente").val($("#editarCodDepartamento").val()).trigger('change');
				}
				contadorPais++;
			}else{
				$("#departamentoCliente").children().remove();
				$("#provinciaCliente").children().remove();
				$("#distritoCliente").children().remove();
				$(".formDepartamentoCliente").children('.select2DepartamentoCliente').addClass('hide');
				$(".formProvinciaCliente").children('.select2ProvinciaCliente').addClass('hide');
				$(".formDistritoCliente").children('.select2DistritoCliente').addClass('hide');
				$(".formDepartamentoCliente").children(".vacioDepartamentoCliente").removeClass('hide');
				$(".formProvinciaCliente").children(".vacioProvinciaCliente").removeClass('hide');
				$(".formDistritoCliente").children(".vacioDistritoCliente").removeClass('hide');
				$(".overlay").addClass('hidden');
			}
		}//success
	});//ajax
});//change paisCliente
/*=============================================
CAPTURANDO EL PAIS PARA ASIGNAR LAS PROVINCIAS
=============================================*/
var contadorDepartamento = 0;
$("#departamentoCliente").change(function(){
	var codPais = $("#paisCliente").val();
	var codDepartamento = $(this).val();
	var datos = new FormData();
	datos.append("codPais",codPais);
	datos.append("codDepartamento",codDepartamento);
	$.ajax({
		url: "ajax/provincia.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(respuesta){
			$(".formProvinciaCliente").children('.select2ProvinciaCliente').children("#provinciaCliente").children().remove();
			if(respuesta.length != 0){
				$(".formProvinciaCliente").children(".vacioProvinciaCliente").addClass('hide');
				$(".formProvinciaCliente").children(".select2ProvinciaCliente").removeClass('hide');
				$("#provinciaCliente").append('<option disabled selected>Seleccione una provincia</option>');
				$.each(respuesta, function(key,value){
					$("#provinciaCliente").append(
						'<option value="'+value.cod_provincia+'">'+value.dsc_provincia+'</option>'
					);
				});//each
				if(contadorDepartamento == 0 && $("#editarCodProvincia").val() != ''){
					$("#provinciaCliente").val($("#editarCodProvincia").val()).trigger('change');
				}
				contadorDepartamento++;
			}else{
				$("#provinciaCliente").children().remove();
				$("#distritoCliente").children().remove();
				$(".formProvinciaCliente").children('.select2ProvinciaCliente').addClass('hide');
				$(".formProvinciaCliente").children('.vacioProvinciaCliente').removeClass('hide');
			}
			$(".formDistritoCliente").children('.select2DistritoCliente').addClass('hide');
			$(".formDistritoCliente").children('.vacioDistritoCliente').removeClass('hide');
		}//success
	});//ajax
});//departamentoCliente change 
/*=============================================
CAPTURANDO LA PROVINCIA PARA ASIGNAR LOS DISTRITOS
=============================================*/
var contadorProvincia = 0;
$("#provinciaCliente").change(function(){
	var codPais = $("#paisCliente").val();
	var codDepartamento = $("#departamentoCliente").val();
	var codProvincia = $(this).val();
	var datos = new FormData();
	datos.append("codPais",codPais);
	datos.append("codDepartamento",codDepartamento);
	datos.append("codProvincia",codProvincia);
	$.ajax({
		url: "ajax/distrito.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(respuesta){
			$(".formDistritoCliente").children('.select2DistritoCliente').children("#distritoCliente").children().remove();
			if(respuesta.length != 0){
				$(".formDistritoCliente").children(".vacioDistritoCliente").addClass('hide');
				$(".formDistritoCliente").children(".select2DistritoCliente").removeClass('hide');
				$("#distritoCliente").append('<option disabled selected>Seleccione un distrito</option>');
				$.each(respuesta, function(key,value){
					$("#distritoCliente").append(
						'<option value="'+value.cod_distrito+'">'+value.dsc_distrito+'</option>'
					);
				});//each
				if(contadorProvincia == 0  && $("#editarCodDistrito").val() != ''){
					$("#distritoCliente").val($("#editarCodDistrito").val()).trigger('change');
				}
				contadorProvincia++;
			}else{
				$("#distritoCliente").children().remove();
				$(".formDistritoCliente").children('.selectselect2DistritoCliente2Distrito').addClass('hide');
				$(".formDistritoCliente").children(".vacioDistritoCliente").removeClass('hide');
			}
			$(".overlay").addClass('hidden');
		}//success
	});//ajax
});//change provinciaCliente
/*=============================================
AGREGAR CLIENTE
=============================================*/
$(".btnAgregarCliente").click(function(){
	$('#formCliente').trigger("reset"); 
	$("#editarCodDepartamento").val('');
	$("#paisCliente").val('').trigger('change');
	$("#modalTituloCliente").html('Agregar cliente');
	$("#accionCliente").val("crear");
});//click btnAgregarCliente
/*=============================================
OBTENER DATOS EDITAR CLIENTE
=============================================*/
$(".tablaCliente").on("click", ".btnEditarCliente", function(){
	contadorDepartamento = 0;
	contadorPais = 0;
	contadorProvincia = 0;
	$(".overlay").removeClass('hidden');
	$("#modalTituloCliente").html('Editar cliente');
	$("#accionCliente").val("editar");
	var codCliente = $(this).attr("codCliente");
	var datos = new FormData();
	datos.append("codCliente",codCliente);
	$.ajax({
		url:"ajax/clientes.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      		$("#documentoCliente").val(respuesta["dsc_documento"]);
      		$("#nombreCliente").val(respuesta["dsc_razon_social"]);
      		$("#direccionCliente").val(respuesta["dsc_direccion"]);
      		$("#categoriaCliente").val(respuesta["cod_categoria_cliente"]);
      		$("#formaPagoCliente").val(respuesta["cod_forma_pago"]);
      		$("#paisCliente").val(respuesta["cod_pais"]).trigger('change');
      		$("#editarCodDepartamento").val(respuesta["cod_departamento"]);
      		$("#editarCodProvincia").val(respuesta["cod_provincia"]);
      		$("#editarCodDistrito").val(respuesta["cod_distrito"]);
      		$("#codigoCliente").val(respuesta["cod_cliente"]);
      	}//success
	});//ajax
});//click btnEditarCliente
/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablaCliente").on("click", ".btnEliminarCliente", function(){
	var codigoCliente = $(this).attr("codCliente");
	$("#accionCliente").val("eliminar");
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
    }).then(function(result){
        if (result.value) {
            $.ajax({
            	url:"ajax/clientes.ajax.php",
		      	method: "POST",
		      	data: "accionCliente="+$("#accionCliente").val()+"&codigoCliente="+codigoCliente,
		      	success:function(respuesta){
		      		if(respuesta == 'ok'){
		      			table.ajax.url('ajax/datatable-clientes.ajax.php').load();
		      		}else{
	                  swal({
	                    type: "error",
	                    title: "No se puede eliminar este cliente porque está siendo utilizado en otras ventanas.",
	                    showConfirmButton: true,
	                    confirmButtonText: "Cerrar"
	                  })
	                }
		      	}//success
            });//ajax
        }
  	});//then
});//click btnEliminarCliente
/*=============================================
CREAR,EDITAR CLIENTE
=============================================*/
$("#formCliente").submit(function(e){
	e.preventDefault();
	$(".overlay").removeClass('hidden');
	$.ajax({
		url:"ajax/clientes.ajax.php",
      	method: "POST",
      	data: $("#formCliente").serialize(),
      	dataType:"json",
      	success:function(respuesta){
      		console.log("respuesta", respuesta["respuesta"]);
      		//console.log("respuesta", respuesta["respuesta"]);
      		if(respuesta["respuesta"] == 'ok'){
      		 	swal({
			  		type: "success",
			  		title: "El cliente ha sido guardado correctamente",
			  		showConfirmButton: true,
					confirmButtonText: "Cerrar"
			  	}).then(function(result){
					if (result.value) {
						$("[data-dismiss=modal]").trigger("click");
						if($("#direccionClienteCotizacion").length){
							//COTIZACION
							$("#rucClienteCotizacion").val($("#nuevoDocumento").val());
							$("#direccionClienteCotizacion").val($("#nuevaDireccion").val());
							$("#clienteCotizacion").append('<option value="'+respuesta["codigo"]+'">'+respuesta["nombre"]+'</option>');
							$("#clienteCotizacion").val(respuesta["codigo"]).trigger('change');	
						}else if($("#codigoContacto").length){
							//CONTACTO
							$("#clienteContacto").append('<option value="'+respuesta["codigo"]+'">'+respuesta["nombre"]+'</option>');
							$("#clienteContacto").val(respuesta["codigo"]).trigger('change');
						}else if($("#numOrdPrd").length){
							//ORDEN DE PRODUCCION
							$("#clienteOrdProd").append('<option value="'+respuesta["codigo"]+'">'+respuesta["nombre"]+'</option>');
							$("#clienteOrdProd").val(respuesta["codigo"]).trigger('change');	
						}else{
							//CLIENTE
							table.ajax.url('ajax/datatable-clientes.ajax.php').load();
						}
						$('#formCliente').trigger("reset"); 
		      		 	$("#paisCliente").val('').trigger('change');
					}//if
				});//then
      		}else if(respuesta["respuesta"] == 'documentoRepetido'){
      			swal({
		        	type: "error",
		        	title: "El RUC que has ingresado ya existe, por favor ingrese otro RUC.",
		        	showConfirmButton: true,
		        	confirmButtonText: "Cerrar"
		        }).then(function(result){
		            if (result.value) {
		              	$("#documentoCliente").focus();
		            }
		        });
      		}else{
        		swal({
		            type: "error",
		            title: "Ha ocurrido un problema al guardar, por favor intente de nuevo.",
		            showConfirmButton: true,
		            confirmButtonText: "Cerrar"
          		});//swal
      		}//else
      		$(".overlay").addClass('hidden');
      	}//success
	});//ajax
});//click guardarCliente